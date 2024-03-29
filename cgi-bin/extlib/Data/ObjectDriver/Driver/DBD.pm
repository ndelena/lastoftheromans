# $Id: DBD.pm 333 2007-02-13 00:48:19Z miyagawa $

package Data::ObjectDriver::Driver::DBD;
use strict;
use warnings;


sub new {
    my $class = shift;
    my($name) = @_;
    die "No Driver" unless $name;
    my $subclass = join '::', $class, $name;
    unless (defined ${"${subclass}::"}) {
        eval "use $subclass"; ## no critic
        die $@ if $@;
    }
    bless {}, $subclass;
}

sub init_dbh { }
sub bind_param_attributes { }
sub db_column_name { $_[2] }
sub fetch_id { }
sub offset_implemented { 1 }
sub map_error_code { }

# SQL doesn't define a function to ask a machine of its time in
# unixtime form.  MySQL does, so we override this in the subclass.
# but for sqlite and others, we assume "remote" time is same as local
# machine's time, which is especially true for sqlite.
sub sql_for_unixtime { return time() }

# by default, LIMIT isn't supported on a DELETE.  MySql overrides.
sub can_delete_with_limit { 0 }

# searches are case sensitive by default.  MySql overrides.
sub is_case_insensitive { 0 }

sub can_replace { 0 }

sub sql_class { 'Data::ObjectDriver::SQL' }

1;

__END__

=head1 NAME

Data::ObjectDriver::Driver::DBD - base class for database drivers

=head1 SYNOPSIS

    package SomeObject;
    use base qw( Data::ObjectDriver::BaseObject );

    __PACKAGE__->install_properties({
        ...
        driver => Data::ObjectDriver::Driver::DBI->new(
            ...
            dbd => Data::ObjectDriver::Driver::DBD->new('mysql'),
        ),
    });

=head1 DESCRIPTION

I<Data::ObjectDriver::Driver::DBD> is the base class for I<database> drivers.
Database drivers handle the peculiarities of specific database servers to
provide an abstract API to the I<object> drivers. While database drivers
operate on queries and database concepts like the last insert ID and binding
attributes for a query, object drivers operate on objects higher level concepts
like caching and partitioning.

Database drivers are used with C<Data::ObjectDriver::Driver::DBI> object
drivers. If you are making an object driver that doesn't use C<DBI>, you do not
need a database driver; implement your custom behavior in your
C<Data::ObjectDriver> subclass directly.

=head1 USAGE

=head2 C<Data::ObjectDriver::Driver::DBD-E<gt>new($name)>

Creates a new database driver of the given subclass type. That is,
C<new('mysql')> would create a new instance of
C<Data::ObjectDriver::Driver::DBD::mysql>.

=head2 C<$dbd-E<gt>init_dbh($dbh)>

Initializes the given database handle connected to this driver's type of
database.

By default, no operation is performed. Override this method if your type of
database must do further initialization that other database servers don't need,
such as setting an operative time zone.

=head2 C<$dbd-E<gt>bind_param_attributes($type)>

Returns a hashref to pass to the C<DBI> statement method C<bind_param>, to
describe the SQL type of a column defined as C<$type> in an object class's
C<column_defs> mapping.

By default, no operation is performed. Override this method if your type of
database needs such type hinting for some fields, such as specifying a
parameter is a C<BLOB>.

Note that object classes must define your custom types in their C<column_defs>
mappings for those classes to be compatible with your C<DBD>. Make sure to
document any custom types you implement.

=head2 C<$dbd-E<gt>db_column_name($datasource, $column)>

Returns a decorated column name. For example, if your database requires column
names to be prepended with table names, that concatenation would occur in this
method.

By default, C<db_column_name> returns the column name unmodified.

=head2 C<$dbd-E<gt>fetch_id()>

Returns the autogenerated ID of the most recently inserted record, or C<undef>
if this feature is not supported.

By default, C<fetch_id> returns C<undef>.

=head2 C<$dbd-E<gt>map_error_code($code, $msg)>

Returns a C<Data::ObjectDriver::Errors> code for the given database error, or
C<undef> if no equivalent has been defined.

By default, C<map_error_code> returns C<undef> for every error.

=head2 C<$dbd-E<gt>sql_for_unixtime()>

Returns the SQL for querying the current UNIX time on the database server, or a
UNIX time to use as the remote time.

By default, C<sql_for_unixtime> returns the value of perl C<time()> on the
local machine.

=head2 C<$dbd-E<gt>offset_implemented()>

Returns true if the database this driver represents supports C<OFFSET> clauses.

By default, C<offset_implemented> returns true.

=head2 C<$dbd-E<gt>can_delete_with_limit()>

Returns true if the database this driver represents supports C<LIMIT> clauses
on C<DELETE> statements.

By default, C<can_delete_with_limit> returns false.

=head2 C<$dbd-E<gt>is_case_insensitive()>

Returns true if the database this driver represents normally compares string
fields case insensitively.

By default, C<is_case_insensitive> returns false.

=head2 C<$dbd-E<gt>can_replace()>

Returns true or false if the driver can do "REPLACE INTO" only Mysql and
SQLite does. By default returns false.

=head2 C<$dbd-E<gt>sql_class()>

Provides the package name of the class responsible for representing SQL
queries. This method returns 'Data::ObjectDriver::SQL', but may be
overridden to return a package that has a similar interface but produces
SQL that is compatible with that DBD driver. The package provided must
already be loaded and available for use.

=head1 LICENSE

I<Data::ObjectDriver> is free software; you may redistribute it and/or modify
it under the same terms as Perl itself.

=head1 AUTHOR & COPYRIGHT

Except where otherwise noted, I<Data::ObjectDriver> is Copyright 2005-2006
Six Apart, cpan@sixapart.com. All rights reserved.

=cut

