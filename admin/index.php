<?php 
        session_start();
        $noNav = '';
        $title = 'Login';
        if(isset($_SESSION['name'])) {
            header('location:dashboard.php');
            exit();
    }
        include 'init.php';
        // include $tp . 'header.php';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $hashP = sha1($password);
            $stmt = $con->prepare("SELECT 
            Username,Password,UserID 
                FROM
                    user
                WHERE
                    Username = ? AND Password = ?
                AND 
                    GroupID = 1
                    LIMIT 1
                ");
            $stmt->execute(array($username, $hashP));

            $row = $stmt->fetch();
            
            $count = $stmt->rowCount();
            
        // if count > 0 this mean database contain record about this username
            if($count > 0) {

                $_SESSION['name'] = $username;
                $_SESSION['ID'] = $row['UserID'];
                
                header('location:dashboard.php');
                exit();
                
            }

        }
?>

<form class='login' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
    <h4 class='text-center'>Admin Login</h4>
    <input type='text' class='form-control' name='user'
    placeholder='Username' autocomplete='off'>
    <input type='password' class='form-control' name='pass' placeholder='Password'>
    <input type='submit' class='btn btn-primary btn-block log-btn' value='Login'>
</form>
<?php include $tp . 'footer.php'; ?>