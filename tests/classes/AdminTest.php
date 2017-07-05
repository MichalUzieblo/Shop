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
            'mysql:host=' . $DB_HOST . ';dbname=' . $DB_DBNAME,
            $DB_USER, $DB_PASSWORD );
        
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
    
//    public function testCreateUserNull() { 
//        $user = User::CreateUser('example@op.pl', 'haslo');
//        $this->assertNull($user);
//    } 
//    
//    public function testGetUser() {        
//        $this->assertSame($this->user->getName(), User::GetUser(3)->getName());
//    } 
//    
//    public function testGetUserNull() {        
//        $this->assertEquals(-1, User::GetUser(6));
//    }
//    
//    public function testAuthenticateUser() {
//        $authenticate = User::AuthenticateUser('example4@op.pl', 'haslo');
//        $this->assertEquals($authenticate->getId(), $this->user->getId());        
//    }
//    
//    public function testAuthenticateUserNull() {    
//        $this->assertNull(User::AuthenticateUser('example4@op.pl', 'haslo2'));
//    }
//    
//    public function testDeleteUser() {        
//        User::DeleteUser($this->user, 'haslo');
//        
//        $authenticate = User::AuthenticateUser('example4@op.pl', 'haslo');
//        $this->assertNull($authenticate);
//    }
//    
//    public function testDeleteUserFalse() {
//        $this->assertFalse(User::DeleteUser($this->user, 'haslo1'));
//    }
//    
//    public function testGetters() {        
//        $this->assertEquals(3, $this->user->getId());
//        $this->assertEquals('jakies', $this->user->getName());
//        $this->assertEquals('jakies', $this->user->getSurnaname());
//        $this->assertEquals('example4@op.pl', $this->user->getEmail());
//        $this->assertEquals('jakis', $this->user->getAddress());        
//    }
//    
//    public function testSetters() {        
//        $this->user->setName('Johny');
//        $this->user->setSurnaname('Bravo');
//        $this->user->setEmail('example5@op.pl');
//        $this->user->setPassword('haslo5');
//        $this->user->setAddress('Sosnowa');
//        
//        $this->user->saveToDB();
//
//        $this->assertEquals('Johny', $this->user->getName());
//        $this->assertEquals('Bravo', $this->user->getSurnaname());
//        $this->assertEquals('example5@op.pl', $this->user->getEmail());
//        $this->assertEquals('Sosnowa', $this->user->getAddress());        
//    }    
}
