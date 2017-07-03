<?php
session_start();
require_once dirname(__FILE__) . "/src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogged.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogout.php";
var_dump($_POST, $_GET, $_SESSION);
$title = 'Shop';
require_once dirname(__FILE__) . "/src/html/htmlHeader.php";

$productGroup = 'all';

//TODO additional database with producGroup - because of possibility to add new one by admin
if (!empty($_POST['productGroup'])) {    
    switch ($_POST['productGroup']) {
        case 'offices':
            $productGroup = 'offices';
            break;
        case 'residential':
            $productGroup = 'residential';
            break;
        case 'hotels':
            $productGroup = 'hotels';
            break;
        case 'mixed':
            $productGroup = 'mixed';
            break;
    }
} else {
    $productGroup = 'all';
}
require_once dirname(__FILE__) . "/src/html/htmlHeader.php";
?>


<div class="row">
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php
            require_once dirname(__FILE__) . "/src/html/htmlMenu.php";
        ?> 
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <?php
            require_once dirname(__FILE__) . "/src/html/htmlSlider.php";
        ?>    
    </div>    
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php
        
        if ($isLogged) {
            require_once dirname(__FILE__) . "/src/actions/cart/pageCart.php";
            echo '<center><form action="src/actions/log/logOut.php" method="post" role="form">';
                echo '<button type="submit" value="logOut" name="logOut" class="btn btn-success">LogOut</button>';
            echo '</form></center>';
        } else {
            require_once dirname(__FILE__) . "/src/html/htmlStarter.php";
        }
            
        ?> 
    </div>
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
</div>
    <div>
    <hr>
    </div>
 
 
<div class="row">
    <?php
        require_once dirname(__FILE__) . "/src/html/htmlProducts.php";
    ?>  
</div> 

<?php
require_once dirname(__FILE__) . "/src/html/htmlFooter.php";