<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtbloghost.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtbloghost($args, &$ctx) {
    // status: complete
    // parameters: exclude_port, signature
    $blog = $ctx->stash('blog');
    $host = $blog['blog_site_url'];
    if (!preg_match('!/$!', $host))
        $host .= '/';

    if (preg_match('!^https?://([^/:]+)(:\d+)?/!', $host, $matches)) {
        if ($args['signature']) {
            $sig = $matches[1];
            $sig = preg_replace('/\./', '_', $sig);
            return $sig;
        }
        return (isset($args['exclude_port']) && ($args['exclude_port'])) ? $matches[1] : $matches[1] . (isset($matches[2]) ? $matches[2] : '');
    } else {
        return '';
    }
}
?>
