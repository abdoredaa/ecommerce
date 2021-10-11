<?php 

    session_start();
    $title = 'comments';
    if(isset($_SESSION['name'])) { // open session open
        include 'init.php';
        $do = isset($_GET['action']) ? $_GET['action'] : 'Manage';

        // start do if condition 
        if($do == 'Manage') {   // if manage open  
        $stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name,
                                        user.username AS user
                                FROM comments
                                INNER JOIN items
                                ON  items.item_id = comments.item_id
                                INNER JOIN user
                                ON comments.user_id = user.userID
                                            ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        ?>

        <h1 class='text-center'>Manage Comment</h1>
        <div class="container">
        <div class="table-responsive">
        <table class="table text-center table-bordered">
        <tr>
            <td>ID</td>
            <td>comment</td>
            <td>Item Name</td>
            <td>Username</td>
            <td>Added Date</td>
            <td>Control</td>
        </tr>
        
            <?php 
            foreach($rows as $row) {
                echo "<tr>";
                    echo  "<td>" . $row['c_ID'] . "</td>";
                    echo  "<td>" . $row['comment'] . "</td>";
                    echo  "<td>" . $row['Item_Name'] . "</td>";
                    echo  "<td>" . $row['user'] . "</td>";
                    echo  "<td>" . $row['comment_date'] ."</td>";
                    echo  "<td> 
                    <a href='comment.php?action=Edit&comid="  . $row['c_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                    <a href='comment.php?action=delete&comid=" . $row['c_ID'] . "' class='btn btn-danger'><i class='fa fa-times'></i>Delete</a>";
                    if($row['status'] != 1) {
                        echo " <a href='comment.php?action=Approve&comid=" . $row['c_ID'] . "' class='btn btn-info s'><i class='fa fa-check'></i> Approve</a>";
                    }
                        echo "</td>";

                echo "</tr>";
            }
            ?>
            
        </table>
        </div>
       
        </div>
      <?php  } // manage close 


            elseif($do == 'Edit') { // if edit open

            // intval => that is mean => integer value 
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            $stmt = $con->prepare("SELECT * FROM comments WHERE c_ID = ? ");
            $stmt->execute(array($comid));
            $row = $stmt->fetch();

            if($stmt->rowCount() > 0 ) { // open form is ok

?>
            <h1 class='text-center'>Edit Comment</h1>
        <div class="container">
            <form class='form-horizontal' action="?action=update" method='POST'>
                <input type="hidden" name='comid' value='<?php echo $comid ?>'>
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Comment</label>
            <div class="col-sm-10 col-md-4">
               <textarea name="comment" class="form-control"><?php echo  $row["comment"] ?></textarea>
            </div>
            </div>
            <!-- End username -->
            <!-- start submit -->
            <div class="form-group form-group-lg">
                <div class="col-sm-10 col-md-4">
            <input type="submit" value='save' class='btn btn-primary btn-lg'>
                </div>
    </div>

        <!-- End  submit -->

    </form>
        
</div> 
    <!-- End  submit -->
<?php

            } // end form close tag
            
        } elseif ($do == 'update') { // start update tag

                echo '<h1 class="text-center">Update Comment</h1>';

                if($_SERVER['REQUEST_METHOD'] == 'POST') { //open request tag

                    $id = $_POST['comid'];
                    $comment = $_POST['comment'];

                        echo "<div class='container'>";
                        $stmt = $con->prepare('UPDATE comments set comment = ?  WHERE c_ID = ?');
                        $stmt->execute(array($comment,$id));
                            echo "<div class='alert alert-success'> Done Update </div>" ;
                            echo "</div>";

                } //end request tag
            
                    else   {
                        echo 'you cant browse this page';
                }

            } // end update tag
            elseif($do == 'delete') { //start delete page tag
                
                echo '<h1 class="text-center">DELET Comment </h1>';
                

                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

                $stmt = $con->prepare("SELECT * FROM comments WHERE c_ID = ?");
                $stmt->execute(array($comid));
                $count = $stmt->rowCount();

                if($count > 0) {

                $stmt = $con->prepare("DELETE FROM comments WHERE c_ID = :id");
                $stmt->bindParam(':id', $comid);
                $stmt->execute();

                echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done DELETE </div>";
                    echo "</div>";

                }

            } //end delete page tag
            elseif($do == 'Approve') { // start active page

                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

                $check = checkItem("c_ID", "comments", $comid);

                if($check > 0 ) { 
                    $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_ID = ?");
                    $stmt->execute(array($comid));

                    echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done Active </div>";
                    echo "</div>";

                } else {
                    echo 'sorry this comment id not exist';
                }

            } // end active page

        include $tp . 'footer.php'; 
    } // end session close
        else {
        header('Location: index.php');
        exit();
    } // else session 