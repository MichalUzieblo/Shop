<?php
session_start();

//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";
//Checking modul from admin part
require_once dirname(__FILE__) . "/../../log/isLogged.php";

if ($isLoggedAdmin) {

$switch = 0;
var_dump($_POST, $_SESSION);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id']) ) {
    $id = trim($_GET['id']);
    $_SESSION['product_id'] = $id;
    $product = Product::GetProduct($id);
    
} 

$product = Product::GetProduct($_SESSION['product_id']);var_dump($product);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['productName'])
        && !empty($_POST['productPrice']) && !empty($_POST['productDesc'])
        && !empty($_POST['productQuantity']) && isset($_SESSION['product_id'])
        && $_POST['actionButton'] == 'info') {
    
    $productName = trim($_POST['productName']);
    $productPrice = trim($_POST['productPrice']);
    $productDesc = trim($_POST['productDesc']);
    $productQuantity = trim($_POST['productQuantity']);        
    
    if (is_object($product)) {
        
        $product->setName($productName);
        $product->setPrice($productPrice);
        $product->setDescription($productDesc);
        $product->setInStock($productQuantity);
        
        if ($product->saveToDB()) {
            
            $switch = 3;
            
        } else {
            Product::DeleteProduct($product->getId());
            $switch = 2;
        }
        
    } else {
        $switch = 1;
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $switch = 4;
}

$title = 'Shop Admin - Edit Product';
//Header we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";


?>
<div class="container">
    <div class="row">
        <center>

            <legend>Product to edit: <b><?php echo $product->getName() ?></b></legend>

        </center>
    </div>
    
    <div class="row">
        
        <center>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
            
            <form action="" method="post" role="form">
                <legend>Edit information</legend>
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
                
                <button type="submit" class="btn btn-success" name="actionButton" 
                        value="info">Save</button>
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
                    echo 'Saved';
                    break;
                case 3:
                    echo 'Empty fields in form';
                    break;
            }
        
        ?>
        </div> 
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            
            <form action="" method="post" role="form">
                <legend>Select group</legend>
                
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
                
                <button type="submit" class="btn btn-success" name="actionButton" 
                        value="group">Save</button>
            </form>
                    
            <?php   
            
            switch ($switch) {
                case 1:
                    echo 'Error with query';
                    break;
                case 2:
                    echo 'Empty field sent';
                    break;                  
            }   
            
            ?>            
        </div>
            
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            
            <form action="" method="post" role="form" enctype="multipart/form-data">
                <legend>Add photo</legend>
                
                <div class="form-group">
                    <label for="">Photo</label>
                    <input type="file" name="image" class="btn btn-default">

                </div>
                <button type="submit" class="btn btn-success" name="actionButton" 
                        value="photo">Save</button>
            </form>
        
            <?php 

            switch ($switch) {
                case 1:
                    echo 'Error with query';
                    break;
                case 2:
                    echo 'Empty field sent';
                    break;                  
            }

            ?>
        </div>
            
        </center>
    </div>
            
    <div class="row">
        
        <center>
        <legend>Back</legend>
        <form action="../../../../index.php" method="post" role="form">
            <button type="submit" class="btn btn-success">Go to panel</button>
        </form>
        </center>
            
    </div>
        
    
</div>
            
<?php
require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}
