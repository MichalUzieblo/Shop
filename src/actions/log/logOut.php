<?php
session_start();

require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['logOut'])) {

        $logOut = trim($_POST['logOut']);

        if ($logOut == 'logOut') {
            if (isset($_SESSION['idProductsInCart'])) {
                $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
                $cart = Order::CreateCart($user->getId());
                $order_id = $cart->getId();
                $orderedProductsId = array_count_values($idProductsInCart);

                foreach ($orderedProductsId as $product_id => $quantity) {

                    $product = Product::GetProduct($product_id);
                    $fixed_price = $product->getPrice();

                    $product_order = Product_Order::CreateProduct_Order($product_id, $order_id, $fixed_price, $quantity);
                }

                if (is_object($cart) && is_object($product_order)) {
                    $isConfirmed = TRUE;
                }
                unset($_SESSION['idProductsInCart']);
            }
            if (isset($_SESSION['id'])) {
                unset($_SESSION['id']);
            }

            $_SESSION['logOut'] = $logOut;
            header("Location: ../../../index.php");
        }
    }

    $title = 'Shop - Log out';
    require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
    ?>

    <div class="container">
        <div class="row">

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
            </div>

            <center>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                    <form action="" method="post" role="form">
                        <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log out</button>
                    </form>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </center>

        </div>
    </div>

    <?php
    require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}