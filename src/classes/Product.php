<?php

class Product {
    static private $conn;
    
    private $id;
    private $name;
    private $price;
    private $description;
    private $inStock;


    public static function SetConnection($newConnection){
        Product::$conn = $newConnection;
    }
    
    private function __construct($newId, $newName, $newPrice, $newDescription, $newInStock){
        $this->id = $newId;
        $this->name = $newName;
        $this->price = $newPrice;
        $this->description = $newDescription;        
        $this->inStock = $newInStock;
    }
    
    //this function returns:
    //   null if product exist in database
    //   new Product object if new entry was added to table
    public static function CreateProduct($name, $price){
        $sqlStatement = "Select * from Products where name = '$name'";
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting product to db
            $inStock = -1;
            $sqlStatement = "INSERT INTO Products(name, price, description, inStock) values ('$name', $price, '', $inStock)";
            if (Product::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new Product(Product::$conn->insert_id, $name, $price, '', $inStock);
            }
        }
        //there is user with this name in db
        return null;
    }

    public function getId(){
        return $this->id;
    }
}
