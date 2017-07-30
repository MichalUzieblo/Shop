<?php
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['cartOpt'])) {

        $cartOpt = trim($_POST['cartOpt']);

        if ($cartOpt == 'clear') {
            unset($_SESSION['idProductsInCart']);
        }
    }

    if (isset($_SESSION['idProductsInCart'])) {
        $idProductsInCart = unserialize($_SESSION['idProductsInCart']);
    } else {
        $idProductsInCart = [];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['productId'])) {

        $newProductId = trim($_POST['productId']);
        $idProductsInCart [] = $newProductId;
        $_SESSION['idProductsInCart'] = serialize($idProductsInCart);
    }

    function printProductsInCart($idProductsInCart) {

        $orderedProductsId = array_count_values($idProductsInCart);
        $sum = 0;

        foreach ($orderedProductsId as $id => $value) {

            $product = Product::GetProduct($id);

            $pc = ' pcs x ';
            if ($value == 1) {
                $pc = ' pc x ';
            }

            echo '<p align="left">' . $product->getName() . '</p>';
            echo '<p align="right">' . $value . $pc . $product->getPrice() . ' zł </p>';
            $sum += $product->getPrice() * $value;
        }

        echo '<p align="right">sum = ' . $sum . ' zł</p>';
    }
    ?>

    <center>
        <legend>Shopping Cart</legend>
    <?php
    printProductsInCart($idProductsInCart);
    ?>
        <form action="" method="post" role="form">
            <button type="submit" value="clear" name="cartOpt" class="btn btn-success">Clear</button>        
        </form>

        <br>
        
        <form action="
        <?php
        if ($isProductId) {
            echo '../order/pageOrder.php';
        } else {
            echo 'src/actions/order/pageOrder.php';
        }
        ?>
              " method="post" role="form">
            <button type="submit" value="order" name="cartOpt" class="btn btn-success">Order</button>

        </form>

        <br>

        <form action="
        <?php
        if ($isProductId) {
            echo '../cart/editCart.php';
        } else {
            echo 'src/actions/cart/editCart.php';
        }
        ?>
              " method="post" role="form">
            <button type="submit" value="edit" name="cartOpt" class="btn btn-success">Edit</button>
        </form>

        <br>

        <form action="
        <?php
        if ($isProductId) {
            echo '../log/logOut.php';
        } else {
            echo 'src/actions/log/logOut.php';
        }
        ?>
              " method="post" role="form">
            <button type="submit" value="logOut" name="logOut" class="btn btn-success">LogOut</button>
        </form>


    </center>

    <?php
} else {
    header("Location: ../../../index.php");
}
?>
