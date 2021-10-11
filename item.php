<?php 
    session_start();
    $title = "Item Page";
    include "init.php";
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    
    $stmt = $con->prepare("SELECT items.*,categories.Name AS C_Name,
                            user.username
                        FROM items
                        INNER JOIN categories
                        ON categories.ID = items.Cat_ID
                        INNER JOIN user
                        ON user.userID = items.Memmber_ID
                        WHERE Item_ID  = ? 
                        AND Approve = 1 ");

            $stmt->execute(array($itemid));
            $count = $stmt->rowCount();
            if($count > 0) { // this item is exist =  true

                $item = $stmt->fetch();
                ?>
            <h1 class="text-center"><?php echo $item['Name'] ?></h1>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="https://bit.ly/3mZW2d3" class="img-responsive center-block">
                        </div>
                        <div class="col-md-9 item-info">
                            <h2><?php  echo $item['Name'] ?></h2>
                            <p><?php echo $item['Description'] ?></p>
                            <ul class="list-unstyled">
                            <li>
                                <i class="fa fa-calendar fa-fw"></i>
                                <span>Added Date</span> :
                                <?php  echo $item['Add_Date']?></li>
                            <li>
                                <i class="fa fa-money fa-fw"></i>
                                <span>Price</span> : <?php echo $item['Price'] ?>
                            </li>
                            <li>
                                <i class="fa fa-building fa-fw"></i>
                                <span>Made In </span>: <?php echo $item['Country_Made'] ?>
                            </li>
                            <li>
                                <i class="fa fa-tags fa-fw"></i>
                                <span>Category </span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php  echo $item['C_Name']?></a>
                            </li>
                            <li>
                                <i class="fa fa-user fa-fw"></i>
                                <span>Added By</span> : <a href=""><?php  echo $item['username']?></a>
                            </li>
                            <li>
                                <i class="fa fa-user fa-fw"></i>
                                <span>Tags : </span>
                                <?php 
                                $tags = explode(",",$item['tags']);
                                foreach($tags as $tag) {
                                    $tag = str_replace(" ","",$tag);
                                    $lower = strtolower($tag);
                                    echo "<a href='tags.php?name={$lower}'>" . $tag . "</a>" . "|";
                                }
                                ?>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <?php if(isset($_SESSION['user'])) { // session ?> 
                    <div class="row">
                        <div class="col-md-offset-4">
                        <div class="add-com">
                            <h3>Add Your Comment</h3>
                            <form action="<?php echo $_SERVER['PHP_SELF'] ."?itemid=" . $item['Item_ID'] ."" ?>" method="POST">
                            <textarea name="comment"></textarea>
                            <input type="submit" class="btn btn-primary" value="Add Comment">
                            </form>
                            <?php 
                                if($_SERVER['REQUEST_METHOD'] == "POST") {
                                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                    $itemid = $item['Item_ID'];
                                    

                                    if(! empty($comment)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                        comments(comment,status,comment_date,item_id,user_id)
                                        VALUES(:zcomment,0,now(),:zitemid,:zuserid)
                                        ");
                                        $stmt->execute(array(
                                            'zcomment' => $comment,
                                            'zitemid'  => $itemid,
                                            'zuserid'  => $_SESSION['uid']
                                        ));
                                        if($stmt) {
                                            echo "good";

                                        }

                                    }

                                }
                            ?>
                            
                                    

                            </div>
                        </div>
                    </div>
                        

                    <?php } else {
                        echo "<a href='login.php'>login</a> or <a href='signup'>Signup</a> ";

                    } // session ?>
                    <hr>
                    <?php $stmt = $con->prepare("SELECT comments.*, user.username AS user
                                FROM comments    
                                INNER JOIN user
                                ON comments.user_id = user.userID
                                WHERE item_id = ?  ");
                            $stmt->execute(array($item['Item_ID']));
                            $comments = $stmt->fetchAll();
                            foreach($comments as $comment) { ?>
                            <div class="comment-box text-center">
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <img src="https://bit.ly/3t5L4DN" class="img-resonsive center-block">
                                        <?php echo $comment['user'] ?>
                                    </div>
                                    <div class='col-sm-10'>
                                       <p class="lead"><?php echo $comment['comment']?></p> 
                                    </div>
                                </div>
                            </div>
                                <?php
                            }
                        ?>
                    
                </div>
            


<?php  } else {

    echo "<div class='container'>
    <div class='alert alert-danger'>There is no id </div></div>";
    redirect("done","back",100);

}
include $tp . 'footer.php'; ?>