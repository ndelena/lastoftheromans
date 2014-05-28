<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtcommentemail.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtcommentemail($args, &$ctx) {
    $comment = $ctx->stash('comment');
    $email = $comment['comment_email'];
    $email = strip_tags($email);
    if (!preg_match('/@/', $email))
        return '';
    return((isset($args['spam_protect']) && $args['spam_protect']) ? spam_protect($email) : $email);
}
?>
