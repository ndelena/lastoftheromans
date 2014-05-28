<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: modifier.encode_url.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_modifier_encode_url($text) {
    $text = urlencode($text);
    $text = preg_replace('/\+/', '%20', $text);
    return $text;
}
?>
