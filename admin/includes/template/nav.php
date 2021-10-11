<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Home</a>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarNavAltMarkup" style="">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="categories.php">Categories</a>
        <a class="nav-link" href="items.php">Items</a>
        <a class="nav-link" href="memeber.php">Memeber</a>
        <a class="nav-link" href="comment.php">Comments</a>
      </div>
    </div>
    
<div class="btn-group">
  <button type="button" class="btn btn-danger">Abdo</button>
  <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="visually-hidden">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="../index.php">Visit Shope</a></li>
    <li><a class="dropdown-item" href="memeber.php?action=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
    <li><a class="dropdown-item" href="#">Settings</a></li>
    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
  </ul>
</div>
  </div>
</nav>
