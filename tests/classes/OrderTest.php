<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class OrderTest extends PHPUnit_Extensions_Database_TestCase {
    
    private $order;
    
    protected function setUp() {
        parent::setUp();
        $this->order = Order::CreateOrder(1, 'paid', NULL, 'cash');
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
        $csv_data_set->addTable('Orders', 'tests/classes/csv/orders.csv');
        
        return $csv_data_set;
    }
    
    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(Order::SetConnection($conn));
    }
    
    public function testCreate() {                
        $this->assertEquals(3, $this->order->getId());
    }
    
    public function testCreateOrderNull() { 
        $order = Order::CreateOrder(1, 'paid', NULL, 'cash');
        $this->assertNull($order);
    } 
    
    public function testDeleteOrder() {                
        $this->assertTrue(Order::DeleteOrder($this->order->getId()));
    }
    
    public function testDeleteOrderFalse() {
        $this->assertFalse(Order::DeleteOrder('z'));
    }

    public function testGetAllOrders() {
        $ret = Order::GetAllOrders();
        $this->assertSame($this->order->getStatus(), $ret[3]->getStatus());
    }
    
    public function testGetAllOrdersLimit() {
        $ret = Order::GetAllOrders(2);
        $this->assertCount(2, $ret);
    }
    
    public function testGetOrder() {        
        $this->assertSame($this->order->getStatus(), Order::GetOrder(3)->getStatus());
    }
    
    public function testGetOrderNull() {        
        $this->assertNull(Order::GetOrder(12));
    }
    
    public function testGetCart() {   
        $order = Order::CreateOrder(1, null, TRUE, null);
        $this->assertSame($this->order->getIsCart(), Order::GetOrder(4)->getIsCart());
    }
    
    public function testGetCartNull() {        
        $this->assertNull(Order::GetOrder(3)->getIsCart());
    }
    
    public function testGetters() {        
        $this->assertEquals(3, $this->order->getId());
        $this->assertEquals(1, $this->order->getUserId());
        $this->assertEquals('paid', $this->order->getStatus());
        $this->assertEquals(null, $this->order->getIsCart());
        $this->assertEquals('cash', $this->order->getPaymentType());     
    }
    
    public function testSetters() {        
        $this->order->setUserId(2);
        $this->order->setStatus('not paid');
        $this->order->setIsCart(TRUE);
        $this->order->setPaymentType('transfer');
        
        $this->order->saveToDB();
        
        $this->assertEquals(2, $this->order->getUserId());
        $this->assertEquals('not paid', $this->order->getStatus());
        $this->assertEquals(TRUE, $this->order->getIsCart());
        $this->assertEquals('transfer', $this->order->getPaymentType());
    } 
}
