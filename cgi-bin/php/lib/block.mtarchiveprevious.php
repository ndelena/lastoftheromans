<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: block.mtarchiveprevious.php 1174 2008-01-08 21:02:50Z bchoate $

require_once("archive_lib.php");
function smarty_block_mtarchiveprevious($args, $content, &$ctx, &$repeat) {
    return _hdlr_archive_prev_next($args, $content, $ctx, $repeat, 'archiveprevious');
}
?>
