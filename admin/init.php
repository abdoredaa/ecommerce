<?php 
    $tp = 'includes/template/';
    $css = 'layout/css/';
    $js = 'layout/js';
    $lang = 'includes/lang/';
    $func = 'includes/function/';

    include 'connect.php';
    include $func . 'function.php';
    
    include $lang . 'en.php';
    
    include $tp . 'header.php';

    if(!isset($noNav)) {include $tp . 'nav.php';}
    



