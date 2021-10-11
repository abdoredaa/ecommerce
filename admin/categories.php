<?php

    session_start();

    $title = 'Category';

    if(isset($_SESSION['name'])) { // open session tag
        include 'init.php';
        $do = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        
        if($do == 'Manage') { // start manage page
            $sort = 'ASC';
            $sort_array = array('DESC','ASC');

            if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) { 

                $sort = $_GET['sort'];

            }

            $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ID $sort ");
            $stmt->execute();
            $cats = $stmt->fetchAll();

            ?>
            <h1 class='text-center'>Manage Page</h1>
            <div class="container cati">
                <div class="card">
                    <div class="card-header">
                    Manage Categories
                    <div class='sort '>
                        <a href='?sort=ASC'>ASC</a> |
                        <a href='?sort=DESC'>DESC</a>
                    </div>
                    </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                    <?php 
                        foreach($cats as $cat) {
                            echo  "<div class='cat'>";
                            echo "<div class='hidden-btn'>
                                    <a href='?action=Edit&catid=" . $cat['ID']. "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>
                                    <a href='?action=Delete&catid=" . $cat['ID']. "' class='btn btn-xs btn-danger'><i class='fa fa-times'></i>Delete</a>
                                </div>";    
                            echo "<h3>" . $cat['Name'] .  "</h3>";
                            echo "<div class='full-view dis'>";
                            if ($cat['Description'] == '') {
                                echo "<p>There is no decription</p>";
                            } else {
                                echo "<p>" . $cat['Description'] . "</p>";
                            }

                            if ($cat['Visibilty'] == 1) {
                                echo "<span class='vs gl'>Hidden</span>";
                            } 
                            if ($cat['Allow_Comment'] == 1) {
                                echo "<span class='comment gl'>Comment Disabled</span>";
                            }
                            if ($cat['Allow_Ads'] == 1) {
                                echo "<span class='ads gl'>Ads Disabled</span>";
                            }
                            echo "</div>";

                            echo "</div>";
                            $childs = getAll("*", "categories", "WHERE parent = {$cat['ID']}","");
                            if(! empty($childs)) {
                                echo "<p class='child'>Child </p>";
                                foreach($childs as $child) {
                                    echo "<ol class='list'>";
                                    echo "<li >
                                    <a href='?action=Edit&catid=" . $child['ID']. "' >" . $child['Name'] ."</a>
                                    <a href='?action=Delete&catid=" . $child['ID']. "'>Delete</a>
                                    </li>";
                                    echo "</ol>";
                                }
                            }
                            echo "<hr>";
                           
                        }
                    ?>
                    
                    </blockquote>
                </div>
            </div>
            <a href="?action=Add" class="btn btn-primary">Add New Category</a>
            </div>

            
        <?php  
        } // end maanage page
        elseif ($do == 'Add') { // start add page
            ?>
            <h1 class='text-center'>Add New Category</h1>
        <div class="container">
        <form class='form-horizontal' action="?action=insert" method='POST'>
                <!-- start Name category -->
            <div class="form-group form-group-lg">
                <label class='col-sm-2 control-label'>Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name='name'  class='form-control' placeholder='
                Name Of Category'>
            </div>
        </div>
        <!-- End start Name category -->
        <!-- start Description -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Description</label>
                <div class="col-sm-10 col-md-4">
                    <input type="test" name='description' class='form-control' placeholder='
                    Description Of Category'>
                </div>
        </div>
        <!-- End Description -->
        <!-- start Ordering -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Ordering</label>
        <div class="col-sm-10 col-md-4">
            <input type ="text" name='ordering'  class='form-control'>
        </div>
        </div>
        <!-- End Ordering -->
        <!-- start parent -->
        <div class="form-group form-group-lg">
            <label class='col-sm-2 control-label'>Parent?</label>
        <div class="col-sm-10 col-md-4">
            <select  class='form-select' name="parent">
                <option value="0" >None</option>
                <?php 
                
                $all = getAll("*", "categories", "WHERE parent = 0","");
                foreach($all as $cat) {
                    echo "<option value=" . $cat['ID'] .">" . $cat['Name'] ."</option>";
                }
                ?>
            </select>
        </div>
        </div>
        <!-- End parent -->
        <!-- start Visibilty -->
        <div class="form-group form-group-lg opt">
            <label class='col-sm-2 control-label'>Visibilty</label>
        <div class="col-sm-10 col-md-4">
            
                <input type = "radio" name='Visibilty' id='vs-yes' value='0' checked>
                <label for="vs-yes">Yes</label>
            
                <input type="radio" name='Visibilty' id='vs-no' value='1'>
                <label for="vs-no">NO</label>

        </div>
        </div>
        <!-- End Visibilty -->
        <!-- start Comment -->
        <div class="form-group form-group-lg opt">
            <label class='col-sm-2 control-label'>Allow Comment</label>
        <div class="col-sm-10 col-md-4">
            
                <input type = "radio" name='comment' id='com-yes' value='0' checked>
                <label for="com-yes">Yes</label>
            
                <input type="radio" name='comment' id='com-no' value='1'>
                <label for="com-no">NO</label>

        </div>
        </div>
        <!-- End Comment -->
        <!-- start Ads -->
        <div class="form-group form-group-lg opt">
            <label class='col-sm-2 control-label'>Allow Ads</label>
        <div class="col-sm-10 col-md-4">
            
                <input type = "radio" name='ads' id='ads-yes' value='0' checked>
                <label for="ads-yes">Yes</label>
                <input type="radio" name='ads' id='ads-no' value='1'>
                <label for="ads-no">NO</label>
                
        </div>
        </div>
        <!-- End Ads -->
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

                echo '<h1 class="text-center">Update Categories</h1>';

                $name   = $_POST['name'];
                $des    = $_POST['description'];
                $parent = $_POST['parent'];
                $or     = $_POST['ordering'];
                $vis    = $_POST['Visibilty'];
                $com    = $_POST['comment'];
                $ads    = $_POST['ads'];
        
                $check = checkItem('Name', 'categories', $name);

                    if($check == 1) {

                        echo 'sorry this Name is exist';

                    } else { // check item
                    $stmt = $con->prepare("INSERT INTO
                categories(Name ,Description, parent, Ordering, Visibilty, 	Allow_Comment , Allow_Ads)

                VALUES(:name, :des, :pare, :order, :vis, :com , :ads)

                                            ");
                    $stmt->execute(array(

                        'name'  => $name,
                        'des'   => $des,
                        'pare'  => $parent,
                        'order' => $or,
                        'vis'   => $vis,
                        'com'   => $com,
                        'ads'   => $ads
                    ));

                    echo "<div class='container'>";
                    
                    echo '<div class="alert alert-success"> Done Add</div>';

                    echo "</div>"; 
                } // check item    
                
                
            } //end request tag

            else {
                $errM =  'You can not browse this page';
                redirect($errM);
            }
        
            
        } // end insert page 
        elseif ($do == 'Edit') { // start edit page

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? LIMIT 1");
            $stmt->execute(array($catid));
            $cat = $stmt->fetch();
            $ocunt = $stmt->rowCount();

            if($ocunt > 0) {
                ?>
                <h1 class='text-center'>Edit Category</h1>
                <div class="container">
                <form class='form-horizontal' action="?action=Update" method='POST'>
                    <!-- start Name category -->
                    <input type="hidden" name='catid' value='<?php echo $catid ?>'>
                    <div class="form-group form-group-lg">
                        <label class='col-sm-2 control-label'>Name</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name='name'  class='form-control' placeholder='
                        Name Of Category' value ="<?php echo $cat['Name'] ?>" >
                    </div>
                    </div>
                <!-- End start Name category -->
                <!-- start Description -->
                <div class="form-group form-group-lg">
                    <label class='col-sm-2 control-label'>Description</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="test" name='description' class='form-control' placeholder='
                        Description Of Category' value ="<?php echo $cat['Description'] ?>">
                    </div>
                </div>
                <!-- End Description -->
                <!-- start Ordering -->
                <div class="form-group form-group-lg">
                    <label class='col-sm-2 control-label'>Ordering</label>
                <div class="col-sm-10 col-md-4">
                    <input type ="text" name='ordering'  class='form-control' value ="<?php echo $cat['Ordering'] ?>">
                </div>
                </div>
                <!-- End Ordering -->
                <!-- start parent -->
                <div class="form-group form-group-lg">
                    <label class='col-sm-2 control-label'>Parent?</label>
                <div class="col-sm-10 col-md-4">
                    <select  class='form-control' name="parent">
                        <option value="0" >None</option>
                        <?php 
                        
                        $all = getAll("*", "categories", "WHERE parent = 0","");
                        foreach($all as $c) {
                            echo "<option value='" . $c['ID'] ."'";
                            if($c['ID'] == $cat['parent']) {echo "selected";}
                            echo ">" . $c['Name'] ."</option>";
                        }
                        ?>
                    </select>
                </div>
                </div>
        <!-- End parent -->
                <!-- start Visibilty -->
                <div class="form-group form-group-lg opt">
                    <label class='col-sm-2 control-label'>Visibilty</label>
                <div class="col-sm-10 col-md-4">
            
                    <input type = "radio" name='Visibilty' id='vs-yes' value='0' <?php if($cat['Visibilty'] == 0) {echo 'checked';} ?>>
                    <label for="vs-yes">Yes</label>

                    <input type="radio" name='Visibilty' id='vs-no' value='1' <?php if($cat['Visibilty'] == 1) {echo 'checked';} ?>>
                    <label for="vs-no">NO</label>

                </div>
                </div>
                <!-- End Visibilty -->
                <!-- start Comment -->
                <div class="form-group form-group-lg opt">
                    <label class='col-sm-2 control-label'>Allow Comment</label>
                <div class="col-sm-10 col-md-4">
            
                    <input type = "radio" name='comment' id='com-yes' value='0' <?php if($cat['Allow_Comment'] == 0) {echo 'checked';} ?>>
                    <label for="com-yes">Yes</label>
                    <input type="radio" name='comment' id='com-no' value='1' <?php if($cat['Allow_Comment'] == 1) {echo 'checked';} ?>>
                    <label for="com-no">NO</label>

                </div>
                </div>
                <!-- End Comment -->
                <!-- start Ads -->
                <div class="form-group form-group-lg opt">
                    <label class='col-sm-2 control-label'>Allow Ads</label>
                <div class="col-sm-10 col-md-4">
                    <input type = "radio" name='ads' id='ads-yes' value='0' <?php if($cat['Allow_Ads'] == 0) {echo 'checked';} ?>>
                    <label for="ads-yes">Yes</label>
                    <input type="radio" name='ads' id='ads-no' value='1' <?php if($cat['Allow_Ads'] == 1) {echo 'checked';} ?>>
                    <label for="ads-no">NO</label>
                </div>
                </div>
                <!-- End Ads -->
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
            }
            
        } // end edit page
        elseif ($do == 'Update') { // start update page

            echo '<h1 class="text-center">Update Category</h1>';
            if($_SERVER['REQUEST_METHOD'] == 'POST') { // request
                            
                $catid  = $_POST['catid'];
                $name   = $_POST['name'];
                $des    = $_POST['description'];
                $order  = $_POST['ordering'];
                $parent = $_POST['parent'];
                $vis    = $_POST['Visibilty'];
                $com    = $_POST['comment'];
                $ads    = $_POST['ads'];
                
                $stmt = $con->prepare('UPDATE 
                                            categories
                                        SET
                                            Name = ?,
                                            Description = ?,
                                            Ordering = ?,
                                            parent = ?,
                                            Visibilty = ?,
                                            Allow_Comment = ?,
                                            Allow_Ads = ?
                                        WHERE ID = ? ');
                $stmt->execute(array($name,$des,$order,$parent,$vis,$com,$ads,$catid));
                echo "Done Update";
            } // request
            else { // not have request

                echo 'You cant browse this page directly';

            } // not have request
            
        } // end update page
        elseif ($do == 'Delete') { // start delete page
            echo '<h1 class="text-center">DELET  Categories </h1>';
                

                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? LIMIT 1");
                $stmt->execute(array($catid));
                $count = $stmt->rowCount();

                if($count> 0) {

                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :id");
                $stmt->bindParam(':id', $catid);
    

                $stmt->execute();

                echo "<div class='container'>";
                    echo "<div class='alert alert-success'>Done DELETE </div>";
                    echo "</div>";
                }
                

            
        } // end delete page
        include $tp . 'footer.php';

    } // open session tag 
    else { // else session
        header("Location:index.php");
        exit();
    } // else session