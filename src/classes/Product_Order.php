<?php

class Product_Order {
    static private $conn;
    
    private $id;
    private $product_id;
    private $order_id;
    private $fixed_price;
    private $quantity;
    
    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        Product_Order::$conn = $newConnection;
    }
    
    private function __construct($newId, $newProduct_id, $newOrder_id, $newFixed_price, $newQuantity){
        $this->id = $newId;
        $this->product_id = $newProduct_id;
        $this->order_id = $newOrder_id;
        $this->fixed_price = $newFixed_price;        
        $this->quantity = $newQuantity;
    }
    
    //   this function returns:
    //   null if sql is wrong
    //   new Order object if new entry was added to table
    public static function CreateProduct_Order($product_id, $order_id, $fixed_price, $quantity){
        
        $sqlStatement = "INSERT INTO Products_Orders(product_id, order_id, fixed_price, quantity)"
                . "values ($product_id, $order_id, $fixed_price, $quantity)";
        if (Product_Order::$conn->query($sqlStatement) === TRUE) {
            //entery was added to DB so we can return new object
            return new Product_Order(Product_Order::$conn->insert_id, $product_id, $order_id, $fixed_price, $quantity);
        }
        //there is an error with sql
        return null;
    }
    
    //   this function return:
    //   true if product_order was deleted
    //   false if not
    public static function DeleteProduct_Order($toDeleteId){
        $sql = "DELETE FROM Products_Orders WHERE id = {$toDeleteId}";
        if (Product_Order::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }
    
    //   this function return:
    //   array with all products from products_orders with requested id
    public static function GetAllByOrderId($order_id){
        $ret = array();
        $sqlStatement = "Select * from Products_Orders where order_id = $order_id";
        $result = Product_Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Product_Order($row['id'], $row['product_id'], $row['order_id'], $row['fixed_price'], $row['quantity']);
            }
        }
        return $ret;
    }
    
    //   this function return:
    //   array with all orders for specified product
    public static function GetAllByProductId($product_id){
        $ret = array();
        $sqlStatement = "Select * from Products_Orders where product_id = $product_id";
        $result = Product_Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Product_Order($row['id'], $row['product_id'], $row['order_id'], $row['fixed_price'], $row['quantity']);
            }
        }
        return $ret;
    }
    
    //  this function return:
    //  Product_Order with required id or null if doesn't exist
    public static function GetProduct_Order($id){
        $sqlStatement = "Select * from Products_Orders where id = '$id'";
        $result = Product_Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Product_Order($row['id'], $row['product_id'], $row['order_id'], $row['fixed_price'], $row['quantity']);
        }
        return null;
    }
  
    function getId() {
        return $this->id;
    }

    function getProduct_id() {
        return $this->product_id;
    }

    function getOrder_id() {
        return $this->order_id;
    }

    function getFixed_price() {
        return $this->fixed_price;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    function setOrder_id($order_id) {
        $this->order_id = $order_id;
    }

    function setFixed_price($fixed_price) {
        $this->fixed_price = $fixed_price;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    //this function is responsible for saving any changes done to Order to database
    public function saveToDB(){
        $sql = "UPDATE Products_Orders SET id={$this->id}, product_id={$this->product_id},"
        . "order_id='{$this->order_id}', fixed_price={$this->fixed_price},"
        . "quantity='{$this->quantity}' WHERE id={$this->id}";
        return Product_Order::$conn->query($sql);
    }

}
