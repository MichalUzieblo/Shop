<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";

class AdminTest extends PHPUnit_Extensions_Database_TestCase {

    private $admin;

    protected function setUp() {
        parent::setUp();
        $this->admin = Admin::AuthenticateAdmin('dfg@dfg.dfg', 'dfg');
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
        $csv_data_set->addTable('Admins', 'tests/classes/csv/admins.csv');

        return $csv_data_set;
    }

    public function testSetConnection() {
        global $DB_HOST;
        global $DB_DBNAME;
        global $DB_USER;
        global $DB_PASSWORD;
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DBNAME);
        $this->assertNull(Admin::SetConnection($conn));
    }

    public function testAuthenticateAdmin() {
        $this->assertEquals(1, $this->admin->getId());
    }

    public function testAuthenticateAdminNull() {
        $this->assertNull(Admin::AuthenticateAdmin('dfg@dfg.dfg', 'asd'));
    }

    public function testGetters() {
        $this->assertEquals(1, $this->admin->getId());
        $this->assertEquals('dfg', $this->admin->getName());
        $this->assertEquals('dfg@dfg.dfg', $this->admin->getEmail());
    }
}
