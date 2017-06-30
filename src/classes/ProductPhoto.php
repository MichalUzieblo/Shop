<?php

class ProductPhoto {
    static private $conn;
    
    private $id;
    private $product_id;
    private $path;
    
    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        ProductPhoto::$conn = $newConnection;
    }
    
    private function __construct($newId, $newProduct_Id, $newPath){
        $this->id = $newId;
        $this->product_id = $newProduct_Id;
        $this->path = $newPath;        
    }
    
    //this function returns:
    //   null if photo exist in database
    //   new Product object if new entry was added to table
    public static function CreateProductPhoto($product_Id, $path, $name){
        $sqlStatement = "Select * from ProductPhotos where name = '$name'";
        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting ProductPhoto to db
            $sqlStatement = "INSERT INTO ProductPhotos(product_id, path, name) values ($product_Id, '$path', '$name')";
            if (ProductPhoto::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new ProductPhoto(ProductPhoto::$conn->insert_id, $product_Id, $path, $name);
            }
        }
        //there is product photo with this name in db
        return null;
    }    
    
    //this function return:
    // array with all product photos from required group
    public static function GetAllPhotosByProdcuctId($product_id){
        $ret = array();
        $sqlStatement = "Select * from ProductPhotos where product_id = '$product_id'";
        
        $result = ProductPhoto::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new ProductPhoto($row['id'], $row['product_id'], $row['path'], $row['name']);
            }
        }
        return $ret;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getPath(){
        return $this->path;
    }
    
    //this function is responsible for saving any changes done to ProductPhotos to database
    public function saveToDB(){
        $sql = "UPDATE ProductPhotos SET product_id={$this->product_id}, path='{$this->path}' WHERE id={$this->id}";
        return ProductPhoto::$conn->query($sql);
    }

}