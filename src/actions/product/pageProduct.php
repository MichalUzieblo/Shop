<?php

session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

$isId = FALSE;

if (!empty($_GET['id']) /*&& $isLogged*/) { //Commented to first tests
    
    $id = $_GET['id'];
    $isId = TRUE;
}


if ($isId) {
    $product = Product::GetProduct($id);
    $name = $product->getName();
    $description = $product->getDescription();
    $price = $product->getPrice();
    
    $productPhotos = ProductPhoto::GetAllPhotosByProdcuctId($id);
    
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";  

?>


<div class="row">
    
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">        
    </div>
    
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <center>
            <legend><?php echo $name ?></legend>
            <p><?php echo $description ?></p>
            <p><?php echo $price ?> zł</p>
        </center>
        
        <div id="carousel-example-generic2" class="carousel slide">
            
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic2" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic2" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic2" data-slide-to="2"></li>
            </ol>
            
            <div class="carousel-inner">
                
            <?php
            
            for ($i=0; $i<count($productPhotos); $i++) {
                
                $path = '../..'.$productPhotos[$i]->getPath(); 
                 
                if ($i == 0) { 
                    echo '<div class="item active">';
                } else {
                    echo '<div class="item">';
                }                
                    echo '<img src="'.$path.'" alt="">';
                echo '</div>';                
            }            

            ?>
            </div>

            <a class="left carousel-control" href="#carousel-example-generic2" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic2" data-slide="next">
                <span class="icon-next"></span>
            </a>
            
        </div> 
                
    </div>
    
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    </div>
    
</div>

<?php
}
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";