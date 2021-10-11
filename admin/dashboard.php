<?php 
/*
  1- Add latest items
*/
    session_start();
      
    $title = 'Dashboard';
    if(isset($_SESSION['name'])) {

    include 'init.php';
    // start dashboard
      // latest memebers
    $latestNum = 5;
    $latest = latestItem('username', 'user', 'userID', $latestNum);

    // latest items 
    $latestCount =  4;
    $lastItem = latestItem("Name","items", "Item_ID", $latestCount);


    ?> 
    <div class="container text-center home">
        <h1>Dashboard</h1>
        <div class="row">
              <div class="col-md-3">
                <div class="stat st-memeber">
                  <i class='fa fa-user'></i>
                  <div class="info">
                    total Memeber
                    <span><a href='memeber.php'><?php  echo countItem('userID', 'user') ?></a></span>
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                pending Memeber
                <span><a href='memeber.php?page=pending'><?php echo checkItem('RegStatus', 'user',0) ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-item">
                total item
                <span><a href='items.php'><?php echo countItem('Item_ID', 'items') ?></a></span>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="stat st-comment">
                total comment
                <span><a href='comment.php'><?php echo countItem('c_ID', 'comments') ?></a></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container stmt">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-header">
                <i class="fa fa-users"> Lastest <?php echo $latestNum ?> User Register</i>
                <span class="toggle-info pull-right">
                  <i class='fa fa-plus '></i>
                </span>
                
    </div>
  <div class="card-body">

  <blockquote class="blockquote mb-0">
        <ul class='list-unstyled list-user'>
            <?php 
                foreach($latest as $user) {
                echo "<li>";
                echo $user['username'];
                echo "</li>";
        }
      ?>
    </ul>
      </blockquote>
  </div>
</div>
</div>

    <div class="col-sm-6">
        <div class="card">
  <div class="card-header">
  <i class="fa fa-tag"> Latest Item </i>
  <span class="toggle-info pull-right">
        <i class='fa fa-plus'></i>
  </span>
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
    <ul class='list-unstyled list-user'>
            <?php 
                foreach($lastItem as $item) {
                echo "<li>";
                echo $item['Name'];
                echo "</li>";
        }
      ?>
      </ul>
      
    </blockquote>
  </div>
</div>
</div>
<div class="col-sm-6">
        <div class="card">
  <div class="card-header">
  <i class="fa fa-tag"> Latest Comments </i>
  <span class="toggle-info pull-right">
        <i class='fa fa-plus'></i>
  </span>
  </div>
  <div class="card-body">

   
            <?php 
            
              $stmt = $con->prepare("SELECT comments.*, 
                                      user.username AS user
                                        FROM comments
                                INNER JOIN user
                                        ON comments.user_id = user.userID
                                        ");
            $stmt->execute();

            $comments = $stmt->fetchAll();
            foreach($comments as $comment ) {
            echo "<div class='comment-body'>";
            echo "<span class='comment-name'> " . $comment['user'] . "</span>";
            echo "<p class='comment-c'> " . $comment['comment'] . "</p>";
            echo "</div>";
            }
            ?>
            
      
  </div>
</div>
</div>
        </div>
    </div>

    <?php 

    // end dashboard

    include $tp . 'footer.php'; 
} else {
    header('location:index.php');
    exit();

}