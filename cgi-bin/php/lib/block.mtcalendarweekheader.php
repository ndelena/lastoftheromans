<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mtcalendarweekheader.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_block_mtcalendarweekheader($args, $content, &$ctx, &$repeat) {
    return $ctx->_hdlr_if($args, $content, $ctx, $repeat, 'CalendarWeekHeader');
}
?>
