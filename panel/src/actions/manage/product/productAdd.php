<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {
    $switch = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['productName']) 
            && !empty($_POST['productPrice']) && !empty($_POST['productDesc']) 
            && !empty($_POST['productQuantity']) && !empty($_POST['productGroupId'])) {

        $productName = trim($_POST['productName']);
        $productPrice = trim($_POST['productPrice']);
        $productDesc = trim($_POST['productDesc']);
        $productQuantity = trim($_POST['productQuantity']);
        $productGroupId = trim($_POST['productGroupId']);

        $newProduct = Product::CreateProduct($productName, $productPrice);

        if (is_object($newProduct)) {
            $newProduct->setDescription($productDesc);
            $newProduct->setInStock($productQuantity);
            $newProduct->setProductGroup_id($productGroupId);

            if ($newProduct->saveToDB()) {

                $name = $_FILES['image']['name'];
                $dir = dirname(__FILE__) . '/../../../../../src/db/photos/';
                $productPhoto = ProductPhoto::CreateProductPhoto($newProduct->getId(), "/db/photos/$name");

                if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK && $productPhoto) {

                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $dir . $name);

                    if ($result) {

                        header("Location: ../../../../index.php?manageType=productManage");
                    } else {
                        ProductPhoto::DeleteProductPhoto($productPhoto->getId());
                        Product::DeleteProduct($newProduct->getId());
                        $switch = 4;
                    }
                } else {
                    Product::DeleteProduct($newProduct->getId());
                    $switch = 3;
                }
            } else {
                Product::DeleteProduct($newProduct->getId());
                $switch = 2;
            }
        } else {
            $switch = 1;
        }
    }

    $title = 'Shop Admin - New Product';
    //Header we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";
    ?>
    <div class="container">
        <div class="row">

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
            </div>
            <center>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <form action="" method="post" role="form" enctype="multipart/form-data">
                        <legend>New product</legend>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="productName"
                                   placeholder="Product name">
                        </div>    
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" class="form-control" name="productPrice"
                                   placeholder="price" step="0.01">
                        </div> 
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="textarea" class="form-control" name="productDesc"
                                   placeholder="description">
                        </div>  
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" class="form-control" name="productQuantity"
                                   placeholder="quantity">
                        </div>
                        <div class="form-group">
                            <label for="">Groups</label>
                            <select class="form-control" name="productGroupId"
                                    placeholder="group">
                                <?php
                                $productGroups = ProductGroup::GetAllProductGroups();
                                foreach ($productGroups as $productGroup) {
                                    echo '<option value = ' . $productGroup->getId() . ' >';
                                    echo $productGroup->getName();
                                    echo '</option>';
                                }
                                ?>                        
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Photo</label>
                            <input type="file" name="image" class="btn btn-default">

                        </div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>

                    <form action="../../../../index.php" method="post" role="form">
                        <button type="submit" class="btn btn-success">Go to panel</button>
                    </form>

                    <?php
                    switch ($switch) {
                        case 1:
                            echo 'Product already exist in db';
                            break;
                        case 2:
                            echo 'Problem with saving new product to db';
                            break;
                        case 3:
                            echo 'No foto loaded or problem with path saving to db';
                            break;
                        case 4:
                            echo 'Error with saving photo';
                            break;
                    }
                    ?>

                </div>
            </center>       

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            </div>

        </div>
    </div>

    <?php
    //Footer we will use from main part of application
    require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}
