<?php

session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

    $isProductId = FALSE;

    if (!empty($_GET['id'])) { 
        $id = $_GET['id'];
        $isProductId = TRUE;
    }

    if ($isProductId) {
        $product = Product::GetProduct($id);
        $name = $product->getName();
        $description = $product->getDescription();
        $price = $product->getPrice();

        $productPhotos = ProductPhoto::GetAllPhotosByProdcuctId($id);

    require_once dirname(__FILE__) . "/../../html/htmlHeader.php";  

    ?>


    <div class="row">

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">  
            <center>
            <legend>Menu</legend>
            <?php if (is_numeric($_SESSION['id'])) { ?>
            <form action="../../../index.php" method="post" role="form" id="center">                                       
                <button type="submit" name="productId" value="<?php echo $id ?>" class="btn btn-success">Add to Cart</button>
            </form>
            <?php } ?>
            <br>
            <form action="../../../index.php" method="post" role="form" id="center">                                       
                <button type="submit" name="productGroup" value="all" class="btn btn-success">Main Page</button>
            </form>
            </center>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

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

            <center>
                <legend><?php echo $name ?></legend>
                <p><?php echo $description ?></p>
                <p><?php echo $price ?> zł</p>
            </center>

        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">        
            <?php
                require_once dirname(__FILE__) . "/../cart/pageCart.php";
            ?>

        </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>
    </div>

    <?php
    }  else {
        header("Location: ../../../index.php");
    }
    require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}
