<?php

require_once dirname(__FILE__) . "/../../src/actions/connection/connect.php";
//require_once 'src/connection.php';

class UserTest extends PHPUnit_Extensions_Database_TestCase {
    
    private $user;
    
    protected function setUp() {
        parent::setUp();
        $this->user = User::CreateUser('example4@op.pl', 'haslo');
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
        $csv_data_set->addTable('Users', 'tests/classes/csv/users.csv');
        
        return $csv_data_set;
    }
    
    public function testCreate() {
        
        $this->assertEquals(3, $this->user->getId());
    }    
    
}
