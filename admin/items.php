<?php
/*
        ALTER TABLE items
        ADD CONSTRAINT mem_1
        FOREIGN KEY(Memmber_ID)
        REFERENCES user(userID)
        ON UPDATE CASCADE
        ON DELETE CASCADE;
        

        ALTER TABLE items
        ADD CONSTRAINT cat_1
        FOREIGN KEY(Cat_ID)
        REFERENCES categories(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE; 

        JOIN  --

        SELECT items.*, categories.Name AS Cat_Name, user.username
        FROM 
            items 
        INNER JOIN categories
        ON  categories.ID = items.Cat_ID
        INNER JOIN
        user 
        ON user.userID = items.Memmber_ID

        ِ


*/

    session_start();

    $title = 'Items Page';

    if(isset($_SESSION['name'])) { // open session tag

        include 'init.php';
        
        $do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        
        if($do == 'Manage') { // start manage page

        $stmt = $con->prepare("SELECT items.*, categories.Name AS Cat_Name, 
            user.username
        FROM 
            items 
        INNER JOIN categories
        ON  categories.ID = items.Cat_ID
        INNER JOIN
            user 
        ON user.userID = items.Memmber_ID");

        $stmt->execute();
        $items = $stmt->fetchAll();
        
        ?>

        <h1 class='text-center'>Manage page</h1>
        <div class="container">
        <div class="table-responsive">
        <table class="table text-center table-bordered">
        <tr>
            <td>#item ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Price</td>
            <td>Date</td>
            <td>Category</td>
            <td>Username</td>
            <td>Control</td>

        </tr>
        
            <?php 
            foreach($items as $item) {
                echo "<tr>";
                    echo  "<td>" . $item['Item_ID'] . "</td>";
                    echo  "<td>" . $item['Name'] . "</td>";
                    echo  "<td>" . $item['Description'] . "</td>";
                    echo  "<td>" . $item['Price'] . "</td>";
                    echo  "<td>" . $item['Add_Date'] ."</td>";
                    echo  "<td>" . $item['Cat_Name'] . "</td>";
                    echo  "<td>" . $item['username'] ."</td>";
                    echo  "<td> 
                    <a href='items.php?action=Edit&itemid="  . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                    <a href='items.php?action=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger'><i class='fa fa-times'></i>Delete</a>";
                    if($item['Approve'] == 0) {
                        echo " <a href='items.php?action=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info s'><i class='fa fa-check'></i> Active</a>";
                    }
                        echo "</td>";

                echo "</tr>";
            }
            ?>
            


        </table>
        </div>
        <a href="items.php?action=Add" class='btn btn-primary'><i class='fa fa-plus'></i> Add new Item</a>
        </div>

    
<?php

        } // manage close 
        
        elseif ($do == 'Add') { // start add page
?>
            <h1 class='text-center'>Add Item Page</h1>
        <div class="container">
            <form class='form-horizontal' action="?action=insert" method='POST'>
                <!-- Start Name -->
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name='name-item'  class='form-control'>
            </div>
        </div>
        <!-- End Name -->
        <!-- start Description -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Description</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='description' class='form-control'>
        </div>
        </div>
        <!-- End Description -->
        <!-- start Price -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Price</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='price'  class='form-control'>
        </div>
        </div>
        <!-- End Price -->
        <!-- start Country -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Country Made</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='country'  class='form-control'>
        </div>
        </div>
        <!-- End Country -->
        <!-- start Statue -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Statue</label>
        <div class="col-sm-10 col-md-4">
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
        <!-- start Memeber -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Memeber</label>
        <div class="col-sm-10 col-md-4">
                <select name="memeber" id="" class="form-select">
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM user");
                        $stmt->execute();
                        $memebers = $stmt->fetchALL();
                        foreach($memebers as $memeber) {
                            echo "<option value='" . $memeber['userID'] ."'>";
                                echo $memeber['username'];
                            echo "</option>";

                        }
                    ?>
                </select>
        </div>
        </div>
        <!-- End Memeber -->
        <!-- start Memeber -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>categories</label>
        <div class="col-sm-10 col-md-4">
                <select name="category" id="" class="form-control">
                    <?php 
                        $allCats = getAll("*",'categories',"where parent = 0");
                        foreach($allCats as $cat) {
                            echo "<option value='" . $cat['ID'] ."'>";
                                echo $cat['Name'];
                            echo "</option>";
                            $childS = getAll("*",'categories',"where parent = {$cat['ID']}");
                            foreach($childS as $child) {
                                echo "<option value='" . $child['ID'] ."'>-- ";
                                echo $child['Name'];
                            echo "</option>";
                            }

                        }
                    ?>
                </select>
        </div>
        </div>
        <!-- End Memeber -->
        <!-- start tags -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>tag</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='tag'  class='form-control'>
        </div>
        </div>
        <!-- End tags -->
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
        } // end add page
        elseif ($do == 'insert') { // start insert page

            if($_SERVER['REQUEST_METHOD'] == 'POST') { //open request tag

                echo '<h1 class="text-center">Update Memeber</h1>';

                $name       = $_POST['name-item'];
                $des        = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $statue     = $_POST['statue'];
                $memeber2   = $_POST['memeber'];
                $cat2       = $_POST['category'];
                $tag        = $_POST['tag'];



        
                $formError = array();

                // if(empty($name)) {
                //     $formError[] = "The name can't be empty";
                // } 
                // if(empty($des)) {
                //     $formError[] = "The Description can't be empty";
                // }
                // if(empty($price)) {
                //     $formError[] = "The price can't be empty";
                // }
                // if(empty($country)) {
                //     $formError[] = "The full name can't be empty";
                // }
                // if($statue == 0) {
                //     $formError[] = "The statue can't be empty";
                // }

                foreach($formError as $error) {
                    echo "<div class='container'>";
                    
                    echo '<div class="alert alert-danger">' . $error . '</div>';

                    echo "</div>";
                }
                
                if(empty($formError)) {

                $stmt = $con->prepare("INSERT INTO

                items(Name, Description, Price, Country_Made, Statue, Add_Date, Memmber_ID, Cat_ID, tags)

                VALUES(:name, :des, :price, :country, :statue, now(), :mem, :cat,:tag)

                                            ");
                    $stmt->execute(array(
                        'name'      => $name,
                        'des'       => $des,
                        'price'     => $price,
                        'country'   => $country,
                        'statue'    => $statue,
                        'mem'       => $memeber2,
                        'cat'       => $cat2,
                        'tag'       => $tag
                    ));

                    echo "<div class='container'>";
                    
                    echo '<div class="alert alert-success"> Done Add</div>';

                    echo "</div>"; 
                
                }
                
            } //end request tag
            else {
                $errM =  'You can not browse this page';
                redirect($errM);
            }

        } // end insert page 
        elseif ($do == 'Edit') { // start edit page
            
            // intval => that is mean => integer value 
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            
            
            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID  = ? ");
            $stmt->execute(array($itemid));

            $row = $stmt->fetch();

            if($stmt->rowCount() > 0 ) { // open form is ok

            ?>
            <!-- start from -->

            <h1 class='text-center'>Edit Item Page</h1>
        <div class="container">
            <form class='form-horizontal' action="?action=Update" method='POST'>
                <!-- Start Name -->
                <input type="hidden" name='itemid' value ="<?php echo $itemid ?>">
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name='name-item'  class='form-control'
                value = "<?php echo $row['Name'] ?>">
            </div>
        </div>
        <!-- End Name -->
        <!-- start Description -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Description</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='description' class='form-control'
            value ="<?php echo $row['Description']?>">
        </div>
        </div>
        <!-- End Description -->
        <!-- start Price -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Price</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='price'  class='form-control'
            value ="<?php echo $row['Price']?>">
        </div>
        </div>
        <!-- End Price -->
        <!-- start Country -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Country Made</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='country'  class='form-control'
            value ="<?php echo $row['Country_Made']?>">
        </div>
        </div>
        <!-- End Country -->
        <!-- start Statue -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Statue</label>
        <div class="col-sm-10 col-md-4">
                <select name="statue" id="" class="form-control">
                    <option value="1" <?php if ($row['Statue'] == 1) {echo "selected";}?>>old</option>
                    <option value="2" <?php if ($row['Statue'] == 2) {echo "selected";}?>>very old</option>
                    <option value="3" <?php if ($row['Statue'] == 3) {echo "selected";}?>>used</option>
                    <option value="4" <?php if ($row['Statue'] == 4) {echo "selected";}?>>New</option>
                </select>
        </div>
        </div>
        <!-- End Statue -->
        <!-- start Memeber -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Memeber</label>
        <div class="col-sm-10 col-md-4">
                <select name="memeber" id="" class="form-control">
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM user");
                        $stmt->execute();
                        $memebers = $stmt->fetchALL();
                        foreach($memebers as $memeber) {
                            echo "<option value='" . $memeber['userID'] ."'";
                            if($row['Memmber_ID'] == $memeber['userID']) {
                                echo "selected";
                            }
                                echo ">";
                                echo $memeber['username'];
                                
                            echo "</option>";
                        }
                    ?>
                </select>
        </div>
        </div>
        <!-- End Memeber -->
        <!-- start Memeber -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>categories</label>
        <div class="col-sm-10 col-md-4">
                <select name="category" id="" class="form-control">
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM categories");
                        $stmt->execute();
                        $cats = $stmt->fetchALL();
                        foreach($cats as $cat) {
                            echo "<option value='" . $cat['ID'] ."'";
                            if($row['Cat_ID'] == $cat['ID']) {

                                echo "selected";
                            }
                            echo ">";
                                echo $cat['Name'];
                            echo "</option>";

                        }
                    ?>
                </select>
        </div>
        </div>
        <!-- End Memeber -->
        <!-- start tags -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>tag</label>
        <div class="col-sm-10 col-md-4">
            <input type="text" name='tag'  class='form-control'
            value='<?php  echo $row['tags'] ?>'>
        </div>
        </div>
        <!-- End tags -->
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

        $stmt = $con->prepare("SELECT comments.*, 
                                        user.username AS user
                                FROM comments
                                INNER JOIN user
                                ON comments.user_id = user.userID
                                WHERE item_id = ?  ");
        $stmt->execute(array($itemid));

        $rows = $stmt->fetchAll();
        if(!empty ($rows)) {
        
        ?>

        <h1 class='text-center'>Manage Comment</h1>
        <div class="container">
        <div class="table-responsive">
        <table class="table text-center table-bordered">
        <tr>
            <td>comment</td>
            <td>Username</td>
            <td>Added Date</td>
            <td>Control</td>
        </tr>
        
            <?php 
            foreach($rows as $row) {
                echo "<tr>";
                    echo  "<td>" . $row['comment'] . "</td>";
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
        <?php  } ?>
                    <!-- End from -->
<?php } // form close

            else {  // if item id is not found

                echo "this id not exist";

                }
            
        } // end edit page
        elseif ($do == 'Update') { // start update page

            echo '<h1 class="text-center">Update item</h1>';

                if($_SERVER['REQUEST_METHOD'] == 'POST') { //open request tag

                    $id           = $_POST['itemid'];
                    $name         = $_POST['name-item'];
                    $description  = $_POST['description'];
                    $price        = $_POST['price'];
                    $country        = $_POST['country'];
                    $statue        = $_POST['statue'];
                    $memeber        = $_POST['memeber'];
                    $category        = $_POST['category'];
            
                    $formError = array();




                    if(empty($formError)) {
                        echo "<div class='container'>";
                        $stmt = $con->prepare('UPDATE items 
                                set
                                    Name = ?,
                                    Description = ?,
                                    Price = ?,
                                    Country_Made = ?,
                                    Statue = ?,
                                    Memmber_ID = ?,
                                    Cat_ID = ?
                                    
                                    WHERE Item_ID = ?');
                        $stmt->execute(array($name,$description,$price,$country,$statue,$memeber,$category,$id));
                            echo "<div class='alert alert-success'> Done Update </div>" ;
                            echo "</div>";
                    }

                } //end request tag
            
                    else   {
                        echo 'you cant browse this page';

                }
            
        } 
        // end update page
        elseif ($do == 'Delete') { // start delete page

            echo '<h1 class="text-center">DELET MEMEBER </h1>';
                

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
                $stmt->execute(array($itemid));
                $count = $stmt->rowCount();

                if($count> 0) {

                $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :id");
                $stmt->bindParam(':id', $itemid);
    

                $stmt->execute();

                echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done DELETE </div>";
                    echo "</div>";
                }
                
            
        } // end delete page
        elseif($do == "Approve") { // start approve page
            
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            $check = checkItem("Item_ID", "items", $itemid);

            if($check > 0 ) { 
                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
                $stmt->execute(array($itemid));

                echo "<div class='container'>";

                echo "<div class='alert alert-success'>Done Active </div>";
                echo "</div>";
                redirect("", "back");
                


            } else {
                echo 'sorry this userid not exist';
            }
            




        } // start approve page
        include $tp . 'footer.php';

    } // open session tag 
    else { // else session
        header("Location:index.php");
        exit();
    } // else session