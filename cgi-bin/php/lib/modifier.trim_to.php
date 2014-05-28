<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: modifier.trim_to.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_modifier_trim_to($text, $len) {
    $len = intval($len);
    require_once("MTUtil.php");
    if ($len < length_text($text)) {
        $text = substr_text($text, 0, $len);
    }
    return $text;
}
?>
