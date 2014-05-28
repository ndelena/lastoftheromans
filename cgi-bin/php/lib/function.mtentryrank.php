<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtentryrank.php 1174 2008-01-08 21:02:50Z bchoate $

require_once('rating_lib.php');

function smarty_function_mtentryrank($args, &$ctx) {
    return hdlr_rank($ctx, 'entry', $args['namespace'], $args['max'],
        "AND (entry_status = 2)\n"
    );
}
?>
