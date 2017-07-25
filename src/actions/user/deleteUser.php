<?php
session_start();

require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteUser'])
        && isset($_POST['password'])) {
    
    if (!empty($_POST['deleteUser']) && !empty($_POST['password'])) {
        
        $deleteUser = trim($_POST['deleteUser']);    
        $password = trim($_POST['password']);
        
        switch ($deleteUser) {
            case 'no':
                header("Location: ../user/pageUser.php");
                break;
            case 'yes':
                
                if (User::DeleteUser($user, $password)) {
                    if (isset($_SESSION['id'])) {
                        unset($_SESSION['id']);                  
                    } 
                    if (isset($_SESSION['idProductsInCar'])) {
                        unset($_SESSION['idProductsInCar']);
                    }
                    header("Location: ../../../index.php");
                } else {
                    echo 'nie udalo sie';
                }
                
                break;                
        }
        
    } else {
        echo 'Spróbuj jeszcze raz';
    } 
} 

$title = 'Shop - Delete User';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";
?>

<div class="container">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <center>
            <form action="" method="post" role="form">
                <legend>Are you sure <?php echo $user->getName() . ' ?'; ?></legend>

                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Password">
                </div>
                <button type="submit" value="yes" name="deleteUser" class="btn btn-success">Confirm</button>
                <button type="submit" value="no" name="deleteUser" class="btn btn-success">Back</button>  
            </form>
        </div>
        </center>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
    </div>
</div>
<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}