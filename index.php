<?php
session_start();
require_once dirname(__FILE__) . "/src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogged.php";
require_once dirname(__FILE__) . "/src/actions/log/isLogout.php";

$title = 'Shop';
require_once dirname(__FILE__) . "/src/html/htmlHeader.php";

?>
<div class="row">
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php
//            require_once dirname(__FILE__) . "/src/html/htmlSlider.php";
//        place for Menu
        echo "<h1>Menu</h1>";
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
 
<div class="container">   
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="books">
            <div id="reset">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div><p></p></div>
                
                
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
    </div>    
</div>
    
<div class="row">
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        Produkt 1
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        Produkt 1
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        Produkt 1
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        Produkt 1
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        Produkt 1
    </div>
   
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
</div> 

<?php
require_once dirname(__FILE__) . "/src/html/htmlFooter.php";