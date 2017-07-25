<?php

$isLogged = FALSE;

if (!empty($_SESSION['id'])) {
    
    $id = $_SESSION['id'];
    
    $user = User::GetUser($id);
    
    if (is_object($user)) {
        $isLogged = TRUE;
    }
    
}

