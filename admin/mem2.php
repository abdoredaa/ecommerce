 <?php 

session_start();

$title = 'Edit Page';

if(isset($_SESSION['name'])) { 

include 'init.php';

$do = isset($_GET['action']) ? $_GET['action'] : 'Manage';

if($do == 'Manage') {     // 2    

    echo 'this is manage page';
    echo '<a href="memeber.php?action=Add">Add memeber</a>';

}  elseif ($do == 'Add') { 

    echo 'add page';


} elseif ($do == 'Edit') { // start edit page
// intval => that is mean => integer value 
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        

    $stmt = $con->prepare("SELECT * FROM user WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0 ) { // form 
            
        
 ?>
    <h1 class='text-center'>Edit Page</h1>
    <div class="container">
    <form class='form-horizontal' action="?action=Update" method='POST'>
    <input type="hidden" name='userid' value='<?php echo $userid ?>'>

<div class="form-group form-group-lg">
    <label class='col-sm-2 control-label'>Username</label>
    <div class="col-sm-10 col-md-4">
    <input type="text" name='username' value='<?php  echo $row['username']; ?>' class='form-control'>
    </div>
</div>

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

<?php 
} } elseif($do == 'Update') {
    echo '<h1 class="text-center">Update Memeber</h1>';
    // echo "<div class='container'>";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        if(empty($formError)) {
        $stmt = $con->prepare('UPDATE user set Username = ? , Email = ? , FullNAme = ?, password = ? WHERE userID = ?');
        $stmt->execute(array($username,$email,$full,$pass,$id));
            echo "<div class='alert alert-success'>" . "Done Update" . "</div>" ;
    }  
    else {
        echo 'you cant browse this page';

    }
    echo "</div>";
    



include $tp . 'footer.php'; 

}  else {
header('location:index.php');
exit();
} -->