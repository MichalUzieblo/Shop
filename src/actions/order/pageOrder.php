<?php
session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

$areProducts = FALSE;

if (isset($_SESSION['idProductsInCart'])) {
    $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
    $areProducts = TRUE;
} else {
    $idProductsInCart = [];
    $areProducts = FALSE;
}

$isConfirmed = FALSE;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name'])
        && !empty($_POST['surname']) && !empty($_POST['address'])
        && !empty($_POST['paymentType']) && $areProducts) {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $address = trim($_POST['address']);
    $paymentType = trim($_POST['paymentType']);
    $order = Order::CreateOrder($user->getId(), 'not paid', $paymentType, $name, $surname, $address);
   
    $order_id = $order ->getId();    
    $orderedProductsId = array_count_values($idProductsInCart);
    
    foreach ($orderedProductsId as $product_id => $quantity) {
        
        $product = Product::GetProduct($product_id);
        $fixed_price = $product->getPrice();
        
        $product_order = Product_Order::CreateProduct_Order($product_id, $order_id, $fixed_price, $quantity);
    }

    if (is_object($order) && is_object($product_order)) {
        $isConfirmed = TRUE;
    }
    unset($_SESSION['idProductsInCart']); 
}

$title = 'Shop - Order page';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
?>

<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">   
            <center>
                </form><br>
                <form action="../log/logOut.php" method="post" role="form">
                    <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log Out</button>
                </form><br>
                <form action="../user/pageUser.php" method="post" role="form">
                    <button type="submit" value="userBoard" class="btn btn-success">User Page</button>
                </form><br>
                <form action="../../../index.php" method="post" role="form">
                    <button type="submit" value="mainPage" class="btn btn-success">Main Page</button>
                </form><br>
            </center>
        </div>
        <?php if ($isConfirmed === FALSE) { ?>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
            <?php
            if (!$areProducts) {
                echo 'No products in your shopping cart';
            } ?>
            <center>
            <legend>You order</legend>            
                
                <?php
                $orderedProductsId = array_count_values($idProductsInCart);
                $sum = 0;
                foreach ($orderedProductsId as $id => $value) { 
                $product = Product::GetProduct($id);    
                ?>
                
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
             
                <?php
                }
                ?>
                <h3><p align="right"> 
                <?php
                echo 'Sum = ' . $sum . ' zł';
                ?>  
                </p></h3>
            
            <form action="" method="post" role="form">
                <legend>Check your address to send</legend>
                <?php
                require_once dirname(__FILE__) . "/../user/formUser.php";
                ?>   
                <div class="form-group">
                    <label for="">Payment type</label>
                    <select name="paymentType">
                        <option>cash</option>
                        <option>transfer</option>
                    </select>
                </div>
                <center><button type="submit" value="editProfile" class="btn btn-success">Submit your order</button></center>              
            </form>

            </center>
        </div>
        <?php } else { ?>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <center>
                <legend>Order confirmed</legend>
            </center>
        </div>
        <?php } ?>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
    </div>
</div>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";