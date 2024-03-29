# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: Sync.pm 1174 2008-01-08 21:02:50Z bchoate $

package MT::Worker::Sync;

use strict;
use base qw( TheSchwartz::Worker );
use Time::HiRes qw(gettimeofday tv_interval);
use TheSchwartz::Job;
use MT::FileInfo;

sub work {
    my $class = shift;
    my TheSchwartz::Job $job = shift;

    my $sync_set = [gettimeofday];

    # Build this
    my $mt = MT->instance;

    my $rsync_cmd = MT->config("RsyncPath") || "rsync";
    my $rsync_opt = $mt->config('RsyncOptions') || '';
    my @targets = $mt->config('SyncTarget');

    # We got triggered to build; lets find coalescing jobs
    # and process them in one pass.

    my @jobs;
    push @jobs, $job;
    if (my $key = $job->coalesce) {
        while (my $job = MT::TheSchwartz->instance->find_job_with_coalescing_value($class, $key)) {
            push @jobs, $job;
        }
    }

    MT::TheSchwartz->debug("Syncing: " . scalar(@jobs) . " files...");

    my @files;
    my @static_fileinfo;
    foreach $job (@jobs) {
        my $fi_id = $job->uniqkey;
        my $fi = MT::FileInfo->load($fi_id);

        if ($fi && (-f $fi->file_path)) {
            ##MT::TheSchwartz->debug("Syncing: " . RebuildQueue::Daemon::_summary($fi));
            push @files, $fi->file_path;
            unless ($fi->template_id) {
                # static file
                push @static_fileinfo, $fi;
            }
        } else {
            if (!$fi) {
                # Don't know where the FileInfo record went. Oh well.
                $job->completed();
            } else {
                unless (-f $fi->file_path) {
                    MT::TheSchwartz->debug("Warning: couldn't locate file: " . $fi->file_path);
                    $job->permanent_failure("Couldn't locate file: " . $fi->file_path);
                }
            }
        }
    }

    my $synced = 0;
    if (@files) {
        $synced = scalar @files;
        require File::Spec;
        my $file = File::Spec->catfile($mt->config('TempDir'), "publishq-rsync-$$.lst");
        open FOUT, ">$file";
        print FOUT join("\n", @files) . "\n";
        close FOUT;
        foreach my $target (@targets) {
            my $cmd = "$rsync_cmd $rsync_opt --files-from=\"$file\" / \"$target\"";
            MT::TheSchwartz->debug("Syncing files to $target...");
            my $start = [gettimeofday];
            my $res = system $cmd;
            my $exit = $? >> 8;
            if ($exit != 0) {
                # TBD: notification to administrator
                # At the very least, log to MT activity log.
                my $errmsg = "Error during rsync of files in $file:\n"
                    . "Command (exit code $res): $cmd";
                MT::TheSchwartz->debug($errmsg);
                require MT::Log;
                $mt->log({
                    message => $errmsg,
                    metadata => $errmsg . "\nFiles affected:\n\t" . join("\n\t", @files),
                    category => "sync",
                    level => MT::Log::ERROR(),
                });

                $_->failed("Error during rsync") foreach @jobs;
                return;
            } else {
                MT::TheSchwartz->debug(sprintf("done! (%0.02fs)", tv_interval($start)));
            }
        }
        unlink $file;
        # clear sync flags...
        $_->remove foreach @static_fileinfo;
        $_->completed() foreach @jobs;
    }
    if ($synced) {
        MT::TheSchwartz->debug("-- set complete ($synced files in " . sprintf("%0.02f", tv_interval($sync_set)) . " seconds)");
    }
}

sub grab_for { 60 }
sub max_retries { 10 }
sub retry_delay { 60 }

1;
