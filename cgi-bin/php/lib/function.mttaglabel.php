<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mttaglabel.php 1174 2008-01-08 21:02:50Z bchoate $

require_once('function.mttagname.php');
function smarty_function_mttaglabel($args, &$ctx) {
    return smarty_function_mttagname($args, $ctx);
}
?>
