<?php 
    session_start();
    $title = "New Ad";

    include "init.php";
    if(isset($_SESSION['user'])) { // session

        if($_SERVER['REQUEST_METHOD'] ==  'POST') { // post
            $formErrors = array();

            $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $des      = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $price    = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country  = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $statue   = filter_var($_POST['statue'], FILTER_SANITIZE_NUMBER_INT);
            $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            $tags = filter_var($_POST['tag'], FILTER_SANITIZE_STRING);

            if(strlen($name) < 4) {
                $formErrors[] = 'the name at lestest 4 characters';
            }
            if(strlen($des) < 4) {
                $formErrors[] = 'the description at lestest 4 characters';
            }
            if(empty($price)) {
                $formErrors[] = 'the price can\'t be empty';
            }
            if(strlen($country) < 4) {
                $formErrors[] = 'the country at lestest 4 characters';
            }
            if(empty($statue)) {
                $formErrors[] = 'the statue at lestest 4 characters';
            }
            if(empty($category)) {
                $formErrors[] = 'the category at lestest 4 characters';
            }
            if(empty($formErrors)) {
            $stmt = $con->prepare("INSERT INTO

            items(Name, Description, Price, Country_Made, Statue, Add_Date, Cat_ID, Memmber_ID,tags)

            VALUES(:name, :des, :price, :country, :statue, now(),:cat, :mem,:tag)

                                        ");
                $stmt->execute(array(
                    'name'      => $name,
                    'des'       => $des,
                    'price'     => $price,
                    'country'   => $country,
                    'statue'    => $statue,
                    'cat'       => $category,
                    'mem'       => $_SESSION['uid'],
                    'tag'       => $tags
                ));

               
                echo "<div class='container'>";
                
                echo '<div class="alert alert-success"> Done Add</div>';

                echo "</div>"; 
              
            }
            
                
            } // post 
        
?>
<h1 class='text-center'>Add Item</h1>
<div class="container">
    <div class="card">
    <div class="card-header">Create Ad</div>
        <div class="card-body">
        <?php  if (!empty($formErrors)) {
                    foreach($formErrors as $error) {
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    }
                }
                ?>
            <div class="row">
                <!-- start add item  -->
                <div class="col-md-8"> 
                <form class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
                <!-- Start Name -->
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Name</label>
            <div class="col-sm-10 col-md-9">
                <input type="text" name='name'  class='form-control name'>
            </div>
        </div>
        <!-- End Name -->
        <!-- start Description -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Description</label>
        <div class="col-sm-10 col-md-9">
            <input type="text" name='description' class='form-control des'>
        </div>
        </div>
        <!-- End Description -->
        <!-- start Price -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Price</label>
        <div class="col-sm-10 col-md-9">
            <input type="text" name='price'  class='form-control price'>
        </div>
        </div>
        <!-- End Price -->
        <!-- start Country -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Country Made</label>
        <div class="col-sm-10 col-md-9">
            <input type="text" name='country'  class='form-control'>
        </div>
        </div>
        <!-- End Country -->
        <!-- start Statue -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Statue</label>
        <div class="col-sm-10 col-md-9">
                <select name="statue" id="" class="form-control">
                    <option value="0">...</option>
                    <option value="1">old</option>
                    <option value="2">very old</option>
                    <option value="3">used</option>
                    <option value="4">New</option>
                </select>
        </div>
        </div>
        <!-- End Statue -->
        <!-- start categories -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>categories</label>
        <div class="col-sm-10 col-md-9">
                <select name="category" id="" class="form-control">
                <option value="">...</option>
                    <?php 
                        
                        foreach(getAll('*','categories') as $cat) {
                            echo "<option value='" . $cat['ID'] ."'>";
                                echo $cat['Name'];
                            echo "</option>";

                        }
                    ?>
                </select>
        </div>
        </div>
        <!-- End categories -->
        <!-- start tags -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>tags</label>
        <div class="col-sm-10 col-md-9">
            <input type="text" name='tag'  class='form-control'>
        </div>
        </div>
        <!-- End tags -->
        <!-- start submit -->
        <div class="form-group form-group-lg">
        <div class="col-sm-10 col-md-9">
            <input type="submit" value='save' class='btn btn-primary btn-lg'>
        </div>
        </div>

<!-- End  submit -->

</form>
                </div>
                
                <!-- end add item  -->
                <!-- start preveiw  -->
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                    <span class='price-tag'>$</span>
                        <img src="http://placehold.it/200/DDD" class="card-img-top" alt="...">
                    <div class="card-body live-prev">
                        <h5 class="card-title ttile"></h5>
                        <p class="card-text"></p>
                    </div>
                    </div>
                </div>
                <!-- End preveiw  -->
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