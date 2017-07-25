<?php

$isLoggedAdmin = FALSE;

if (!empty($_SESSION['admin_id'])) {
    
    $admin_id = $_SESSION['admin_id'];
    $isLoggedAdmin = TRUE;
}

