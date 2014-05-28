<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mthasnosubcategories.php 1174 2008-01-08 21:02:50Z bchoate $

require_once("block.mthassubcategories.php");
function smarty_block_mthasnosubcategories($args, $content, &$ctx, &$repeat) {
    if (!isset($content)) {
        $has_no_sub_cats = !_has_sub_categories($ctx);
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $has_no_sub_cats);
    } else {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
}
?>
