<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: rating_lib.php 1174 2008-01-08 21:02:50Z bchoate $

function get_score(&$ctx, $obj_id, $datasource, $namespace, $user_id) {
    $score = $ctx->mt->db->fetch_score($namespace, $obj_id, $user_id, $datasource);
    return $score['objectscore_score'];
}

function score_for(&$ctx, $obj_id, $datasource, $namespace) {
    $sum = $ctx->stash($datasource . '_score_sum_' . $obj_id . '_' . $namespace);
    if (isset($sum) && ($sum >= 0)) {
        return $sum;
    } else {
        $scores = $ctx->mt->db->fetch_scores($namespace, $obj_id, $datasource);
        if (!isset($scores) || !$scores) {
            return '';
        }
        $sum = 0;
        foreach ($scores as $score) {
            $sum += $score['objectscore_score'];
        }
        $ctx->stash($datasource . '_score_sum_' . $obj_id . '_' . $namespace, $sum);
        return $sum;
    }
}

function vote_for(&$ctx, $obj_id, $datasource, $namespace) {
    $scores = $ctx->mt->db->fetch_scores($namespace, $obj_id, $datasource);
    return count($scores);
}

function _score_top(&$ctx, $obj_id, $datasource, $namespace, $block) {
    $scores = $ctx->mt->db->fetch_scores($namespace, $obj_id, $datasource);
    if (0 == count($scores)) {
        return 0;
    }
    $sorter = create_function('$a,$b', $block);
    usort($scores, $sorter);
    
    return $scores[0]['objectscore_score'];
}

function score_high(&$ctx, $obj_id, $datasource, $namespace) {
    $high = $ctx->stash($datasource . '_score_high_' . $obj_id . '_' . $namespace);
    if ($high) {
        return $high;
    } else {
        $high = _score_top($ctx, $obj_id, $datasource, $namespace,
            'return $b["objectscore_score"] - $a["objectscore_score"];');
        $ctx->stash($datasource . '_score_high_' . $obj_id . '_' . $namespace, $high);
        return $high;
    }
}

function score_low(&$ctx, $obj_id, $datasource, $namespace) {
    $low = $ctx->stash($datasource . '_score_low_' . $obj_id . '_' . $namespace);
    if ($low) {
        return $low;
    } else {
        $low = _score_top($ctx, $obj_id, $datasource, $namespace,
            'return $a["objectscore_score"] - $b["objectscore_score"];');
        $ctx->stash($datasource . '_score_low_' . $obj_id . '_' . $namespace, $low);
        return $low;
    }
}
function score_count(&$ctx, $obj_id, $datasource, $namespace) {
    $count = $ctx->stash($datasource . '_score_count_' . $obj_id . '_' . $namespace);
    if ($count) {
        return $count;
    } else {
        $scores = $ctx->mt->db->fetch_scores($namespace, $obj_id, $datasource);
        $count = count($scores);
        $ctx->stash($datasource . '_score_count_' . $obj_id . '_' . $namespace, $count);
        return $count;
    }
}

function score_avg(&$ctx, $obj_id, $datasource, $namespace) {
    $count = score_count($ctx, $obj_id, $datasource, $namespace);
    if ($count == 0) {
        return 0;
    }
    $sum = score_for($ctx, $obj_id, $datasource, $namespace);
    return sprintf("%.2f", ($sum / $count));
}

function rank_for(&$ctx, $obj_id, $datasource, $namespace, $max, $filter) {
    if (!$max) {
        $max = 6;
    }

    $sum = score_for($ctx, $obj_id, $datasource, $namespace);
    if (!isset($sum)) {
        return '';
    } elseif (strval($sum) == '') {
        return '';
    }
    
    $high = $ctx->stash($datasource . '_score_highest_' . $namespace);
    $low = $ctx->stash($datasource . '_score_lowest_' . $namespace);
    $total = $ctx->stash($datasource . '_score_total_' . $namespace);
    if (!($total && $high && $low)) {
        $scores = $ctx->mt->db->fetch_sum_scores($namespace, $datasource, 'desc', $filter);
        foreach($scores as $s) {
            $score = $s['sum_objectscore_score'];
            if ($score > $high) $high = $score;
            if ($score < $low or $low == 0) $low = $score;
            if (0 > $score) {
                $score *= -1;
            }
            $total += $score;
        }
        $ctx->stash($datasource . '_score_highest_' . $namespace, $high);
        $ctx->stash($datasource . '_score_lowest_' . $namespace, $low);
        $ctx->stash($datasource . '_score_total_' . $namespace, $total);
    }

    $factor;
    if ($high - $low == 0) {
        $low -= $max;
        $factor = 1;
    } else {
        $factor = ($max - 1) / log($high - $low + 1);
    }

    if ((0 < $total) && ($total < $max)) {
        $factor *= ($total / $max);
    }
    $level = intval(log($sum - $low + 1) * $factor);
    return $max - $level;
}

function hdlr_score($ctx, $datasource, $namespace, $default) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    $score = score_for($ctx, $object[$datasource . '_id'], $datasource, $namespace);
    if ( !$score && isset($default) )
        return $default;
    return $score;
}

function hdlr_score_high($ctx, $datasource, $namespace) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    return score_high($ctx, $object[$datasource . '_id'], $datasource, $namespace);
}

function hdlr_score_low($ctx, $datasource, $namespace) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    return score_low($ctx, $object[$datasource . '_id'], $datasource, $namespace);
}

function hdlr_score_avg($ctx, $datasource, $namespace) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    return score_avg($ctx, $object[$datasource . '_id'], $datasource, $namespace);
}

function hdlr_score_count($ctx, $datasource, $namespace) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    return score_count($ctx, $object[$datasource . '_id'], $datasource, $namespace);
}

function hdlr_rank($ctx, $datasource, $namespace, $max, $filter) {
    if (!isset($namespace)) {
        return '';
    }
    if ($datasource == 'tbping') {
        $key = 'ping';
    } else {
        $key = $datasource;
    }
    $object = $ctx->stash($key);
    if (!isset($object)) {
        return '';
    }
    return rank_for($ctx, $object[$datasource . '_id'], $datasource, $namespace, $max, $filter);
}
?>
