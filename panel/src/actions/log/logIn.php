<?php

session_start();

require_once dirname(__FILE__) . "/../../../../src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLoggedAdmin === FALSE) {

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])
        && isset($_POST['password'])) {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        $admin = Admin::AuthenticateAdmin($email, $password);
        
        if (($admin != NULL)) {
            
            $_SESSION['admin_id'] = $admin->getId();
            unset ($_SESSION['logOut']);
            header("Location: ../../../index.php");
            
        } else {
            $badPass = 'wrongPass';
        }
    } else {
        $badPass = 'completeData';
    }
} else {    
    $badPass = 'noData';
} 

function whatIfWrongLogData($badPass) {            
        switch ($badPass) {
            case 'wrongPass':
                echo 'Wrong password or email';
                break;
            case 'completeData':
                echo 'Incomplete data';
                break;
            case 'noData':
                echo 'Provide login information';
                break;                   
        }
}
 

$title = 'Shop - Log admin';
require_once dirname(__FILE__) . "/../../../../src/html/htmlHeader.php";
?>

<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
            <?php
            if (!empty($badPass)) {
                whatIfWrongLogData($badPass);
            } ?>
            <form action="" method="post" role="form">
                <legend>Log Admin</legend>
                <div class="form-group">
                    <label for="">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email"
                           placeholder="email@email.com">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="email"
                           placeholder="Password">
                </div>
                <button type="submit" value="logInn" class="btn btn-success">Log in</button>
            </form>            
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
        
    </div>
</div>

<?php
require_once dirname(__FILE__) . "/../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}
