<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mthasnoparentcategory.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_block_mthasnoparentcategory($args, $content, &$ctx, &$repeat) {
    if (!isset($content)) {
        require_once("MTUtil.php");
        $cat = get_category_context($ctx);
        $has_no_parent = !$cat['category_parent'] ? 1 : 0;
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $has_no_parent);
    } else {
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
}
?>
