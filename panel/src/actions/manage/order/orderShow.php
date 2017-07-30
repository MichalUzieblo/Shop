<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {

    $isSet = false;

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
        $id = trim($_GET['id']);
        $_SESSION['order_id'] = $id;
        $order = Order::GetOrder($id);
        $isSet = TRUE;
    }

    $title = 'Shop Admin - Order Show';
    //Header we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";
    ?>
    <div class="container">
        <div class="row">
            <center>

                <legend>Order to edit: <b><?php echo "<b> id = " . $_SESSION['order_id'] . "</b><br>" ?></b></legend>

            </center>
        </div>

        <div class="row">
            
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

            <?php

            if ($isSet) {                  

                echo "<b>Order id nr " . $order->getId() . "<br></b>";

                $order_id = $order->getId();
                $orderStatus = $order->getStatus();
                $orderPaymentType = $order->getPaymentType();
                $orderName = $order->getName();
                $orderSurname = $order->getSurname();
                $orderAddress = $order->getAddress();

                echo "status: $orderStatus <br>";
                echo "payment type: $orderPaymentType <br>";
                echo "Address to send: $orderName $orderSurname, $orderAddress <br>";
                echo "<b>products:</b><br>";

                $product_orders = Product_Order::GetAllByOrderId($order_id);

                $sum = 0;

                foreach ($product_orders as $product_order) {
                    $product_id = $product_order ->getProduct_id();

                    $fixed_price = $product_order ->getFixed_price();
                    $quantity = $product_order ->getQuantity();

                    $sum += $quantity * $fixed_price;

                    $product = Product::GetProduct($product_id);
                    $productName = $product->getName();
                    $productDescription = $product->getDescription();
                    $productGroup_id = $product->getProductGroup_id();
                    $productGroup = ProductGroup::GetProductGroup($productGroup_id)->getName();

                    echo "$productName $fixed_price zł x $quantity = " . $fixed_price * $quantity . " zł<br>";
                    echo "description: $productDescription<br>";
                    echo "type: $productGroup<br><br>";
                }
                echo "<b>sum: $sum zł</b><br><br>";

                echo "<b>Messages from admin to this order:<br></b>";

                $messages = Message::GetAllMessagesByOrderId($order_id);
                $j = 1;

                if (!empty($messages)) {
                    foreach ($messages as $message) {
                        echo $j . '. ' . $message->getMessage() . '<br>';
                        $j++;
                    }
                } else {
                    echo 'No messages<br>';
                }
                echo "<hr>";

            }
            ?>
                <form action="../../../../index.php" method="get" role="form">
                    <button type="submit" class="btn btn-success" value="orderManage" name="manageType">Go to panel</button>
                </form>

            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>
            
        </div>

    </div>

    <?php
    //Footer we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}
