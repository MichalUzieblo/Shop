<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class ProductPhotoTest extends PHPUnit_Extensions_Database_TestCase {
    
    private $productPhoto;
    
    protected function setUp() {
        parent::setUp();
        $this->productPhoto = ProductPhoto::CreateProductPhoto(2, '/src/db/photos/2_WTT.php', 'j');
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
        $csv_data_set->addTable('ProductPhotos', 'tests/classes/csv/productPhotos.csv');
        
        return $csv_data_set;
    }
    
    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(ProductPhoto::SetConnection($conn));
    }
    
    public function testCreateProductPhoto() {                
        $this->assertEquals(10, $this->productPhoto->getId());
    }
    
    public function testCreateProductPhotoNull() { 
        $productPhoto = ProductPhoto::CreateProductPhoto(2, 'cos.php', 'a');
        $this->assertNull($productPhoto);
    } 
    
    public function testGetAllPhotosByProdcuctId() {
        $ret = ProductPhoto::GetAllPhotosByProdcuctId(1);
        $this->assertEquals(2, $ret[1]->getId());
    }
    
    public function testGetAllPhotosByProdcuctIdNull() {
        $ret = ProductPhoto::GetAllPhotosByProdcuctId(1);
        $this->assertEquals(2, $ret[1]->getId());
    }
    
     
    public function testGetterAndSetters() {        
        $this->productPhoto->setProduct_id(3);
        $this->productPhoto->setPath('path');
        $this->productPhoto->setName('k');
        
        $this->productPhoto->saveToDB();

        $this->assertEquals(3, $this->productPhoto->getProduct_id());
        $this->assertEquals('path', $this->productPhoto->getPath());
        $this->assertEquals('k', $this->productPhoto->getName());        
    }
    

}

