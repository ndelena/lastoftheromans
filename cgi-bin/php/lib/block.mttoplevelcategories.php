<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mttoplevelcategories.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_block_mttoplevelcategories($args, $content, &$ctx, &$repeat) {
    if (!isset($content)) {
        $ctx->localize(array('category', 'archive_category'));
        $ctx->stash('category', null);
        $ctx->stash('archive_category', null);
        require_once("block.mtsubcategories.php");
        $args['top_level_categories'] = 1;
    }
    $result = smarty_block_mtsubcategories($args, $content, $ctx, $repeat);
    if (!$repeat) {
        $ctx->restore(array('category', 'archive_category'));
    }
    return $result;
}
?>
