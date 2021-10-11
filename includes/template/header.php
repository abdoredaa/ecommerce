
<!DOCTYPE html>
<html lang='en'>
    <head>
    <meta charest='utf-8'>
    <title><?php  getTitle() ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='layout/css/style.css'>
    

    </head>
    <body>
      <div class="upper-bar">
        <div class="container">
          <?php 
           if(isset($_SESSION['user'])) { ?>
          
        <div class="dropdown">
        <?php 
          $mem = getAll("*","user","WHERE userID = {$_SESSION['uid']}");

          foreach($mem as $me) {  

                if(! empty($e['image'])) {
                echo "<img src='admin/upload/image/" . $me['image'] . "'>";
                  } else {
                    echo "<img src='https://bit.ly/38KHJke'>";
                  } 

            }
        
        ?>
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $sessionUser ?>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
            <li><a class="dropdown-item" href="newad.php">New AD</a></li>
            <li><a class="dropdown-item" href="Logout.php">Logout</a></li>
            <li><a class="dropdown-item" href="admin/dashboard.php">Dashboard</a></li>
          </ul>
        </div>
           <?php 

              $userStatue = checkUser($sessionUser);
                      // if($userStatue == 1) {
                      //   // 
                      // }
              
              } else {
                ?>
                    <a href="login.php">
                    <span class='login-nav'>Login/signup</span>
                    </a>
            <?php  
                  } ?>
          
        </div>
      </div>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <form class="d-flex">
        <?php 
          $cats = getAll("*","categories","WHERE parent = 0","");
        
          foreach($cats as $cat) {
            echo "<a class='nav-link' href='categories.php?pageid=" . $cat['ID'] . "&pagename=". str_replace(" ","-", $cat['Name']) . "'> " . $cat['Name'] . "</a>";
          }
        ?>

      </form>
    </div>
  </div>
</nav>

