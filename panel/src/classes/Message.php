<?php

class Message{
    static private $conn;

    private $id;
    private $orderId;
    private $message;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        Message::$conn = $newConnection;
    }
    
    private function __construct($newId, $orderId, $message){
        $this->id = $newId;        
        $this->orderId = $orderId;
        $this->message = $message;
    }

    //this function returns:
    //   new Message object if new entry was added to table
    //   null if there was some problem
    public static function CreateMessage($orderId, $message){
        $sqlStatement = "INSERT INTO Messages(order_id, message) values ($orderId, '$message')";
        if (Message::$conn->query($sqlStatement) === TRUE) {
            return new Message(Message::$conn->insert_id, $orderId, $message);
        }
        //error
        return null;
    }

    //this function return:
    //   true if tweet was deleted
    //   false if not
    public static function DeleteMessage($toDeleteId){
        $sql = "DELETE FROM Messages WHERE id = {$toDeleteId}";
        if (Message::$conn->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    public static function GetAllRecievedMessages($userId, $limit = 0){
        $ret = array();
//        $sqlStatement = "select * from Messages join where user_id = $userId";
        $sqlStatement = "select Messages.id, order_id, message from Messages join Orders on Messages.order_id = Orders.id where Orders.user_id = $userId";
        if($limit > 0){
            $sqlStatement .= " LIMIT $limit";
        }
        $result = Message::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Message($row['id'], $row['order_id'], $row['message']);
            }
        }
        return $ret;
    }

    public static function GetAllSendMessages($limit = 0){
        $ret = array();
        $sqlStatement = "select * from Messages";
        if($limit > 0){
            $sqlStatement .= " LIMIT $limit";
        }
        $result = Message::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Message($row['id'], $row['order_id'], $row['message']);
            }
        }
        return $ret;
    }    

    public function getId(){
        return $this->id;
    }

    public function getOrderId(){
        return $this->orderId;
    }

    public function getMessage(){
        return $this->message;
    }
    
    public function setOrder_id($newOrderId){
        $this->orderId = $newOrderId;
    }

    public function setMessageText($newMessage){
        $this->message = $newMessage;
    }

    //this function is responsible for saving any changes done to Message to database
    public function saveToDB(){
        $sql = "UPDATE Messages SET orderId='{$this->orderId}', message='{$this->message}' WHERE id={$this->id}";
        return Message::$conn->query($sql);
    }
    
}