<?php

require_once dirname(__FILE__) . "/../../../config/database.php";
require_once dirname(__FILE__) . "/../../classes/Product.php";
require_once dirname(__FILE__) . "/../../classes/ProductPhoto.php";
require_once dirname(__FILE__) . "/../../classes/User.php";
require_once dirname(__FILE__) . "/../../classes/Admin.php";


$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
if ($conn->connect_error) {
    die("Polaczenie z shop nieudane. Blad: " .
    $conn->connect_error);
} 

Product::SetConnection($conn);
User::SetConnection($conn);
ProductPhoto::SetConnection($conn);
Admin::SetConnection($conn);