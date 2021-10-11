<?php 
    session_start();
    $title = "Profile";

    include "init.php";
    if(isset($_SESSION['user'])) {
        $get = $con->prepare("SELECT * FROM user WHERE username = ?");
        $get->execute(array($sessionUser));
        $info = $get->fetch();
?>
<h1 class='text-center'>My Profile</h1>
<div class="information">
    <div class="container">
        <div class="card" >
            <div class="card-header">User Information</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa fa-unlock-alt fa-fw"></i>
                        Name : <?php echo $info['username'] ?>
                    </li>
                    <li class="list-group-item">
                    <i class="fa fa-envelope-o fa-fw"></i>
                        Email : <?php echo $info['Email'] ?>
                    </li>
                    <li class="list-group-item">
                    <i class="fa fa-calendar fa-fw"></i>
                        Date : <?php echo $info['Date'] ?>
                    </li>
                </ul>
                <a href="#" class="btn btn-default">Edit Information</a>
        </div>
    </div>
</div>
 <!-- start Ads  -->
<div class="information">
    <div class="container">
        <div class="card" >
            <div class="card-header">ADS</div>
                        <?php 


                        $allItems = getAll("*","items","WHERE Memmber_ID ={$info['userID']}","");
                        if(!empty($allItems)) {
                            echo "<div class='row'>";
                foreach($allItems as $item) {
                    
                echo "<div class='col-sm-6 col-md-4'>";
                echo "<div class='thumbnail item-box'>";
                if($item['Approve'] == 0) {
                    echo "<span class='review'>In review</span>";
                }
                echo "<span class='price-tag'> " . $item['Price'] ."</span>";
                echo "<img src='https://bit.ly/3mZW2d3' class='img-fluid'>";
                    echo "<div class='caption'>";
                        echo "<h3><a href='item.php?itemid=" . $item["Item_ID"] ."'> " . $item['Name'] . "</a></h3>";
                        echo "<p> " . $item['Description'] ."</p>";
                    echo "</div>";
                echo "</div>";
                echo "</div>";
                
                } // close foreach
                echo "</div>";
            } 

                else {
                    echo "there's No ADS. Create Ad <a href='newad.php'>Create Ads</a>";
                } 
                ?>  
        </div>
    </div>
</div>
<!-- start comments  -->
<div class="information">
    <div class="container">
        <div class="card" >
            <div class="card-header">Comment</div>
                <div class="comment" style='padding:20px'>
                    <?php
                    $stmt2 = $con->prepare("SELECT * FROM comments WHERE user_id = ?");
                    $stmt2->execute(array($info['userID']));
                    $comments = $stmt2->fetchAll();
                    if(! empty($comments)) {
                        foreach($comments as $comment) {

                            echo "<p>" . $comment['comment'] . "</p>";
                        }
                        
                    } else {
                        echo "there's no comments";
                    }
                    ?>

                </div>
        </div>
    </div>
</div>
<!-- end comments  -->
<?php }  else {
            header("Location:login.php");
        }
?>

<?php include $tp . 'footer.php'; ?>