<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mtifcommenterisauthor.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_block_mtifcommenterisauthor($args, $content, &$ctx, &$repeat) {
    # status: complete
    if (!isset($content)) {
        $cmtr = $ctx->stash('commenter');
        if (!isset($cmtr)) {
            return $ctx->_hdlr_if($args, $content, $ctx, $repeat, 0);
        }
        $is_author = $cmtr['author_type'] == 1 ? 1 : 0;
            return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $is_author);
    } else {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
}
?>
