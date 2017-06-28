<?php
session_start();
require_once dirname(__FILE__) . "/src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogged.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogout.php";

$title = 'Shop';
require_once dirname(__FILE__) . "/src/html/htmlHeader.php";

$productGroup = 'all';

if (!empty($_SESSION['productGroup']='')) {
    switch ($_SESSION['productGroup']) {
        case 'office':
            $productGroup = 'office';
            break;
        case 'residential':
            $productGroup = 'residential';
            break;
        case 'hotels':
            $productGroup = 'office';
            break;
        case 'mixed':
            $productGroup = 'mixed';
            break;
    }
} elseif ($_POST['productGroup'] == 'offices' || $_POST['productGroup'] == 'residential'
        || $_POST['productGroup'] == 'hotels' || $_POST['productGroup'] == 'mixed') {
    $productGroup = $_POST['productGroup'];
    $_POST['productGroup'] = $productGroup;
} else {
    $productGroup = 'all';
}

?>
<div class="row">
    <center>
        <legend>Welcome in The Skyscraper's Shop</legend>
    </center>
</div>

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
//            require_once dirname(__FILE__) . "/src/actions/basket/basket.php";
//            here will be action file with link to user basket wit selected products
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