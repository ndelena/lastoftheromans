<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id$

function smarty_function_mtnotifyscript($args, &$ctx) {
    // status: complete
    // parameters: none
    return $ctx->mt->config('NotifyScript');
}
?>
