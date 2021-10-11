<?php 
    $db = 'mysql:host=localhost;dbname=shop';
    $user = 'root';
    $pass = '';
    $opt = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    );
    try {
    $con = new PDO($db, $user, $pass, $opt);
                    // Error reporting.   // Throw exceptions.
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e ) {
    echo 'error to connect ' . $e->getMessage();
    }