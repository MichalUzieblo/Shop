<?php

class Admin {

    static private $conn;
    private $id;
    private $name;
    private $email;
    private $password;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection) {
        Admin::$conn = $newConnection;
    }

    private function __construct($newId, $newName, $newMail, $newPassword) {
        $this->id = $newId;
        $this->name = $newName;
        $this->email = $newMail;
        $this->password = $newPassword;
    }

    //his function returns:
    //null if admin does not exist in database or password does not match
    //new Admin object if Admin was authenticated
    public static function AuthenticateAdmin($adminMail, $password) {
        $sqlStatement = "Select * from Admins where email = '$adminMail'";
        $result = Admin::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $adminData = $result->fetch_assoc();
            $admin = new Admin($adminData['id'], $adminData['name'], $adminData['email'], $adminData['password']);

            if ($admin->authenticate($password)) {
                //Admin is authenticated - we can return him
                return $admin;
            }
        }
        //there is no admin with this email in db or Admin was not authenticated
        return null;
    }
    
    //function to authenticate admin data
    public function authenticate($password) {
        $hashed_pass = $this->password;
        if (password_verify($password, $hashed_pass)) {
            //Admin is verified
            return true;
        }
        return false;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }
}
