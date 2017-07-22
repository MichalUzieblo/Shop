<?php
//Connection modul we will use from main part of application
//require_once dirname(__FILE__) . "/../src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['manageType'])) {
    
    $manageType = $_POST['manageType'];

    $productGroups = ProductGroup::GetAllProductGroups();

}

function printProductGroups ($productGroups) {
    
    echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '</div>';

    echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
     
    foreach ($productGroups as $productGroup) {
        $name = $productGroup->getName();
        echo "$name<br>";
        
        echo '<a href="src/actions/manage/group/groupEdit.php?'
        . 'id='.$productGroup->getId().'">Edit</a><br>';
        echo '<a href="src/actions/manage/group/groupDelete.php?'
        . 'id='.$productGroup->getId().'">Delete</a><br>'; 

    }
    echo '</div>';

}

echo '<div class="row">';

    printProductGroups($productGroups); 

    echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
        echo '<a href="src/actions/manage/group/groupAdd.php">Add Group</a><br>';
    echo '</div>';
    
    echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '</div>';
    
    echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '</div>';
echo '</div>';
    