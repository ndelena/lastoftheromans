<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: modifier.dirify.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_modifier_dirify($text, $attr = '1') {
    if ($attr == "0") return $text;
    require_once("MTUtil.php");
    return dirify($text, $attr);
}
?>