<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtentrytitle.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtentrytitle($args, &$ctx) {
    $entry = $ctx->stash('entry');
    $title = $entry['entry_title'];
    if (empty($title)) {
        if (isset($args['generate']) && $args['generate']) {
            require_once("MTUtil.php");
            $title = first_n_text($entry['entry_text'], 5);
        }
    }
    return $title;
}
?>
