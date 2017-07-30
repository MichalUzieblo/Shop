<?php
//Connection modul we will use from main part of application
require_once dirname(__FILE__) . "/../../../../../src/actions/connection/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['manageType'])) {

    $manageType = $_POST['manageType'];
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['manageType'])) {

    $manageType = $_GET['manageType'];
}

//function to print a table with orders
function printOrders($orders, $i) {

    echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
    echo '</div>';

    foreach ($orders as $order) {

        echo '<center><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';

        $order_id = $order->getId();
        $orderStatus = $order->getStatus();
        $orderUser_id = $order->getUser_id();
        $userName = User::GetUser($orderUser_id)->getName();


        echo "<b>Order id: $order_id</b><br>";
        echo "user: $userName<br>";
        echo "status: $orderStatus<br>";

        echo '<a href="src/actions/manage/order/orderStatus.php?'
        . 'id=' . $order_id . '" type="submit" class="btn btn-default">Change status</a><br>';
        echo '<a href="src/actions/manage/order/orderDelete.php?'
        . 'id=' . $order_id . '" type="submit" class="btn btn-default">Delete</a><br>';
        echo '<a href="src/actions/manage/order/orderMessage.php?'
        . 'id=' . $order_id . '" type="submit" class="btn btn-default">Send a message</a><br>';
        echo '<a href="src/actions/manage/order/orderShow.php?'
        . 'id=' . $order_id . '" type="submit" class="btn btn-default">Show order</a><br>';

        echo '</div></center>';
        $i++;
        if ($i % 5 == 0) {

            echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
            echo '</div>';
            echo '</div>';

            echo '<div class="row">';
            echo 'p';
            echo '</div>';

            echo '<div class="row">';

            echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
            echo '</div>';
        }
    }
    return $i;
}
?>
<!--Panel to choose what type of orders admin want to edit-->
<div class="row">

    <center>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="not confirmed" name="orderType" class="btn btn-info">Not confirmed</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="not paid" name="orderType" class="btn btn-info">Not paid</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="paid" name="orderType" class="btn btn-info">Paid</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <form action="" method="post" role="form" id="center">
                <button type="submit" value="completed" name="orderType" class="btn btn-info">Completed</button>
            </form>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        </div>

    </center> 

</div>

<div>
    <hr>
</div>
<!--end of panel-->

<?php
if (isset($orderType)) {
    $i = 0;
    $i = printOrders($orders, $i);
}