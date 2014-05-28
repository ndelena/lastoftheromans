<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: modifier.remove_html.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_modifier_remove_html($text) {
    return strip_tags($text);
}
?>
