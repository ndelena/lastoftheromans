<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id$

function smarty_block_mtif($args, $content, &$ctx, &$repeat) {
    if (!isset($content)) {
        $result = 0;
        $name = isset($args['name'])
          ? $args['name'] : $args['var'];
        if (isset($name)) {
            # pick off any {...} or [...] from the name.
            if (preg_match('/^(.+)([\[\{])(.+)[\]\}]$/', $name, $matches)) {
                $name = $matches[1];
                $br = $matches[2];
                $ref = $matches[3];
                if (preg_match('/^\\\\\$(.+)/', $ref, $ref_matches)) {
                    $ref = $vars[$ref_matches[1]];
                    if (!isset($ref))
                        $ref = chr(0);
                }
                $br == '[' ? $index = $ref : $key = $ref;
            } else {
                if (array_key_exists('index', $args))
                    $index = $args['index'];
                else if (array_key_exists('key', $args))
                    $key = $args['key'];
            }
            if (preg_match('/^$/', $name)) {
                $name = $vars[$name];
                if (!isset($name))
                    return $ctx->error($ctx->mt->translate(
                        "You used a [_1] tag without a valid name attribute.", "<MT$tag>" ));
            }
            if (isset($name)) {
                $value = $ctx->__stash['vars'][$name];
                require_once("MTUtil.php");
                if (is_hash($value)) {
                    if ( isset($key) ) {
                        if ($key != chr(0)) {
                            $val = $value[$key];
                        } else {
                            unset($value);
                        }
                    }
                }
                elseif (is_array($value)) {
                    if ( isset($index) ) {
                        if (is_numeric($index)) {
                            $val = $value[ $index ];
                        } else {
                            unset($value); # fall through to any 'default'
                        }
                    }
                }
                if (!isset($val))
                    $val = $value;
            }
        } elseif (isset($args['tag'])) {
            $tag = $args['tag'];
            $tag = preg_replace('/^mt:?/i', '', $tag);
            $largs = $args; // local arguments without 'tag' element
            unset($largs['tag']);
            $val = $ctx->tag($tag, $largs);
        }
        if ( !is_array($value)
          && preg_match('/^smarty_fun_[a-f0-9]+$/', $value) ) {
            if (function_exists($val)) {
                ob_start();
                $val($ctx, array());
                $val = ob_get_contents();
                ob_end_clean();
            } else {
                $val = '';
            }
        }

        if (isset($args['name']))
            $var_key = $args['name'];
        else if(isset($args['var']))
            $var_key = $args['var'];
        else if(isset($args['tag']))
            $var_key = $args['tag'];
        require_once("function.mtsetvar.php");
        smarty_function_mtsetvar(array('name' => '__name__', 'value' => $var_key), $ctx);
        smarty_function_mtsetvar(array('name' => '__value__', 'value' => $val), $ctx);

        if ( array_key_exists('op', $args) ) {
            $op = $args['op'];
            $rvalue = $args['value'];
            if ( $op && isset($value) && !is_array($value) ) {
                $val = _math_operation($op, $val, $rvalue);
                if (!isset($val)) {
                    return $ctx->error($ctx->mt->translate("[_1] [_2] [_3] is illegal.", $val, $op, $rvalue));
            }}
        }
        if (array_key_exists('eq', $args)) {
            $val2 = $args['eq'];
            $result = $val == $val2 ? 1 : 0;
        } elseif (array_key_exists('ne', $args)) {
            $val2 = $args['ne'];
            $result = $val != $val2 ? 1 : 0;
        } elseif (array_key_exists('gt', $args)) {
            $val2 = $args['gt'];
            $result = $val > $val2 ? 1 : 0;
        } elseif (array_key_exists('lt', $args)) {
            $val2 = $args['lt'];
            $result = $val < $val2 ? 1 : 0;
        } elseif (array_key_exists('ge', $args)) {
            $val2 = $args['ge'];
            $result = $val >= $val2 ? 1 : 0;
        } elseif (array_key_exists('le', $args)) {
            $val2 = $args['le'];
            $result = $val <= $val2 ? 1 : 0;
        } elseif (array_key_exists('like', $args)) {
            $patt = $args['like'];
            $opt = "";
            if (preg_match("/^\/.+\/([si]+)?$/", $patt, $matches)) {
                $patt = preg_replace("/^\/|\/([si]+)?$/", "", $patt);
                if ($matches[1])
                    $opt = $matches[1];
            } else {
                $patt = preg_replace("!/!", "\\/", $patt);
            }
            $result = preg_match("/$patt/$opt", $val) ? 1 : 0;
        } elseif (array_key_exists('test', $args)) {
            $expr = 'return (' . $args['test'] . ') ? 1 : 0;';
            // export vars into local variable namespace, then eval expr
            extract($ctx->__stash['vars']);
            $result = eval($expr);
            if ($result === FALSE) {
                die("error in expression [" . $args['test'] . "]");
            }
        } else {
            $result = isset($val) && $val ? 1 : 0;
        }
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat, $result);
    } else {
        $vars =& $ctx->__stash['vars'];
        unset($vars['__name__']);
        unset($vars['__value__']);
        return $ctx->_hdlr_if($args, $content, $ctx, $repeat);
    }
}
?>
