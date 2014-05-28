<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtcgiserverpath.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtcgiserverpath($args, &$ctx) {
    // status: complete
    // parameters: none
    $path = $ctx->mt->config('MTDir');
    if (substr($path, strlen($path) - 1, 1) == '/')
        $path = substr($path, 1, strlen($path)-1);
    return $path;
}
?>
