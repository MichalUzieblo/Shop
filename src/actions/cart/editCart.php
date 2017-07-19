<?php
session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['add']) || !empty($_POST['del']))) {
    
    if (!empty($_POST['add']) && is_numeric($_POST['add'])) { 
        $id = trim($_POST['add']);
        if (isset($_SESSION['idProductsInCart'])) {
            $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
            $idProductsInCart[] = $id;
            $_SESSION['idProductsInCart'] = serialize($idProductsInCart);
        }
    } elseif (!empty($_POST['del']) && is_numeric($_POST['del'])) {
        $id = trim($_POST['del']); 
        if (isset($_SESSION['idProductsInCart'])) { echo $id;
            $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
            $idToDelete = array_search($id, $idProductsInCart);
            unset ($idProductsInCart[$idToDelete]);
            $_SESSION['idProductsInCart'] = serialize($idProductsInCart);
        }
    }
}

$areProducts = FALSE;

if (isset($_SESSION['idProductsInCart'])) {
    $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
    $areProducts = TRUE;
} else {
    $idProductsInCart = [];
    $areProducts = FALSE;
}

$title = 'Shop - Edit cart';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
?>

<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
            <?php
            if (!$areProducts) {
                echo 'No products in your shopping cart';
            } ?>
            <center>
            <legend>Edit Shopping Cart</legend>            
                
                <?php
                $orderedProductsId = array_count_values($idProductsInCart);
                $sum = 0;
                foreach ($orderedProductsId as $id => $value) { 
                $product = Product::GetProduct($id);    
                ?>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <p align="left"><?php echo $product->getName() ?></p>
                        <p align="right"><?php
                            $pc = ' pcs x ';
                            if ($value == 1) {
                                $pc = ' pc x '; 
                            }
                            echo $value . $pc . $product->getPrice() . ' zł, ';
                            $sum += $product->getPrice() * $value;
                            ?>
                        </p>                        
                    </div>
                    <button type="submit" value="<?php echo $product->getId() ?>" name="add"class="btn btn-success">Add one</button>
                    <button type="submit" value="<?php echo $product->getId() ?>" name="del" class="btn btn-success">Delete one</button>
                    <hr>
                </form>
                
                <?php
                }
                ?>
                <h3><p align="right"> 
                <?php
                echo 'Sum = ' . $sum . ' zł';
                ?>  
                </p></h3>
            <form action="../order/pageOrder.php" method="post" role="form">
                <button type="submit" value="order" name="order" class="btn btn-success">Order</button>                
            </form>
            <br>
            <form action="../../../index.php" method="post" role="form">                
                <button type="submit" value="mainPage" name="editCart" class="btn btn-success">Main Page</button>
            </form>
            </center>
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
        
    </div>
</div>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}