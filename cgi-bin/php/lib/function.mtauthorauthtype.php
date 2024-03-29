<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtauthorauthtype.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtauthorauthtype($args, &$ctx) {
    $author = $ctx->stash('author');
    if (!$author) {
        return $ctx->error("No author available");
    }
    return isset($author['author_auth_type']) ? $author['author_auth_type'] : '';
}
?>
