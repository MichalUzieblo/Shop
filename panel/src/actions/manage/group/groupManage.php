<?php

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['manageType'])) {

    $manageType = $_POST['manageType'];
    $productGroups = ProductGroup::GetAllProductGroups();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['manageType'])) {

    $manageType = $_GET['manageType'];
    $productGroups = ProductGroup::GetAllProductGroups();
}

function printProductGroups($productGroups, $i) {

    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';


    foreach ($productGroups as $productGroup) {
        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';

        $name = $productGroup->getName();
        echo "$name<br>";

        echo '<a href="src/actions/manage/group/groupEdit.php?'
        . 'id=' . $productGroup->getId() . '" type="submit" class="btn btn-default">Edit</a><br>';
        echo '<a href="src/actions/manage/group/groupDelete.php?'
        . 'id=' . $productGroup->getId() . '" type="submit" class="btn btn-default">Delete</a><br>';

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
$i = printProductGroups($productGroups, $i);

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
    echo '<a href="src/actions/manage/group/groupAdd.php" type="submit" class="btn btn-default">Add Group</a>';
    echo '</div></center>';
} else {
    echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    echo '<a href="src/actions/manage/group/groupAdd.php" type="submit" class="btn btn-default">Add Group</a>';
    echo '</div></center>';
}
