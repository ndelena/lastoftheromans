<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtcommentdate.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtcommentdate($args, &$ctx) {
    $c = $ctx->stash('comment');
    $args['ts'] = $c['comment_created_on'];
    return $ctx->_hdlr_date($args, $ctx);
}
?>
