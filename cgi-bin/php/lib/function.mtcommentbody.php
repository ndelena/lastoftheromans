<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtcommentbody.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtcommentbody($args, &$ctx) {
    $comment = $ctx->stash('comment');
    $text = $comment['comment_text'];

    $blog = $ctx->stash('blog');
    if (!$blog['blog_allow_comment_html']) {
        $text = strip_tags($text);
    }
    $cb = isset($args['convert_breaks']) ? $args['convert_breaks'] : $blog['blog_convert_paras_comments'];
    if ($cb == '1' || $cb == '__default__') {
        $cb = 'convert_breaks';
    }
    if ($cb) {
        if ($ctx->load_modifier($cb)) {
            $mod = 'smarty_modifier_'.$cb;
            $text = $mod($text);
        }
    }
    if (isset($args['words'])) {
        require_once("MTUtil.php");
        return first_n_text($text, $args['words']);
    }
    if ($blog['blog_autolink_urls']) {
        $text = preg_replace('!(^|\s|>)(https?://[^\s<]+)!s', '$1<a href="$2">$2</a>', $text);
    }
    return $text;
}
?>
