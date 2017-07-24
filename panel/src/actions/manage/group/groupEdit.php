<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {

$switch = 0;
var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id']) ) {
    $id = trim($_GET['id']);
    $_SESSION['group_id'] = $id;
    $productGroup = ProductGroup::GetProductGroup($id);
    
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newGroupName'])) {
    
    $newGroupName = trim($_POST['newGroupName']);
    
    if (!empty($_POST['newGroupName'])) {
        $id = $_SESSION['group_id'];
        $productGroup = ProductGroup::GetProductGroup($id);
        $productGroup->setName($newGroupName);
        $productGroup->saveToDB();

        if ($productGroup->saveToDB()) {
            header("Location: ../../../../index.php?manageType=groupManage");
        } else {
            $id = $_SESSION['group_id'];
            $productGroup = ProductGroup::GetProductGroup($id);
            $switch = 1;
        }
    } else {
        $id = $_SESSION['group_id'];
        $productGroup = ProductGroup::GetProductGroup($id);
        $switch = 2;        
    } 
}

$title = 'Shop Admin - Edit Group';
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
                <legend>Edit name of group</legend>
                <div class="form-group">
                    <label for="">New group name</label>
                    <input type="text" class="form-control" name="newGroupName" id="newGroupName"
                           value="<?php echo $productGroup->getName() ?>">
                </div>                
                <button type="submit" class="btn btn-success">Save</button>
            </form>
            
            <form action="../../../../index.php" method="post" role="form">
                <button type="submit" class="btn btn-success">Go to panel</button>
            </form>
        
        <?php 
        
        switch ($switch) {
            case 1:
                echo 'Error with query';
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
