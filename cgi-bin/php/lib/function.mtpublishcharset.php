<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtpublishcharset.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtpublishcharset($args, &$ctx) {
    // Status: complete
    // parameters: none
    $charset = $ctx->mt->config('PublishCharset');
    $charset or $charset = 'utf-8';
    return $charset;
}
?>
