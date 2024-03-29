<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtblogcclicenseimage.php 1174 2008-01-08 21:02:50Z bchoate $

function smarty_function_mtblogcclicenseimage($args, &$ctx) {
    // status: complete
    // parameters: none
    $blog = $ctx->stash('blog');
    $cc = $blog['blog_cc_license'];
    if (empty($cc)) return '';
    if (preg_match('/(\S+) (\S+) (\S+)/', $cc, $matches))
        return $matches[3];  # the third element is the image
    return 'http://creativecommons.org/images/public/' .
        ($cc == 'pd' ? 'norights' : 'somerights');
}
?>
