<?php
session_start();
//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/src/actions/log/isLogged.php";

$manageType = "Nothing";
//place for logic part
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['manageType'])) {
    $manageType = trim($_POST['manageType']);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['manageType'])) {
    $manageType = trim($_GET['manageType']);
}

var_dump($_POST);
var_dump($_GET);
$title = 'Shop admin - panel';
//Header we will use from main part of application
require_once dirname(__FILE__) . "/../src/html/htmlHeader.php";
?>
<!--Structure-->
<div class="row">    
    <center>
        <?php if ($isLoggedAdmin === FALSE) { ?>
        <form action="src/actions/log/logIn.php" method="post" role="form" id="center">
            <button type="submit" value="logInAdmin" name="logInAdmin" class="btn btn-success">Log in</button>
        </form>
        <?php } elseif ($isLoggedAdmin) { ?>
        <form action="src/actions/log/logOut.php" method="post" role="form" id="center">
            <button type="submit" value="logOutAdmin" name="logOutAdmin" class="btn btn-success">Log out</button>
        </form> 
        
    </center>     
</div>

<div>
<hr>
</div>

<div class="row">
    
    <center>
        
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="groupManage" name="manageType" class="btn btn-success">Groups</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="productManage" name="manageType" class="btn btn-success">Products</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="userManage" name="manageType" class="btn btn-success">Users</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="orderManage" name="manageType" class="btn btn-success">Orders</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        </div>
        
    </center> 
    
</div>

<div>
<hr>
</div>
 
<!--Place to show all "items"-->
<div class="row">
    
<!--    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>-->
    
    <?php
    if ($manageType == 'groupManage' ) {
        require_once dirname(__FILE__) . "/src/actions/manage/group/groupManage.php";
    } elseif ($manageType == 'productManage' ) {
        require_once dirname(__FILE__) . "/src/actions/manage/product/productManage.php";
    } elseif ($manageType == 'userManage' ) {
        require_once dirname(__FILE__) . "/src/actions/manage/user/userManage.php";
    } elseif ($manageType == 'orderManage' ) {
        require_once dirname(__FILE__) . "/src/actions/manage/order/orderManage.php";
    }        
    ?>
    
<!--    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>-->
    
</div> 

<?php
}
//Footer we will use from main part of application
require_once dirname(__FILE__) . "/../src/html/htmlFooter.php";