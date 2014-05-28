#!/usr/bin/perl -w

# Movable Type (r) Open Source (C) 2005-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: l10nsample.cgi 1174 2008-01-08 21:02:50Z bchoate $

use strict;
use lib "lib", ($ENV{MT_HOME} ? "$ENV{MT_HOME}/lib" : "../../lib"); 
use MT::Bootstrap App => 'l10nsample';
