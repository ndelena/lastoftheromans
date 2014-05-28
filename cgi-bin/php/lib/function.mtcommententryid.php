<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtcommententryid.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtcommententryid($args, &$ctx) {
    $comment = $ctx->stash('comment');
    $id = $comment['comment_entry_id'];
    if (isset($args['pad']) && $args['pad']) {
        $id = sprintf("%06d", $id);
    }
    return $id;
}
?>
