<?php
session_start();

require_once dirname(__FILE__) . "/../../../../src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLoggedAdmin) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['logOutAdmin'])) {

        $logOutAdmin = trim($_POST['logOutAdmin']);

        if ($logOutAdmin == 'logOutAdmin') {
            if (isset($_SESSION['admin_id']) || isset($_SESSION['group_id']) 
                    || isset($_SESSION['product_id']) || isset($_SESSION['user_id']) 
                    || isset($_SESSION['order_id'])) {
                unset($_SESSION['admin_id']);
                unset($_SESSION['group_id']);
                unset($_SESSION['product_id']);
                unset($_SESSION['user_id']);
                unset($_SESSION['order_id']);
            }

            $_SESSION['logOutAdmin'] = $logOutAdmin;
            header("Location: ../../../index.php");
        }
    }

    $title = 'Shop - Log out';
    require_once dirname(__FILE__) . "/../../../../src/html/htmlHeader.php";
    ?>

    <div class="container">
        <div class="row">

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
            </div>

            <center>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                    <form action="" method="post" role="form">
                        <button type="submit" value="logOutAdmin" name="logOutAdmin" class="btn btn-success">Log out Admin</button>
                    </form>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </center>

        </div>
    </div>

    <?php
    require_once dirname(__FILE__) . "/../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../index.php");
}