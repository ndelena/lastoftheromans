# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: Legacy.pm 1174 2008-01-08 21:02:50Z bchoate $

package MT::ObjectDriver::Driver::DBD::Legacy;

use strict;
use warnings;

## Be no kind of D::OD::DBD, so when mixed into a subclass, it will always
## use this db_column_name but not override, eg, D::OD::DBD::Pg's bind_param
## _attributes with the D::OD::DBD::bind_param_attributes we'd inherit.
use base qw();

sub ts2db { $_[1] }
sub db2ts { $_[1] }

my %Date_Cols = map { $_ => 1 } qw( created_on modified_on children_modified_on last_moved_on );
sub is_date_col { $Date_Cols{$_[1]} }
sub date_cols { keys %Date_Cols }

sub sql_class {
    require MT::ObjectDriver::SQL;
    return 'MT::ObjectDriver::SQL';
}

sub ddl_class {
    undef;
}

sub dsn_from_config {
    my $class = shift;
    my ($cfg) = @_;
    my $dbd_class = ref $class ? ref $class : $class;
    $dbd_class =~ s!.+::!!;
    my $dsn = 'dbi:' . $dbd_class;
    return $dsn;
}

sub new {
    my $class = shift;
    return bless {}, $class;
}

sub db_column_name {
    my $dbd = shift;
    my ($table, $col) = @_;
    $table =~ s{ \A mt_ }{}xms;
    return join('_', $table, $col);
}

sub configure {}

1;
__END__

=head1 NAME

MT::ObjectDriver::Driver::DBD::Legacy

=head1 METHODS

TODO

=head1 AUTHOR & COPYRIGHT

Please see L<MT/AUTHOR & COPYRIGHT>.

=cut
