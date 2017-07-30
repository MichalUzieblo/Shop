<?php

class Product {

    static private $conn;
    private $id;
    private $name;
    private $price;
    private $description;
    private $inStock;
    private $productGroup_id;
    private $del_by_admin;

    //This function sets connection for this class to use
    //This function needs to be run on startup
    public static function SetConnection($newConnection) {
        Product::$conn = $newConnection;
    }

    private function __construct($newId, $newName, $newPrice, $newDescription, $newInStock, $productGroup_id, $del_by_admin) {
        $this->id = $newId;
        $this->name = $newName;
        $this->price = $newPrice;
        $this->description = $newDescription;
        $this->inStock = $newInStock;
        $this->productGroup_id = $productGroup_id;
        $this->del_by_admin = $del_by_admin;
    }

    //this function returns:
    //null if product exist in database
    //new Product object if new entry was added to table
    public static function CreateProduct($name, $price) {
        $sqlStatement = "Select * from Products where name = '$name' and del_by_admin = 0";
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting product to db
            $inStock = 0;
            $sqlStatement = "INSERT INTO Products(name, price, description, inStock, productGroup_id) values ('$name', $price, 'cos', $inStock, NULL)";
            if (Product::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new Product(Product::$conn->insert_id, $name, $price, 'cos', $inStock, NULL, 0);
            }
        }
        //there is product with this name in db
        return null;
    }

    //this function return:
    //true if product was deleted
    //false if not
    public static function DeleteProduct($toDeleteId) {
        $sql = "DELETE FROM Products WHERE id = {$toDeleteId}";
        if (Product::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    //this function return:
    //array with all Products
    //empty array in no products in db
    public static function GetAllProducts($limit = 0) {
        $ret = array();
        $sqlStatement = "Select * from Products where del_by_admin = 0 and inStock > 0";
        if ($limit > 0) {
            $sqlStatement .= " LIMIT $limit";
        }
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Product($row['id'], $row['name'], $row['price'], 
                        $row['description'], $row['inStock'], $row['productGroup_id'], $row['del_by_admin']);
            }
        }
        return $ret;
    }

    //this function return:
    //array with all Products from required group id
    //empty array in no products with this group
    public static function GetAllProductsByGroup($productGroup_id) {
        $ret = array();
        $sqlStatement = "Select * from Products where productGroup_id = $productGroup_id and del_by_admin = 0 and inStock > 0";

        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Product($row['id'], $row['name'], $row['price'], 
                        $row['description'], $row['inStock'], $row['productGroup_id'], $row['del_by_admin']);
            }
        }
        return $ret;
    }

    //this function return:
    //Product with required id or null if doesn't exist
    public static function GetProduct($id) {
        $sqlStatement = "Select * from Products where id = '$id'";
        $result = Product::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Product($id, $row['name'], $row['price'], $row['description'], $row['inStock'], $row['productGroup_id'], $row['del_by_admin']);
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
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

    function getProductGroup_id() {
        return $this->productGroup_id;
    }
    
    function getDelByAdmin() {
        return $this->del_by_admin;
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

    function setProductGroup_id($productGroup_id) {
        $this->productGroup_id = $productGroup_id;
    }
    
    function setDelByAdmin($status) {
        if ($status == 0 || $status == 1) {
            $this->del_by_admin = $status;
            return true;
        }      
    }

    //this function is responsible for saving any changes done to User to database
    public function saveToDB() {
        $sql = "UPDATE Products SET name='{$this->name}', price='{$this->price}',"
        . "description='{$this->description}', inStock='{$this->inStock}',"
        . "productGroup_id='{$this->productGroup_id}', del_by_admin='{$this->del_by_admin}' WHERE id={$this->id}";
        return Product::$conn->query($sql);
    }

}
