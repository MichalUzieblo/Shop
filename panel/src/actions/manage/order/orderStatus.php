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
    $_SESSION['order_id'] = $id;
    $order = Order::GetOrder($id);
    
}

// Action for "Select status" part
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['orderStatus']) )  {
    
    $orderStatus = trim($_POST['orderStatus']);        
    
    if (!empty($_SESSION['order_id'])) {
        
        $id = $_SESSION['order_id'];
        $order = Order::GetOrder($id);
        
        if ($orderStatus == "not confirmed") {
            $order->setIsCart(1);
            $order->setStatus(NULL);
        } else {
            if ($order->getIsCart() == 1) {
                $order->setIsCart(0);            
            }
            
            $order->setStatus($orderStatus);
        }
        
        if ($order->saveToDB()) {
            header("Location: ../../../../index.php?manageType=orderManage");
                        
        } else {
            $switch = 2;
        }
        
    } else {
        $switch = 1;
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $switch = 4;
}

$title = 'Shop Admin - Edit Status';
//Header we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/html/htmlHeader.php";


?>
<div class="container">
    <div class="row">
        <center>

            <legend>Order to edit: <b><?php echo "<b> id = ".$_SESSION['order_id']."</b><br>" ?></b></legend>

        </center>
    </div>
    
    <div class="row">
        
        <center>
            
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            
            <form action="" method="post" role="form">
                <legend>Select status</legend>
                
                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="orderStatus"
                           placeholder="group">    
                        <?php
                        $status = $order ->getStatus();
                        
                        switch ($status) {
                            case 'not paid':
                                ?>
                                <option>not confirmed</option>
                                <option selected>not paid</option>
                                <option>paid</option>
                                <option>completed</option> 
                                <?php
                                break;
                            case 'paid':
                                ?>
                                <option>not confirmed</option>
                                <option>not paid</option>
                                <option selected>paid</option>
                                <option>completed</option> 
                                <?php
                                break;
                            case 'completed':
                                ?>
                                <option>not confirmed</option>
                                <option>not paid</option>
                                <option>paid</option>
                                <option selected>completed</option> 
                                <?php
                                break;
                            default:
                                ?>
                                <option selected>not confirmed</option>
                                <option>not paid</option>
                                <option>paid</option>
                                <option>completed</option> 
                                <?php
                                break;
                        }
                        ?>                                               
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success">Save</button>
            </form>
                    
            <?php   
            
            switch ($switch) {
                case 1:
                    echo 'Empty sessions with order id';
                    break;
                case 2:
                    echo 'Problem with saving order to db';
                    break;
                case 4:
                    echo 'Empty fields in form';
                    break;
            }  
            
            ?>  
        <form action="../../../../index.php" method="get" role="form">
            <button type="submit" class="btn btn-success" value="orderManage" name="manageType">Go to panel</button>
        </form>
            
        </div>
            
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        </div>

        </center>
    </div>
    
</div>
            
<?php
require_once dirname(__FILE__) . "/../../../../../src/html/htmlFooter.php";
} else {
    header("Location: ../../../../index.php");
}
