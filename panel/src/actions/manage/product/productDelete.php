<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {

    $switch = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
        $id = trim($_GET['id']);
        $_SESSION['product_id'] = $id;
    } else {
        $switch = 1;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && ( isset($_POST['yes']) || isset($_POST['no']) )) {

        if (!empty($_POST['yes'])) {

            $id = $_POST['yes'];
            $product_id = $_SESSION['product_id'];
            $files = ProductPhoto::GetAllPhotosByProdcuctId($product_id);

            $dir = dirname(__FILE__) . '/../../../../../src';

            if (Product::DeleteProduct($id)) {

                foreach ($files as $file) {

                    $path = $dir . $file->getPath();

                    unlink($path);
                }

                if (isset($_SESSION['product_id'])) {
                    unset($_SESSION['product_id']);
                }

                header("Location: ../../../../index.php?manageType=productManage");
            } else {
                $switch = 2;
            }
        } elseif (!empty($_POST['no'])) {
            header("Location: ../../../../index.php?manageType=productManage");
        }
    }



    $title = 'Shop Admin - Delete Product';
//Header we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";
    ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <center>    
                    <?php
                    if ($switch == 1 || $switch == 2) {
                        echo 'No group in db or empty id';
                        ?>

                        <form action="../../../../index.php" method="post" role="form">
                            <button type="submit" value="productManage" name="manageType" class="btn btn-success">Back</button>  
                        </form>

                        <?php
                    } else {
                        ?>
                        <form action="" method="post" role="form">
                            <legend>Are you sure?</legend>
                            <button type="submit" value="<?php echo $_SESSION['product_id'] ?>" name="yes" class="btn btn-success">Confirm</button>
                            <button type="submit" value="no" name="no" class="btn btn-success">Back</button>  
                        </form> 
                        <?php
                    }
                    ?>
                </center>  
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
            </div>

        </div>
    </div>
    <?php
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}