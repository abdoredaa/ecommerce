<?php

    session_start();
    $title = 'Category';

    if(isset($_SESSION['name'])) { // open session tag
        include 'init.php';
        $do = isset($_GET['action']) ? $_GET['action'] : 'manage';
        
        if($do == 'Manage') { // start manage page
            
        } // end maanage page
        elseif ($do == 'Add') { // start add page

        } // end add page
        elseif ($do == 'Insert') { // start insert page
            
        } // end insert page 
        elseif ($do == 'Edit') { // start edit page
            
        } // end edit page
        elseif ($do == 'Update') { // start update page
            
        } // end update page
        elseif ($do == 'Delete') { // start delete page
            
        } // end delete page
        include $tp . 'footer.php';

    } // open session tag 
    else { // else session
        header("Location:index.php");
        exit();
    } // else session