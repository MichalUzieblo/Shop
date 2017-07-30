<?php 
require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class MessageTest extends PHPUnit_Extensions_Database_TestCase {    

    private $message;
    
    protected function setUp() {
        parent::setUp();
        $this->message = Message::CreateMessage(3, 'test');
    }
    
    public function getConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        
        $conn = new PDO(
            'mysql:host=' . $DB_HOST . ';dbname=' . $DB_DBNAME,
            $DB_USER, $DB_PASSWORD );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $DB_DBNAME);
    }
    
    public function getDataSet() {
        $csv_data_set = new PHPUnit_Extensions_Database_DataSet_CsvDataSet();
        $csv_data_set->addTable('Messages', 'tests/classes/csv/messages.csv');
        
        return $csv_data_set;
    }
    
    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(Message::SetConnection($conn));
    }
    
    public function testCreateMessage() {                
        $this->assertEquals(7, $this->message->getId());
    }
    
    public function testCreateMessageNull() { 
        $message = Message::CreateMessage('ten','message');
        $this->assertNull($message);
    }
    
    public function testGetAllRecievedMessages() {
        $ret = Message::GetAllRecievedMessages(1);
        $this->assertCount(5, $ret);
    }
    
    public function testGetAllRecievedMessagesLimit() {
        $ret = Message::GetAllRecievedMessages(1, 2);
        $this->assertCount(2, $ret);
    }
    
    public function testDeleteMessage() {                
        $this->assertTrue(Message::DeleteMessage($this->message->getId()));
    }
    
    public function testDeleteProductGroupFalse() {                
        $this->assertFalse(Message::DeleteMessage('asd'));
    }
    
    public function testGetAllSendMessages() {
        $ret = Message::GetAllSendMessages();
        $this->assertCount(7, $ret);
    }
    
    public function testGetAllSendMessagesLimit() {
        $ret = Message::GetAllSendMessages(2);
        $this->assertCount(2, $ret);
    }
   
    public function testGetterAndSetters() {        

        $this->message->setMessageText('new message');
        $this->message->setOrder_id(1);         
        $this->message->saveToDB();
        
        $this->assertEquals('new message', $this->message->getMessage());
        $this->assertEquals(1, $this->message->getOrderId());  
        
    }
    
}

