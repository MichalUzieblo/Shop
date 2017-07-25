<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {

$switch = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['groupName'])) {
    
    $groupName = trim($_POST['groupName']);
    
    if (!empty($_POST['groupName'])) {
        
        $newProductGroup = ProductGroup::CreateProductGroup($groupName);

        if ($newProductGroup) {
            header("Location: ../../../../index.php?manageType=groupManage");
        } else {
            $switch = 1;
        }
    } else {
        $switch = 2;        
    } 
}

$title = 'Shop Admin - New Group';
//Header we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";


?>
<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        <center>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            
            <form action="" method="post" role="form">
                <legend>New group of products</legend>
                <div class="form-group">
                    <label for="">Group name</label>
                    <input type="text" class="form-control" name="groupName" id="groupName"
                           placeholder="Group name">
                </div>                
                <button type="submit" value="newGroup" name="newGroup" class="btn btn-success">Add</button>
            </form>
            
            <form action="../../../../index.php" method="post" role="form">
                <button type="submit" class="btn btn-success">Go to panel</button>
            </form>
        
        <?php 
        
        switch ($switch) {
            case 1:
                echo 'This name is set';
                break;
            case 2:
                echo 'Empty field sent';
                break;                  
        }
        
        ?>
            
        </div>
        </center>       
            
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
        
    </div>
</div>
            
<?php
require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}
