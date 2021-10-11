<?php 
    session_start();
    $title = "Homepage";
    include "init.php";
    ?>
    <div class="container">

<h1 class="text-center">Show Categories</h1>
<div class="row">
<?php 
    $allItems = getAll("*","items","WHERE Approve = 1","");
    foreach( $allItems as $item) {
    echo "<div class='col-sm-6 col-md-4'>";
    echo "<div class='thumbnail item-box'>";
    echo "<span class='price-tag'> " . $item['Price'] ."</span>";
    echo "<img src='https://bit.ly/3mZW2d3' class='img-fluid'>";
        echo "<div class='caption'>";
            echo "<h3><a href='item.php?itemid=". $item['Item_ID'] ."'>" . $item['Name'] . "</a></h3>";
            echo "<p> " . $item['Description'] ."</p>";
        echo "</div>";
    echo "</div>";
    echo "</div>";
    
    }
?>
</div>
</div>

<?php include $tp . 'footer.php'; ?>