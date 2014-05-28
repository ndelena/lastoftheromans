<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtauthorauthiconurl.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtauthorauthiconurl($args, &$ctx) {
    $author = $ctx->stash('author');
    if (!$author) {
        return "";
    }
    require_once "function.mtstaticwebpath.php";
    $static_path = smarty_function_mtstaticwebpath($args, $ctx);
    require_once "commenter_auth_lib.php";
    return _auth_icon_url($static_path, $author);
}
?>
