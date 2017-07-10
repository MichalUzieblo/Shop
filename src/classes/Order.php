<?php

/**
 * Description of Order
 *
 * @author michal
 */
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
    public static function CreateOrder($user_id, $status, $isCart, $paymentType){
        
        $sqlStatement = "INSERT INTO Orders(user_id, status, isCart, paymentType) values ($user_id, '$status', '$isCart', '$paymentType')";
        if (Order::$conn->query($sqlStatement) === TRUE) {
            //entery was added to DB so we can return new object
            return new Order(Order::$conn->insert_id, $user_id, $status, $isCart, $paymentType);
        }
        //there is an error with sql
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
        
        $sqlStatement = "Select * from Users where id = '$user_id'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
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
        if ($isCart == NULL || $isCart == TRUE) {
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


}
