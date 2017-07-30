<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

function printProductPhotos($productPhotos, $i) {

    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';


    foreach ($productPhotos as $productPhoto) {

        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';

        $path = $productPhoto->getPath();

        echo '<img src="../../../../../src' . $path . '" alt="" class = "img img-fluid" style="max-width: 100%;" >';

        echo '<a href="?value=' . $productPhoto->getId() . '" type="submit" class="btn btn-default" name="toDelete">Delete</a><br>';

        echo '</div></center>';
        $i++;
        if ($i % 5 == 0) {

            echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
            echo '</div>';
            echo '</div>';

            echo '<div class="row">';
            echo 'p';
            echo '</div>';

            echo '<div class="row">';

            echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
            echo '</div>';
        }
    }
    return $i;
}

if ($isLoggedAdmin) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['value'])) {

        $id = $_GET['value'];

        $productPhoto = ProductPhoto::GetProductPhotoById($id);

        $dir = dirname(__FILE__) . '/../../../../../src';

        $path = $dir . $productPhoto->getPath();

        ProductPhoto::DeleteProductPhoto($id);

        unlink($path);
    }

    if (isset($_SESSION['product_id'])) {
        $id = trim($_SESSION['product_id']);
        $product = Product::GetProduct($id);
        $product_id = $product->getId();
        $productPhotos = ProductPhoto::GetAllPhotosByProdcuctId($product_id);
    }

    $title = 'Shop Admin - Edit Product Photos';
    //Header we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";
    ?>
    <div class="container">
        <div class="row">
            <center>

                <legend>Product to edit: <b>
    <?php
    if (is_object($product)) {
        echo $product->getName();
    }
    ?></b></legend>

            </center>
        </div>

        <div class="row">
            
    <?php
    $i = 0;
    $i = printProductPhotos($productPhotos, $i);

    if ($i % 5 == 0) {

        echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
        echo '</div>';
        echo '</div>';

        echo '<div class="row">';
        echo 'p';
        echo '</div>';

        echo '<div class="row">';

        echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
        echo '</div>';
    }
    ?>
        </div>

        <div class="row">

            <center>
                <legend>Back</legend>
                <form action="../../../../index.php" method="get" role="form">
                    <button type="submit" class="btn btn-success" value="productManage" name="manageType">Go to panel</button>
                </form>
            </center>

        </div>


    </div>

    <?php
    //Footer we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}