<?php

class ProductGroup {

    static private $conn;
    private $id;
    private $name;

    //This function sets connection for this class to use
    //This function needs to be run on startup
    public static function SetConnection($newConnection) {
        ProductGroup::$conn = $newConnection;
    }

    private function __construct($newId, $newName) {
        $this->id = $newId;
        $this->name = $newName;
    }

    //this function returns:
    //null if group exist in database
    //new ProductGroup object if new entry was added to the table
    public static function CreateProductGroup($name) {
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

    //this function returns:
    //array with all ProductGroups,
    //empty table if no ProductGroups in the db
    public static function GetAllProductGroups() {
        $ret = array();
        $sqlStatement = "Select * from ProductGroups";
        $result = ProductGroup::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new ProductGroup($row['id'], $row['name']);
            }
        }
        return $ret;
    }

    //this function returns:
    //true if productGroup was deleted
    //false if not
    public static function DeleteProductGroup($toDeleteId) {
        $sql = "DELETE FROM ProductGroups WHERE id = {$toDeleteId}";
        if (ProductGroup::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    //this function returns:
    //ProductGroup with required id or null if doesn't exist
    public static function GetProductGroup($id) {
        $sqlStatement = "Select * from ProductGroups where id = '$id'";
        $result = ProductGroup::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new ProductGroup($id, $row['name']);
        }
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    //this function is responsible for saving any changes done to ProductGroups to database
    public function saveToDB() {
        $sql = "UPDATE ProductGroups SET name='{$this->name}' WHERE id={$this->id}";
        return ProductGroup::$conn->query($sql);
    }

}
