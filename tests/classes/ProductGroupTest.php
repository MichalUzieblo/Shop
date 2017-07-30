<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class ProductGroupTest extends PHPUnit_Extensions_Database_TestCase {

    private $productGroup;

    protected function setUp() {
        parent::setUp();
        $this->productGroup = ProductGroup::CreateProductGroup('tower');
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
        $csv_data_set->addTable('ProductGroups', 'tests/classes/csv/productGroups.csv');

        return $csv_data_set;
    }

    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(ProductGroup::SetConnection($conn));
    }

    public function testCreateProductGroup() {
        $this->assertEquals(5, $this->productGroup->getId());
    }

    public function testCreateProductGroupNull() {
        $productGroup = ProductGroup::CreateProductGroup('offices');
        $this->assertNull($productGroup);
    }

    public function testGetAllProductGroups() {
        $ret = ProductGroup::GetAllProductGroups();
        $this->assertEquals(3, $ret[2]->getId());
    }

    public function testDeleteProductGroup() {
        $this->assertTrue(ProductGroup::DeleteProductGroup($this->productGroup->getId()));
    }

    public function testDeleteProductGroupFalse() {
        $this->assertFalse(ProductGroup::DeleteProductGroup('asd'));
    }

    public function testGetProductGroup() {
        $this->assertSame($this->productGroup->getName(), ProductGroup::GetProductGroup(5)->getName());
    }

    public function testGetProductGroupNull() {
        $this->assertNull(ProductGroup::GetProductGroup(12));
    }

    public function testGetterAndSetters() {

        $this->productGroup->setName('block');
        $this->productGroup->saveToDB();
        $this->assertEquals('block', $this->productGroup->getName());
    }
}
