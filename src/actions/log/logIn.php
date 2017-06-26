<?php

session_start();

require_once dirname(__FILE__) . "/../connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])
        && isset($_POST['password'])) {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        if ((User::AuthenticateUser($email, $password) != NULL)) {
            $_SESSION['id'] = $row['id'];
            header("Location: ../board/mainBoard.php");
        } else {
            $badPass = 'wrongEmail';
        }
    } elseif (isset($_POST['register'])) {
        header("Location: ../user/newUser.php");
    } elseif (isset($_POST['mainPage'])) {
        header("Location: ../../../index.php");
    } else {
        $badPass = 'completeData';
    }
} elseif (isset($_POST['register'])) {
    header("Location: ../user/newUser.php");
} else {    
    $badPass = 'noData';
} 

function whatIfWrongLogData($badPass) {            
        switch ($badPass) {
            case 'wrongPass':
                echo 'Wrong password';
                break;
            case 'wrongEmail':
                echo 'Wrong email';
                break;
            case 'completeData':
                echo 'Incomplete data';
                break;
            case 'noData':
                echo 'Provide login information';
                break;                   
        }
}
 

$title = 'Shop - Log in';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
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
                <legend>Log in</legend>
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
                <button type="submit" value="newUser" name="register" class="btn btn-success">Register</button>
                <button type="submit" value="mainPage" name="mainPage" class="btn btn-success">Main Page</button>
            </form>            
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
        
    </div>
</div>

<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
