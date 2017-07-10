<?php

require_once dirname(__FILE__) . "/User.php";

class Order {
    static private $conn;
    
    private $id;
    private $user_id;
    private $status;
    private $isCart;
    private $paymentType;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        Order::$conn = $newConnection;
    }
    
    private function __construct($newId, $newUser_id, $newStatus, $newIsCart, $newPaymentType){
        $this->id = $newId;
        $this->user_id = $newUser_id;
        $this->status = $newStatus;
        $this->isCart = $newIsCart;        
        $this->paymentType = $newPaymentType;
    }
    
    //this function returns:
    //   null if Order exist in database
    //   new Order object if new entry was added to table
    public static function CreateOrder($user_id, $status, $paymentType){
        
        $sqlStatement = "INSERT INTO Orders(user_id, status, paymentType) values ($user_id, '$status', '$paymentType')";
        if (Order::$conn->query($sqlStatement) === TRUE) {
            //entery was added to DB so we can return new object
            return new Order(Order::$conn->insert_id, $user_id, $status, 0, $paymentType);
        }
        //there is an error with sql
        return null;
    }
    
    //   this function returns:
    //   null if cart exist in database
    //   new Order object if new entry was added to table
    public static function CreateCart($user_id){
        $sqlStatement = "Select * from Orders where isCart = 1";
        $result = Order::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting cart to db
            $sqlStatement = "INSERT INTO Orders(isCart) values (1)";
            if (Order::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new Order(Order::$conn->insert_id, NULL, NULL, 1, NULL);
            }
        }
        //there is product with this name in db
        return null;
    }
    
    //   this function return:
    //   true if order was deleted
    //   false if not
    public static function DeleteOrder($toDeleteId){
        $sql = "DELETE FROM Orders WHERE id = {$toDeleteId}";
        if (Order::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }
    
    //   this function return:
    //   array with all Orders
    public static function GetAllOrders($limit = 0){
        $ret = array();
        $sqlStatement = "Select * from Orders where isCart = 0";
        if($limit > 0){
            $sqlStatement .= " LIMIT $limit";
        }
        $result = Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Order($row['id'], $row['user_id'], $row['status'], $row['isCart'], $row['paymentType']);
            }
        }
        return $ret;
    }
    
    //  this function return:
    //  Order with required id or null if doesn't exist
    public static function GetOrder($id){
        $sqlStatement = "Select * from Orders where id = '$id'";
        $result = Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Order($row['id'], $row['user_id'], $row['status'], $row['isCart'], $row['paymentType']);
        }
        return null;
    }
    
    //  this function return Cart if exist
    public static function GetCart(){
        $sqlStatement = "Select * from Orders where isCart = 1";
        $result = Order::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new Order($row['id'], $row['user_id'], $row['status'], $row['isCart'], $row['paymentType']);
        }
        return null;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getIsCart() {
        return $this->isCart;
    }

    public function getPaymentType() {
        return $this->paymentType;
    }
    
    //   this function returns:
    //   null if user does not exist in database
    //   true if user exist in db
    public static function checkUserId($user_id){
        
        $result = User::GetUser($user_id);
        if (is_object($result)) {
            return TRUE;            
        }
        return null;
    }

    public function setUser_id($user_id) {
        
        if ($this->checkUserId($user_id)) {
            $this->user_id = $user_id; 
            return $this;
        }
        return NULL;
    }

    //   this function returns:
    //   null if status is different than paid or not paid
    //   true if status is paid or not paid
    public static function checkStatus($status){        
        if ($status == 'paid' || $status == 'not paid') {
            return TRUE;
        }
        return null;
    }
    
    public function setStatus($status) {
        if ($this->checkStatus($status)) {
            $this->status = $status;
            return $this;
        }
        return NULL;
    }
    
    //   this function returns:
    //   null if isCart is different than null or true
    //   true if status is null or true
    public static function checkIsCart($isCart){        
        if ($isCart == 0 || $isCart == 1) {
            return TRUE;
        }
        return null;
    }

    public function setIsCart($isCart) {
        if ($this->checkIsCart($isCart)) {
            $this->isCart = $isCart;
            return $this;
        }
        return NULL;        
    }
    
    //   this function returns:
    //   null if paymentType is different than cash or transfer
    //   true if paymentType is cash or transfer
    public static function checkPaymentType($paymentType){        
        if ($paymentType == 'cash' || $paymentType == 'transfer') {
            return TRUE;
        }
        return null;
    }

    public function setPaymentType($paymentType) {
        if ($this->checkPaymentType($paymentType)) {
            $this->paymentType = $paymentType;
            return $this;
        }
        return NULL;        
    }

    //this function is responsible for saving any changes done to Order to database
    public function saveToDB(){
        $sql = "UPDATE Orders SET id={$this->id}, user_id={$this->user_id},"
        . "status='{$this->status}', isCart={$this->isCart},"
        . "paymentType='{$this->paymentType}' WHERE id={$this->id}";
        return Order::$conn->query($sql);
    }
}
