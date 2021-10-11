<?php 
        session_start();
        $title = 'Login';
        if(isset($_SESSION['user'])) {
            header('Location:index.php');
            exit();
        }
        include 'init.php';
        // include $tp . 'header.php';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') { // start request
            if(isset($_POST['login'])) {

            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $hashP = sha1($pass);
            $stmt = $con->prepare("SELECT 
            userID,Username,Password
                FROM
                    user
                WHERE
                    Username = ? AND Password = ?
                ");
            $stmt->execute(array($user, $hashP));

            $get = $stmt->fetch();

            $count = $stmt->rowCount();
            
        // if count > 0 this mean database contain record about this username
            if($count > 0) {

                $_SESSION['user'] = $user;
                $_SESSION['uid'] = $get['userID'];

                header('location:index.php');
                exit();
                
            } 
                } else { //  this for sign up

                    $formErrors = array();
                    
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];
                    $email = $_POST['email'];

                    if(isset($username)) { // username sanitize

                        $filter = filter_var($username, FILTER_SANITIZE_STRING);
                        if(strlen($filter) < 4) {
                            $formErrors[] = 'username can\'t ne less 4 charcter';
                        }

                    } // username sanitize

                    if(isset($password) && isset($password2)) { // pass
                        if(empty($password)) {
                            $formErrors[] = "the password can'nt be empty";
                        }
                        $pass1 = sha1($_POST['password']);
                        $pass2 = sha1($_POST['password2']);
                        if(sha1($password) !== sha1($password2) ) {
                            $formErrors[] = ' the password is correct';
                        }

                    } // pass

                    if(isset($email)) { // email

                        $filterEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
                        if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {

                            $formErrors[] = "the email is not vaildate";
                        }
                    } // email
                    if(empty($formErrors)) { //empty form error

                        $check = checkItem('username', 'user', $username);

                        if($check == 1) {
                        $formErrors[] = "this user is exist";
                        } else { // check item

                        $stmt = $con->prepare("INSERT INTO
                        user(username,password, Email,RegStatus , Date)
                        VALUES(:user,:pass,:email, 0 , now()) 
                                                            ");
                        $stmt->execute(array(
                            'user'  => $username,
                            'pass'  => sha1($password),
                            'email' => $email
                        ));
                        

                        echo "<div class='container'>";
                        
                        echo '<div class="alert alert-success"> Done Add</div>';

                        echo "</div>"; 
                    } // check item    

                    } // empty form error

                } // signup

        } // end request
?>


<div class="container login-page">
    <h1 class='text-center'>
        <span class="active" data-class='login'>Login</span>
        | <span  data-class='signup'>Signup</span>
    </h1>
    <form class='login' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        <input type="text" name='user' placeholder='username'
        class='form-control'>
        <input type="password" name='pass' placeholder='Password'
        class='form-control' autocomplete='new-password'>
        <input type="submit" 
        class="btn btn-primary btn-block" name = "login"
        value='Login'>
    </form>

    <form class='signup' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        <input type="text" name='username' placeholder='username' pattern = ".{4,}"
        title = 'at lest 4'
        class='form-control' required>
        <input type="password" name='password' placeholder='Password'
        class='form-control' autocomplete='new-password'>
        <input type="password" name='password2' placeholder='Re-Password'
        class='form-control' autocomplete='new-password'>
        <input type="text" name='email' placeholder='Email'
        class='form-control'>
        <input type="submit" 
        class="btn btn-success btn-block" name = "signup"
        value='Signup'>
    </form>
    <div class="error text-center">
        <?php 
        if(!empty($formErrors)) {
            foreach($formErrors as $error) {
                echo $error;
            }
        }
        ?>

    </div>

</div>

<?php include $tp . 'footer.php' ?>