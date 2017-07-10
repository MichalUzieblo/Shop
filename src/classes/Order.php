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
        //there is error with sql
        return null;
    }
    
    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getStatus() {
        return $this->status;
    }

    function getIsCart() {
        return $this->isCart;
    }

    function getPaymentType() {
        return $this->paymentType;
    }

    function setUser_id($user_id) {
        //before set user_id check id in User table
        $sqlStatement = "Select * from Users where id = '$user_id'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            // user exist so we can join this user with order
            $this->user_id = $user_id;            
        }
        return NULL;
    }

    function setStatus($status) {
        //status can take only two values
        if ($status == 'paid' || $status == 'not paid') {
            $this->status = $status;
            return $this;
        }
        return NULL;
    }

    function setIsCart($isCart) {
        //isCart can take only two values
        if ($isCart == NULL || $isCart == TRUE) {
            $this->isCart = $isCart;
            return $this;
        }
        return NULL;        
    }

    function setPaymentType($paymentType) {
        //paymentType can take only two values
        if ($paymentType == 'cash' || $paymentType == 'transfer') {
            $this->paymentType = $paymentType;
            return $this;
        }
        return NULL;        
    }


}
