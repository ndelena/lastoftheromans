<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mtcommententry.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_block_mtcommententry($args, $content, &$ctx, &$repeat) {
    $localvars = array('entry', 'current_timestamp', 'modification_timestamp');
    if (!isset($content)) {
        $comment = $ctx->stash('comment');
        if (!$comment) { $repeat = false; return ''; }
        $entry_id = $comment['comment_entry_id'];
        $method = 'fetch_entry';
        $entry_class = $comment['entry_class'];
        if (isset($entry_class)) {
            $method = 'fetch_' . $entry_class;
        }
        $entry = $ctx->mt->db->$method($entry_id);
        if (!$entry) { $repeat = false; return ''; }
        $ctx->localize($localvars);
        $ctx->stash('entry', $entry);
        $ctx->stash('current_timestamp', $entry['entry_authored_on']);
        $ctx->stash('modification_timestamp', $entry['entry_modified_on']);
    } else {
        $ctx->restore($localvars);
    }
    return $content;
}
?>
