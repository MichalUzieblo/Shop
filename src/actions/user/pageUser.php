<?php

session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

$isProductId = TRUE;
    
$userOrders = Order::GetAllUserOrders($user->getId());   
    
$title = 'Shop - User page';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";  

?>

<div class="row">
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
<!--Menu-->
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">        
        <center>
        <legend>Menu</legend>        
            </form>
            <br>
            <form action="../log/logOut.php" method="post" role="form">
                <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log Out</button>
            </form>
            <br>
            <form action="editUser.php" method="post" role="form">
                <button type="submit" value="userBoard" class="btn btn-success">Edit User</button>
            </form>
            <br>
            <form action="../../../index.php" method="post" role="form">
                <button type="submit" value="mainPage" class="btn btn-success">Main Page</button>
            </form>
            <br>
            <form action="deleteUser.php" method="post" role="form">
                <button type="submit" value="deleteUser" class="btn btn-success">Delete User</button>
            </form>
        </center> 
    </div>
    
<!--History of orders-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

        <center>
            <legend>History of Orders</legend>
        </center>
            <?php
            
            $i = 1;
            
            foreach ($userOrders as $order) {
                echo "<b>Order nr " . "$i<br></b>";
                
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
                $i++;
                
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
              
    </div>

<!--Place for the shopping cart-->   
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">        
        <?php
            require_once dirname(__FILE__) . "/../cart/pageCart.php";
        ?>
    </div>
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
</div>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}
