<?php
# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: cc_lib.php 1174 2008-01-08 21:02:50Z bchoate $

global $_cc_Data;
$_cc_Data = array(
    'by' => array(
          'name' => 'Attribution',
          'requires' => array('Attribution', 'Notice'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
     ),
    'by-nd' => array(
          'name' => 'Attribution-NoDerivs',
          'requires' => array('Attribution', 'Notice'),
          'permits' => array('Reproduction', 'Distribution'),
     ),
    'by-nd-nc' => array(
          'name' => 'Attribution-NoDerivs-NonCommercial',
          'requires' => array('Attribution', 'Notice'),
          'permits' => array('Reproduction', 'Distribution'),
          'prohibits' => array('CommercialUse'),
     ),
    'by-nc' => array(
          'name' => 'Attribution-NonCommercial',
          'requires' => array('Attribution', 'Notice'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
          'prohibits' => array('CommercialUse'),
     ),
    'by-nc-sa' => array(
          'name' => 'Attribution-NonCommercial-ShareAlike',
          'requires' => array('Attribution', 'Notice', 'ShareAlike'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
          'prohibits' => array('CommercialUse'),
     ),
    'by-sa' => array(
          'name' => 'Attribution-ShareAlike',
          'requires' => array('Attribution', 'Notice', 'ShareAlike'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
     ),
    'nd' => array(
          'name' => 'NonDerivative',
          'requires' => array('Notice'),
          'permits' => array('Reproduction', 'Distribution'),
     ),
    'nd-nc' => array(
          'name' => 'NonDerivative-NonCommercial',
          'requires' => array('Notice'),
          'permits' => array('Reproduction', 'Distribution'),
          'prohibits' => array('CommercialUse'),
     ),
    'nc' => array(
          'name' => 'NonCommercial',
          'requires' => array('Notice'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
          'prohibits' => array('CommercialUse'),
     ),
    'nc-sa' => array(
          'name' => 'NonCommercial-ShareAlike',
          'requires' => array('Notice', 'ShareAlike'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
          'prohibits' => array('CommercialUse'),
     ),
    'sa' => array(
          'name' => 'ShareAlike',
          'requires' => array('Notice', 'ShareAlike'),
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
     ),
    'pd' => array(
          'name' => 'PublicDomain',
          'permits' => array('Reproduction', 'Distribution', 'DerivativeWorks'),
     ),
);
function cc_url($code) {
    if (preg_match('/(\S+) (\S+) (\S+)/', $code, $matches))
        return $matches[2];  # the license URL
    return $code == 'pd' ?
        "http://web.resource.org/cc/PublicDomain" :
        "http://creativecommons.org/licenses/$code/1.0/";
}
function cc_rdf($code) {
    global $_cc_Data;
    $url = cc_url($code);
    $rdf = <<<RDF
<License rdf:about="$url">

RDF;
    foreach (array('requires', 'permits', 'prohibits') as $type) {
        if (isset($_cc_Data[$code])) {
            if (!isset($_cc_Data[$code][$type]))
                continue;
            foreach ($_cc_Data[$code][$type] as $item) {
                $rdf .= <<<RDF
<$type rdf:resource="http://web.resource.org/cc/$item" />

RDF;
            }
        }
    }
    return $rdf . "</License>\n";
}
function cc_name($code) {
    global $_cc_Data;
    if (preg_match('/(\S+) (\S+) (\S+)/', $code, $matches))
        $code = $matches[1];
    if (isset($_cc_Data[$code])) {
        return $_cc_Data[$code]['name'];
    } else {
        return '';
    }
}
?>
