<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: function.mtentryscoreavg.php 1174 2008-01-08 21:02:50Z bchoate $

require_once('rating_lib.php');

function smarty_function_mtentryscoreavg($args, &$ctx) {
    return hdlr_score_avg($ctx, 'entry', $args['namespace']);
}
?>
