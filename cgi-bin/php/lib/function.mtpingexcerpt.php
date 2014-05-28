<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtpingexcerpt.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtpingexcerpt($args, &$ctx) {
    $ping = $ctx->stash('ping');
    return $ping['tbping_excerpt'];
}
?>
