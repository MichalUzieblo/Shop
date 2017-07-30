<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class Product_OrderTest extends PHPUnit_Extensions_Database_TestCase {

    private $product_order;

    protected function setUp() {
        parent::setUp();
        $this->product_order = Product_Order::CreateProduct_Order(1, 1, 1, 1);
    }

    public function getConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;

        $conn = new PDO(
                'mysql:host=' . $DB_HOST . ';dbname=' . $DB_DBNAME, $DB_USER, $DB_PASSWORD);

        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $DB_DBNAME);
    }

    public function getDataSet() {
        $csv_data_set = new PHPUnit_Extensions_Database_DataSet_CsvDataSet();
        $csv_data_set->addTable('Products_Orders', 'tests/classes/csv/products_orders.csv');

        return $csv_data_set;
    }

    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(Product_Order::SetConnection($conn));
    }

    public function testCreateOrder() {
        $this->assertEquals(3, $this->product_order->getId());
    }

    public function testCreateOrderNull() {
        $product_order = Product_Order::CreateProduct_Order('ala', 1, 1, 1);
        $this->assertNull($product_order);
    }

    public function testDeleteProduct_Order() {
        $this->assertTrue(Product_Order::DeleteProduct_Order($this->product_order->getId()));
    }

    public function testDeleteProduct_OrderFalse() {
        $this->assertFalse(Product_Order::DeleteProduct_Order('z'));
    }

    public function testGetAllByOrderId() {
        $ret = Product_Order::GetAllByOrderId(1);
        $this->assertEquals($this->product_order->getProduct_id(), $ret[1]->getProduct_id());
    }

    public function testGetAllByProductId() {
        $ret = Product_Order::GetAllByProductId(1);
        $this->assertEquals($this->product_order->getOrder_id(), $ret[1]->getOrder_id());
    }

    public function testGetProduct_Order() {
        $this->assertEquals($this->product_order->getProduct_id(), Product_Order::GetProduct_Order(3)->getProduct_id());
    }

    public function testGetProduct_OrderNull() {
        $this->assertNull(Product_Order::GetProduct_Order(12));
    }

    public function testGetters() {
        $this->assertEquals(1, $this->product_order->getFixed_price());
        $this->assertEquals(1, $this->product_order->getQuantity());
    }

    public function testSetters() {
        $this->product_order->setProduct_id(2);
        $this->product_order->setOrder_id(3);
        $this->product_order->setFixed_price(2);
        $this->product_order->setQuantity(11);

        $this->product_order->saveToDB();

        $this->assertEquals(2, $this->product_order->getProduct_id());
        $this->assertEquals(3, $this->product_order->getOrder_id());
        $this->assertEquals(2, $this->product_order->getFixed_price());
        $this->assertEquals(11, $this->product_order->getQuantity());
    }
}
