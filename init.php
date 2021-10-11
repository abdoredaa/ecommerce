<?php 
    // ERROR REPORTING
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    $tp = 'includes/template/';
    $css = 'layout/css/';
    $js = 'layout/js';
    $lang = 'includes/lang/';
    $func = 'includes/function/';

    include 'admin/connect.php';

    $sessionUser = '';
    if(isset($_SESSION['user'])) {
        $sessionUser = $_SESSION['user'];
    }



    include $func . 'function.php';
    
    include $lang . 'en.php';
    include $tp . 'header.php';

    
    



