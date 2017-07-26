<?php

require_once dirname(__FILE__) . "/../actions/connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['productGroupId'])) {
    
    $productGroup_id = $_POST['productGroupId'];
    
    if (is_numeric($productGroup_id)) {
        $products = Product::GetAllProductsByGroup($productGroup_id);
    } else {
    $products = Product::GetAllProducts();
    }
}  else {
    $products = Product::GetAllProducts();        
        
}

function printProducts ($products) {
    
    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';
    $i = 0;
     
    foreach ($products as $value) {
        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
        
        $product_id = $value->getId();
        $productPhoto = ProductPhoto::GetProductPhoto($product_id);
        
        if ($productPhoto) {
            $path = $productPhoto ->getPath();

            echo '<a href="src/actions/product/pageProduct.php?id='.$value->getId().'">';
            echo '<img src="src'.$path.'" alt="" class = "img img-fluid" style="max-width: 100%;" >';
            echo '</a>';

        }
        
        echo '<a href="src/actions/product/pageProduct.php?'
        . 'id='.$value->getId().'">'.$value->getName().'</a><br>';
        
        echo $value->getPrice() . '<br>';
        echo $value->getDescription() . '<br>';
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
}

printProducts($products); 
    