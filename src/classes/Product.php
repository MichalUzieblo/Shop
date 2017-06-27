<?php

class Product {
    static private $conn;
    
    private $id;
    private $name;
    private $price;
    private $description;
    private $inStock;
    private $type;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        Product::$conn = $newConnection;
    }
    
    private function __construct($newId, $newName, $newPrice, $newDescription, $newInStock, $type){
        $this->id = $newId;
        $this->name = $newName;
        $this->price = $newPrice;
        $this->description = $newDescription;        
        $this->inStock = $newInStock;
        $this->type = $type;
    }
    
    //this function returns:
    //   null if product exist in database
    //   new Product object if new entry was added to table
    public static function CreateProduct($name, $price){
        $sqlStatement = "Select * from Products where name = '$name'";
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting product to db
            $inStock = 0;
            $sqlStatement = "INSERT INTO Products(name, price, description, inStock, type) values ('$name', $price, 'cos', $inStock, 'cos')";
            if (Product::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new Product(Product::$conn->insert_id, $name, $price, 'cos', $inStock, 'cos');
            }
        }
        //there is product with this name in db
        return null;
    }
    
    //this function return:
    //   true if product was deleted
    //   false if not
    public static function DeleteProduct($toDeleteId){
        $sql = "DELETE FROM Products WHERE id = {$toDeleteId}";
        if (Product::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }
    
    //this function return:
    // array with all Products
    public static function GetAllProducts($limit = 0){
        $ret = array();
        $sqlStatement = "Select * from Products";
        if($limit > 0){
            $sqlStatement .= " LIMIT $limit";
        }
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['inStock'], $row['type']);
            }
        }
        return $ret;
    }
    
    //this function return:
    // array with all Products from required group
    public static function GetAllProductsByGroup($type){
        $ret = array();
        $sqlStatement = "Select * from Products where type = '$type'";
        
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['inStock'], $row['type']);
            }
        }
        return $ret;
    }
    
    //this function return:
    //  Product with required id or null if doesn't exist
    public static function GetProduct($id){
        $sqlStatement = "Select * from Products where id = '$id'";
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Product($id, $row['name'], $row['price'], $row['description'], $row['inStock'], $row['type']);
        }
        return null;
    }
    
   

    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    function getPrice() {
        return $this->price;
    }

    function getDescription() {
        return $this->description;
    }

    function getInStock() {
        return $this->inStock;
    }
    
    function getType() {
        return $this->type;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setInStock($inStock) {
        $this->inStock = $inStock;
    }
    
    function setType($type) {
        $this->type = $type;
    }

    
    //this function is responsible for saving any changes done to User to database
    public function saveToDB(){
        $sql = "UPDATE Products SET name='{$this->name}', price='{$this->price}', description='{$this->description}', inStock='{$this->inStock}' WHERE id={$this->id}";
        return Product::$conn->query($sql);
    }
}
