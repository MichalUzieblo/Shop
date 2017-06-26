<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['logOut'])) {    
    
    $logOut = trim($_POST['logOut']); 
    
    if ($logOut == 'logOut') {        
        unset ($_SESSION['id']);
        
        $_SESSION['logOut'] = $logOut;
        header("Location: ../../../index.php");        
    } 
}

$title = 'Shop - Log Out';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
?>
            
<form action= method="post" role="form">
    <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log out</button>
</form>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";