<?php  
    session_start();
    $title = 'Categories';
    include "init.php"; 
/*
    this is page name form url request h1
    <?php echo str_replace("-"," ",$_GET['pagename']) ?>
 */


?>
<div class="container">

    <h1 class="text-center"><?php echo str_replace("-"," ",$_GET['pagename']) ?></h1>
    <div class="row">
   <?php 
   foreach(getItem('Cat_ID', $_GET['pageid']) as $item) {
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
<?php  include $tp . "footer.php"?>