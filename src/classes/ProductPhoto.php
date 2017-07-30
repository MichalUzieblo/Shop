<?php

class ProductPhoto {

    static private $conn;
    private $id;
    private $product_id;
    private $path;

    //This function sets connection for this class to use
    //This function needs to be run on startup
    public static function SetConnection($newConnection) {
        ProductPhoto::$conn = $newConnection;
    }

    private function __construct($newId, $newProduct_Id, $newPath) {
        $this->id = $newId;
        $this->product_id = $newProduct_Id;
        $this->path = $newPath;
    }

    //this function returns:
    //null if path exist in db
    //new ProductPhoto object if new entry was added to table
    public static function CreateProductPhoto($product_Id, $path) {
        $sqlStatement = "Select * from ProductPhotos where path = '$path'";
        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            $sqlStatement = "INSERT INTO ProductPhotos(product_id, path) values ($product_Id, '$path')";
            if (ProductPhoto::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new ProductPhoto(ProductPhoto::$conn->insert_id, $product_Id, $path);
            }
        }
        //there is a product photo with this name in db
        return null;
    }

    //this function return:
    //array with all product photos from required group
    //null if doesn't exist
    public static function GetAllPhotosByProdcuctId($product_id) {
        $ret = array();
        $sqlStatement = "Select * from ProductPhotos where product_id = $product_id";

        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new ProductPhoto($row['id'], $row['product_id'], $row['path']);
            }
        }
        return $ret;
    }

    //this function return:
    //true if productPhoto was deleted
    //false if not
    public static function DeleteProductPhoto($toDeleteId) {
        $sql = "DELETE FROM ProductPhotos WHERE id = {$toDeleteId}";
        if (ProductPhoto::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    //this function return:
    //ProductPhoto with required product_id or null if doesn't exist
    public static function GetProductPhoto($product_id) {
        $sqlStatement = "Select * from ProductPhotos where product_id = '$product_id' limit 1";
        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new ProductPhoto($row['id'], $row['product_id'], $row['path']);
        }
        return null;
    }

    //this function return:
    //ProductPhoto with required id or null if doesn't exist
    public static function GetProductPhotoById($id) {
        $sqlStatement = "Select * from ProductPhotos where id = '$id'";
        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new ProductPhoto($row['id'], $row['product_id'], $row['path']);
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getProduct_id() {
        return $this->product_id;
    }

    public function getPath() {
        return $this->path;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    function setPath($path) {
        $this->path = $path;
    }

    //this function is responsible for saving any changes done to ProductPhotos to database
    public function saveToDB() {
        $sql = "UPDATE ProductPhotos SET product_id={$this->product_id}, path='{$this->path}' WHERE id={$this->id}";
        return ProductPhoto::$conn->query($sql);
    }

}
