<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtentrymodifieddate.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtentrymodifieddate($args, &$ctx) {
    $entry = $ctx->stash('entry');
    $args['ts'] = $entry['entry_modified_on'];
    $args['ts'] or $args['ts'] = $entry['entry_created_on'];
    return $ctx->_hdlr_date($args, $ctx);
}
?>
