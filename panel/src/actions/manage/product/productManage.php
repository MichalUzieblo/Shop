<?php

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['manageType'])) {

    $manageType = $_POST['manageType'];
    $products = Product::GetAllProducts();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['manageType'])) {

    $manageType = $_GET['manageType'];
    $products = Product::GetAllProducts();
}

function printProductGroups($products, $i) {

    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';


    foreach ($products as $product) {
        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';

        $product_id = $product->getId();
        $productPhoto = ProductPhoto::GetProductPhoto($product_id);

        if ($productPhoto) {
            $path = $productPhoto->getPath();

            echo '<img src="../src' . $path . '" alt="" class = "img img-fluid" style="max-width: 100%;" >';
        }

        echo $product->getName() . '<br>';
        echo $product->getPrice() . '<br>';
        echo $product->getDescription() . '<br>';

        echo '<a href="src/actions/manage/product/productEdit.php?'
        . 'id=' . $product->getId() . '" type="submit" class="btn btn-default">Edit</a><br>';
        echo '<a href="src/actions/manage/product/productDelete.php?'
        . 'id=' . $product->getId() . '" type="submit" class="btn btn-default">Delete</a><br>';

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

$i = 0;
$i = printProductGroups($products, $i);

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

    echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '<a href="src/actions/manage/product/productAdd.php" type="submit" class="btn btn-default">Add Product</a>';
    echo '</div></center>';
} else {
    echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '<a href="src/actions/manage/product/productAdd.php" type="submit" class="btn btn-default">Add Product</a>';
    echo '</div></center>';
}
