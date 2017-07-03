<?php

require_once dirname(__FILE__) . "/../connection/connect.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['cartOpt'])) {
    
    $cartOpt = trim($_POST['cartOpt']);
    
    if ($cartOpt == 'clear') {
        unset($_SESSION['idProductsInCar']);
    } elseif ($cartOpt == 'logOut') {
        require_once dirname(__FILE__) . "../../log/logOut.php";
    }
}

//$canPrint = true;

if (isset($_SESSION['idProductsInCar'])) {
    $idProductsInCar = unserialize($_SESSION['idProductsInCar']);
} else {
    $idProductsInCar = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['productId'])) {
    
    $newProductId = trim($_POST['productId']);
    $idProductsInCar [] = $newProductId;
    $_SESSION['idProductsInCar'] = serialize($idProductsInCar);
//    $canPrint = true;

}
 
function printProductsInCart($idProductsInCar) {
    
    $sum = 0;
    
    foreach ($idProductsInCar as $id) {
        $product = Product::GetProduct($id);
        echo $product->getName() . ' ';
        echo $price=$product->getPrice() . ' zł<br>';
        $sum += $price;
    }
    
    echo 'sum = ' . $sum . ' zł';
}

?>

<center>
    <legend>Shopping Cart</legend>
    <?php
    
//    if ($canPrint) {
        printProductsInCart($idProductsInCar);
//    }
    ?>
    <form action="" method="post" role="form">
        <button type="submit" value="order" name="cartOpt" class="btn btn-success">Order</button>
        <button type="submit" value="clear" name="cartOpt" class="btn btn-success">Clear</button>        
    </form>
    <!--<br>-->
    <form action="src/actions/cart/editCart.php" method="post" role="form">
        <button type="submit" value="edit" name="cartOpt" class="btn btn-success">Edit</button>
    </form>
    
</center>

