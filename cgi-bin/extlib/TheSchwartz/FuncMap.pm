# $Id: FuncMap.pm 1098 2007-12-12 01:47:58Z hachi $

package TheSchwartz::FuncMap;
use strict;
use base qw( Data::ObjectDriver::BaseObject );

use Carp qw( croak );

__PACKAGE__->install_properties({
               columns     => [ qw( funcid funcname ) ],
               datasource  => 'funcmap',
               primary_key => 'funcid',
           });

sub create_or_find {
    my $class = shift;
    my($driver, $funcname) = @_;

    ## Attempt to insert a new funcmap row. Since the funcname column is
    ## UNIQUE, if the row already exists, an exception will be thrown.
    my $map = $class->new;
    $map->funcname($funcname);
    eval { $driver->insert($map) };

    ## If we got an exception, try to load the record with this funcname;
    ## in all likelihood, the exception was that the record was added by
    ## another process.
    if (my $err = $@) {
        ($map) = $driver->search('TheSchwartz::FuncMap' =>
                { funcname => $funcname }
            ) or croak "Can't find or create funcname $funcname: $err";
    }
    return $map;
}

1;
