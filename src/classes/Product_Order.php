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


}
