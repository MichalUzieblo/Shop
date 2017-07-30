<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class OrderTest extends PHPUnit_Extensions_Database_TestCase {
    
    private $order;
    private $cart;
    
    protected function setUp() {
        parent::setUp();
        $this->order = Order::CreateOrder(1, 'paid', 'cash', 'Joe', 'Kowalsky', 'bukowa street');
        $this->cart = Order::CreateCart(2);
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
    
    public function testCreateOrder() {                
        $this->assertEquals(3, $this->order->getId());
    }
    
    public function testCreateOrderNull() { 
        $order = Order::CreateOrder('ala', 'paid', 'cash', 'cos', 'cos', 'cos');
        $this->assertNull($order);
    } 
    
    public function testCreateCart() {      
        $this->assertEquals(4, $this->cart->getId());
    }
    
    public function testCreateCartIfExist() { 
        $cart1 = Order::CreateCart(1);
        $cart2 = Order::CreateCart(1);
        $this->assertEquals(1, $cart2->getUser_id());
    }
    
    public function testCreateCartNull() {
        $cart2 = Order::CreateCart(30);
        $this->assertNull($cart2);
    }
    
    public function testDeleteOrder() {                
        $this->assertTrue(Order::DeleteOrder($this->order->getId()));
    }
    
    public function testDeleteOrderFalse() {
        $this->assertFalse(Order::DeleteOrder('z'));
    }

    public function testGetAllOrders() {
        $ret = Order::GetAllOrders();
        $this->assertSame($this->order->getStatus(), $ret[2]->getStatus());
    }
    
    public function testGetAllOrdersLimit() {
        $ret = Order::GetAllOrders(2);
        $this->assertCount(2, $ret);
    }
    
    public function testGetAllUserOrders() {
        $ret = Order::GetAllUserOrders(1);
        $this->assertEquals('paid', $ret[1]->getStatus());
    }
    
    public function testGetOrder() {        
        $this->assertSame($this->order->getStatus(), Order::GetOrder(3)->getStatus());
    }
    
    public function testGetOrderNull() {        
        $this->assertNull(Order::GetOrder(12));
    }
    
    public function testGetCart() {   
        $cart = Order::GetCart(2);        
        $this->assertEquals(4, $cart->getId());
    }
    
    public function testGetCartNull() { 
        $cart2 = Order::GetCart(30);
        $this->assertNull($cart2);
    }
    
    public function testDeleteCart() {                
        $this->assertTrue(Order::DeleteCart(2));
    }
    
    public function testDeleteCartFalse() {
        $this->assertFalse(Order::DeleteCart('z'));
    }
    
    public function testGetAllOrdersByStatus() {
        $ret = Order::GetAllOrdersByStatus('paid');
        $this->assertCount(2, $ret);
    }
    
    public function testGetAllCarts() {
        $ret = Order::GetAllCarts();
        $this->assertCount(1, $ret);
    }
    
    public function testGetters() {        
        $this->assertEquals(3, $this->order->getId());
        $this->assertEquals(1, $this->order->getUser_id());
        $this->assertEquals('paid', $this->order->getStatus());
        $this->assertEquals(0, $this->order->getIsCart());
        $this->assertEquals('cash', $this->order->getPaymentType()); 
        $this->assertEquals('Joe', $this->order->getName());
        $this->assertEquals('Kowalsky', $this->order->getSurname());
        $this->assertEquals('bukowa street', $this->order->getAddress());
    }
    
    public function testSetters() {        
        $this->order->setUser_id(2);
        $this->order->setStatus('not paid');
        $this->order->setIsCart(1);
        $this->order->setPaymentType('transfer');
        $this->order->setName('John');
        $this->order->setSurname('Rambo');
        $this->order->setAddress('lesna street');
        
        $this->order->saveToDB();
        
        $this->assertEquals(2, $this->order->getUser_id());
        $this->assertEquals('not paid', $this->order->getStatus());
        $this->assertEquals(1, $this->order->getIsCart());
        $this->assertEquals('transfer', $this->order->getPaymentType());
        $this->assertEquals('John', $this->order->getName());
        $this->assertEquals('Rambo', $this->order->getSurname());
        $this->assertEquals('lesna street', $this->order->getAddress());
    }
    
    public function testSettersNull() {        
        $this->order->setUser_id(50);
        $this->order->setStatus('ok');
        $this->order->setIsCart(3);
        $this->order->setPaymentType('money');
        
        $this->order->saveToDB();
        
        $this->assertEquals(1, $this->order->getUser_id());
        $this->assertEquals('paid', $this->order->getStatus());
        $this->assertEquals(0, $this->order->getIsCart());
        $this->assertEquals('cash', $this->order->getPaymentType());
    }

}
