<?php 
    session_start();
    $title = 'Edit page';
    if(isset($_SESSION['name'])) { // open session open
        include 'init.php';
        $do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        
        // start do if condition 

        if($do == 'Manage') {     // if manage open  

        $query = '';

        if(isset($_GET['memeber']) && $_GET['memeber'] == 'pending') {
            $query = "AND RegStatus = 0";
        }

        $stmt = $con->prepare("SELECT * FROM user WHERE GroupID != 1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        ?>

        <h1 class='text-center'>Manage page</h1>
        <div class="container">
        <div class="table-responsive">
        <table class="table text-center table-bordered my-user">
        <tr>
            <td>ID</td>
            <td>Image</td>
            <td>Username</td>
            <td>Email</td>
            <td>Full Name</td>
            <td>Register Date</td>
            <td>Control</td>
        </tr>
        
            <?php 
            foreach($rows as $row) {
                echo "<tr>";
                    echo  "<td>" . $row['userID'] . "</td>";
                    echo  "<td>";

                    if(empty($row['image'])) {
                        echo "<img src='https://bit.ly/38KHJke'>";
                    }else {
                        echo "<img src='upload/image/" . $row['image'] . "'>";
                    }

                    echo "</td>";
                    echo  "<td>" . $row['username'] . "</td>";
                    echo  "<td>" . $row['Email'] . "</td>";
                    echo  "<td>" . $row['FullName'] . "</td>";
                    echo  "<td>" . $row['Date'] ."</td>";
                    echo  "<td> 
                    <a href='memeber.php?action=Edit&userid="  . $row['userID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                    <a href='memeber.php?action=delete&userid=" . $row['userID'] . "' class='btn btn-danger'><i class='fa fa-times'></i>Delete</a>";
                    if($row['RegStatus'] != 1) {
                        echo " <a href='memeber.php?action=active&userid=" . $row['userID'] . "' class='btn btn-info s'><i class='fa fa-check'></i> Active</a>";
                    }
                        echo "</td>";

                echo "</tr>";
            }
            ?>
            


        </table>
        </div>
        <a href="memeber.php?action=Add" class='btn btn-primary'><i class='fa fa-plus'></i> Add new memeber</a>
        </div>

    
      <?php  } // manage close 

        elseif ($do == 'Add') { // if add open
            ?>
            <h1 class='text-center'>Add Page</h1>
            
        <div class="container">
            <form class='form-horizontal' action="?action=insert" method='POST' enctype="multipart/form-data">
                <!-- start username  -->
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label' >Username</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name='username'  class='form-control' >
            </div>
        </div>

                <!-- End username -->
            <!-- start password -->
    <div class="form-group form-group-lg">
        <label class='col-sm-2 control-label'  required="required">password</label>
    <div class="col-sm-10 col-md-4">
        <input type="password" name='pass' class='form-control'  required="required">
    </div>
    </div>
        <!-- End password -->
        <!-- start Email -->
    <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Email</label>
        <div class="col-sm-10 col-md-4">
            <input type="email" name='email'  class='form-control' required="required">
        </div>
    </div>
        <!-- End Email -->
        <!-- start Full Name -->
    <div class="form-group form-group-lg">
        <label class='col-sm-2 control-label'>Full Name</label>
    <div class="col-sm-10 col-md-4">
        <input type="text" name='name'  class='form-control' required="required">
    </div>
    </div>
        <!-- End Full Name -->
        <!-- start image -->
    <div class="form-group form-group-lg">
        <label class='col-sm-2 control-label'>Image</label>
    <div class="col-sm-10 col-md-4">
        <input type="file" name='image'  class='form-control'  required="required">
    </div>
    </div>
        <!-- End image -->
        <!-- start submit -->
    <div class="form-group form-group-lg">
        <div class="col-sm-10 col-md-4">
            <input type="submit" value='save' class='btn btn-primary btn-lg'>
        </div>
    </div>

        <!-- End  submit -->

</form>
</div>
        <?php

        } // add close 

        elseif($do == "insert") { // Start insert page

                if($_SERVER['REQUEST_METHOD'] == 'POST') { //open request tag

                    echo '<h1 class="text-center">Update Memeber</h1>';

                    // image variable
                    $imgName = $_FILES['image']['name'];
                    $imgType = $_FILES['image']['type'];
                    $imgSize = $_FILES['image']['size'];
                    $imgTemp = $_FILES['image']['tmp_name'];

                    $imgExtension = array("jpeg","jpg","png","gif");

                    // echo $imgName . "<br>";

                    $imgEx = explode(".", $imgName);
                    $end = end($imgEx);
                    $tolower = strtolower($end);

                    // echo print_r($tolower);


                    

                    
                    $username = $_POST['username'];
                    $pass     = $_POST['pass'];
                    $email    = $_POST['email'];
                    $full     = $_POST['name'];

                    $hashPass = sha1($_POST['pass']);
            
                    $formError = array();

                    if(empty($username)) {
                        $formError[] = "The username can't be empty";
                    } 
                    if(empty($pass)) {
                        $formError[] = "The password can't be empty";
                    }
                    if(empty($email)) {
                        $formError[] = "The email can't be empty";
                    }
                    if(empty($full)) {
                        $formError[] = "The full name can't be empty";
                    }
                    if( empty($imgName) &&  in_array($tolower,$imgExtension)) {
                        $formError[] = "The image is not allowed";
                    }

                            
                    foreach($formError as $error) {
                        echo "<div class='container'>";
                        
                        echo '<div class="alert alert-danger">' . $error . '</div>';

                        echo "</div>";
                        redirect("error", "back");
                    }
                    
                    if(empty($formError)) {

                        $image = rand(0,1056656) . "_" . $imgName;
                        move_uploaded_file($imgTemp,"upload/image/" . $image);


                        $check = checkItem('username', 'user', $username);
                        if($check == 1) {
                            echo '<div class="alert alert-warning">sorry this username is exist</div>';
                            redirect("", "back");
                        } else { // check item

                        $stmt = $con->prepare("INSERT INTO
                        user(username,password, Email, FullName,RegStatus , Date,image)
                        VALUES(:user,:pass,:email,:full, 1 , now(),:img)
                                                ");
                        $stmt->execute(array(

                            'user'  => $username,
                            'pass'  => $hashPass,
                            'email' => $email,
                            'full'  => $full,
                            'img'   => $image
                        ));

                        echo "<div class='container'>";
                        
                        echo '<div class="alert alert-success"> Done Add</div>';

                        echo "</div>";

                        redirect("","memeber.php");
                        } // check item    
                    } // if empty
                    
                } //end request tag

                else {
                    $errM =  'You can not browse this page';
                    redirect("","");
                }
            

        } // end insert page

            elseif($do == 'Edit') { // if edit open

            // intval => that is mean => integer value 
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            
            $stmt = $con->prepare("SELECT * FROM user WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();


            if($stmt->rowCount() > 0 ) { // open form is ok

?>
            <h1 class='text-center'>Edit Page</h1>
        <div class="container">
            <form class='form-horizontal' action="?action=update" method='POST'>
                <input type="hidden" name='userid' value='<?php echo $userid ?>'>
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Username</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name='username' value='<?php  echo $row['username']; ?>' class='form-control'>
            </div>
        </div>
        <!-- End username -->
        <!-- start password -->
    <div class="form-group form-group-lg">
        <label class='col-sm-2 control-label'>password</label>
    <div class="col-sm-10 col-md-4">
        <input type="hidden" name='oldpassword' value ='<?php echo $row['password'] ?>'>
        <input type="password" name='newpassword' class='form-control'>
    </div>
    </div>
        <!-- End password -->
        <!-- start Email -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Email</label>
        <div class="col-sm-10 col-md-4">
            <input type="email" name='email' value='<?php  echo $row['Email'] ?>' class='form-control'>
        </div>
        </div>
        <!-- End Email -->
        <!-- start Full Name -->
    <div class="form-group form-group-lg">
        <label class='col-sm-2 control-label'>Full Name</label>
    <div class="col-sm-10 col-md-4">
        <input type="text" name='name' value='<?php  echo $row['FullName'] ?>' class='form-control'>
    </div>
    </div>
    <!-- End Full Name -->
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

                echo '<h1 class="text-center">Update Memeber</h1>';

                if($_SERVER['REQUEST_METHOD'] == 'POST') { //open request tag

                    $id = $_POST['userid'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $full = $_POST['name'];

                    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
            
                    $formError = array();

                    if(empty($username)) {
                        $formError[] = "The username can't be empty";
                    } if (empty($email)) {
                        $formError[] = "The Email can't be empty";
                    }
                    foreach($formError as $error) {
                        echo "<div class='container'>";
                        
                        echo '<div class="alert alert-danger">' . $error . '</div>';

                        echo "</div>";
                    }

                    if(empty($formError)) {

                        $stmt2 = $con->prepare("SELECT * FROM user WHERE username = ? AND userID != ?");
                        $stmt2->execute(array($username,$id));
                        $row = $stmt2->rowCount();
                        if($row == 1) {
                            echo "this is user is exeist";
                        } else {

                        $stmt = $con->prepare('UPDATE user set Username = ? , Email = ? , FullNAme = ?, password = ? WHERE userID = ?');
                        $stmt->execute(array($username,$email,$full,$pass,$id));

                        echo "<div class='container'>";
                            echo "<div class='alert alert-success'> Done Update </div>" ;
                            echo "</div>";
                            redirect("","");

                    }}

                } //end request tag
            
                    else   {
                        echo 'you cant browse this page';
                }

            } // end update tag
            elseif($do == 'delete') { //start delete page tag
                
                echo '<h1 class="text-center">DELET MEMEBER </h1>';
                
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                $stmt = $con->prepare("SELECT * FROM user WHERE userID = ? LIMIT 1");
                $stmt->execute(array($userid));
                $count = $stmt->rowCount();

                if($count > 0) {

                $stmt = $con->prepare("DELETE FROM user WHERE userID = :user");
                
                $stmt->bindParam(':user', $userid);
    

                $stmt->execute();

                echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done DELETE </div>";
                    echo "</div>";
                    redirect("","");
                }

            } //end delete page tag
            elseif($do == 'active') { // start active page

                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                $check = checkItem("userID", "user", $userid);

                if($check > 0 ) { 
                    $stmt = $con->prepare("UPDATE user SET RegStatus = 1 WHERE userID = ?");
                    $stmt->execute(array($userid));

                    echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done Active </div>";
                    echo "</div>";

                } else {
                    echo 'sorry this user id not exist';
                }
                
            } // end active page



        include $tp . 'footer.php'; 
    } // end session close
        else {
        header('Location: index.php');
        exit();
    } // else session 