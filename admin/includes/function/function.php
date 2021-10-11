<?php 
/*
    1- develope function redirect 

*/
// function to get all
function getAll($field, $table, $where = NULL, $and = NULL) {
    global $con;

    $stmt = $con->prepare("SELECT $field FROM $table $where $and");
    $stmt->execute();
    $gets = $stmt->fetchAll();
    return $gets;

}


function getTitle() {
    global $title;
    if(isset($title)) {
        echo $title;

    } else {
        echo 'unknow page';
    }
}
// redirect function
function redirect($message, $url = null, $sec = 2) {
    // if the url is empty
    if($url === null) {
        $url ="index.php";
    } else {
        // if url is not empty and would to redirect back
        // if iss set http_referer 
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== " ") {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = "index.php";
        }


    }
    echo $message;
    echo "<div class='text-center'>You will redirect after $sec</div>";
    header("refresh:$sec; url=$url");


}

function checkItem($el, $table, $value) {

    global $con;

    $stmt = $con->prepare("SELECT $el FROM $table WHERE $el = ? ");

    $stmt->execute(array($value));

    $count = $stmt->rowCount();
    return  $count;
}   

// function to count memeber and items 
function countItem($item, $table) {
    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

// function to get latest memeber and item 
function latestItem($field, $table, $order, $limit = 5) {
    global $con;

    $stmt = $con->prepare("SELECT $field FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;


}