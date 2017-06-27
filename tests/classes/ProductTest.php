<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class ProductTest extends PHPUnit_Extensions_Database_TestCase {
    
    private $product;
    
    protected function setUp() {
        parent::setUp();
        $this->product = Product::CreateProduct('milk', 1.99);
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
        $csv_data_set->addTable('Products', 'tests/classes/csv/products.csv');
        
        return $csv_data_set;
    }
    
    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(Product::SetConnection($conn));
    }
    
    public function testCreate() {                
        $this->assertEquals(3, $this->product->getId());
    }
    
    public function testCreateProductNull() { 
        $product = Product::CreateProduct('bread', 2.00);
        $this->assertNull($product);
    } 
    
    public function testDeleteProduct() {                
        $this->assertTrue(Product::DeleteProduct($this->product->getId()));
    }
    
    public function testDeleteProductFalse() {
        $this->assertFalse(Product::DeleteProduct('z'));
    }

    public function testGetAllProducts() {
        $ret = Product::GetAllProducts();
        $this->assertSame($this->product->getName(), $ret[2]->getName());
    }
    
    public function testGetAllProductsByGroup() {
        $ret = Product::GetAllProductsByGroup('cos');
        $this->assertSame($this->product->getName(), $ret[0]->getName());
    }
    
    public function testGetAllProductsLimit() {
        $ret = Product::GetAllProducts(2);
        $this->assertCount(2, $ret);
    }
    
    public function testGetProduct() {        
        $this->assertSame($this->product->getName(), Product::GetProduct(3)->getName());
    }
    
    public function testGetProductNull() {        
        $this->assertNull(Product::GetProduct(6));
    }
    
    public function testGetters() {        
        $this->assertEquals(3, $this->product->getId());
        $this->assertEquals('milk', $this->product->getName());
        $this->assertEquals(1.99, $this->product->getPrice());
        $this->assertEquals('cos', $this->product->getDescription());
        $this->assertEquals(0, $this->product->getInStock());     
        $this->assertEquals('cos', $this->product->getType());
    }
    
    public function testSetters() {        
        $this->product->setName('water');
        $this->product->setPrice(1.35);
        $this->product->setDescription('still');
        $this->product->setInStock(5);
        $this->product->setType('office');
        
        $this->product->saveToDB();

        $this->assertEquals('water', $this->product->getName());
        $this->assertEquals(1.35, $this->product->getPrice());
        $this->assertEquals('still', $this->product->getDescription());
        $this->assertEquals(5, $this->product->getInStock());  
        $this->assertEquals('office', $this->product->getType()); 
    } 
}
