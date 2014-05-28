<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtblogarchiveurl.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtblogarchiveurl($args, &$ctx) {
    // status: complete
    // parameters: none
    $blog = $ctx->stash('blog');
    $url = $blog['blog_archive_url'];
    if ($url == '') {
        $url = $blog['blog_site_url'];
    }
    if (!preg_match('/\/$/', $url)) $url .= '/';
    return $url;
}
?>
