<?php

class ProductGroup {
    static private $conn;
    
    private $id;
    private $name;
    
    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        ProductGroup::$conn = $newConnection;
    }
    
    private function __construct($newId, $newName){
        $this->id = $newId;
        $this->name = $newName; 
    }
    
    //this function returns:
    //   null if group exist in database
    //   new ProductGroup object if new entry was added to table
    public static function CreateProductGroup($name){
        $sqlStatement = "Select * from ProductGroups where name = '$name'";
        $result = ProductGroup::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting ProductPhoto to db
            $sqlStatement = "INSERT INTO ProductGroups(name) values ('$name')";
            if (ProductGroup::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new ProductGroup(ProductGroup::$conn->insert_id, $name);
            }
        }
        //there is product group with this name in db
        return null;
    }    
    
    //TODO
    //GetAllProductGroups
    //AddNewProductGroup
    //DeleteProductGroup
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

                
    //this function is responsible for saving any changes done to ProductPhotos to database
    public function saveToDB(){
        $sql = "UPDATE ProductPhotos SET product_id={$this->product_id}, path='{$this->path}' "
        . ", name='{$this->name}'WHERE id={$this->id}";
        return ProductGroup::$conn->query($sql);
    }

}