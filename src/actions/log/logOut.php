<?php
session_start();

require_once dirname(__FILE__) . "/../connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['logOut'])) {    
    
    $logOut = trim($_POST['logOut']); 
    
    if ($logOut == 'logOut') {        
        unset ($_SESSION['id']);
        
        $_SESSION['logOut'] = $logOut;
        header("Location: ../../../index.php");        
    } 
}

$title = 'Shop - Log out';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
?>

<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
        <center>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                <form action="" method="post" role="form">
                    <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log out</button>
                </form>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>
        </center>
        
    </div>
</div>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";