<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author michal
 */
class Admin {
    static private $conn;

    private $id;
    private $name;
    private $email;
    private $password;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        User::$conn = $newConnection;
    }

    private function __construct($newId, $newName, $newMail, $newPassword){
        $this->id = $newId;
        $this->name = $newName;
        $this->email = $newMail;        
        $this->password = $newPassword;
    }
    
    //this function returns:
    //   null if user does not exist in database or password does not match
    //   new Admin object if Admin was authenticated
    public static function AuthenticateAdmin($userMail, $password){
        $sqlStatement = "Select * from Admins where email = '$userMail'";
        $result = Admin::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $adminData = $result->fetch_assoc();
            $admin = new Admin($adminData['id'], $adminData['name'], 
                    $adminData['surname'], $adminData['email'], 
                    $adminData['password'], $adminData['address']);
            
            if($admin->authenticate($password)){
                //Admin is authenticated - we can return him
                return $admin;
            }
        }
        //there is no admin with this email in db or Admin was not authenticated
        return null;
    }
    
    public function authenticate($password){
        $hashed_pass = $this->password;
        if(password_verify($password, $hashed_pass)){
            //Admin is verified
            return true;
        }
        return false;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setPassword($newPassword){
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT, $options);
    }

    //this function is responsible for saving any changes done to Admin to database
    public function saveToDB(){
        $sql = "UPDATE Admins SET name='{$this->name}', email='{$this->email}', password='{$this->password}' WHERE id={$this->id}";
        return Admin::$conn->query($sql);
    }

}
