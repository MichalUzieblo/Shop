<?php

//require_once dirname(__FILE__) . "/../connection/connect.php";

if (!empty($productGroup)) {
    
    if ($productGroup == 'offices' || $productGroup == 'residential' 
        || $productGroup == 'hotels' || $productGroup == 'mixed') {
        $products = Product::GetAllProductsByGroup($productGroup);
    } else {
        $products = Product::GetAllProducts();
    }
}

function printProducts ($products) {
    
    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';
    $i = 0;
     
    foreach ($products as $value) {
        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
        echo $value->getName() . '<br>';
        echo $value->getPrice() . '<br>';
        echo $value->getDescription() . '<br>';
        echo '</div/center>';
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
    