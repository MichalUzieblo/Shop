<?php

$isLogOut = FALSE;

if (!empty($_SESSION['logOut'])) {
    if ($_SESSION['logOut'] == 'logOut') {
        $isLogOut = TRUE;
    }
}
