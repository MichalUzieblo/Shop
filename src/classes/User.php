<?php

class User {

    static private $conn;
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $address;

    //This function sets connection for this class to use
    //This function needs to be run on startup
    public static function SetConnection($newConnection) {
        User::$conn = $newConnection;
    }

    private function __construct($newId, $newName, $newSurname, $newMail, $newPassword, $newAddress) {
        $this->id = $newId;
        $this->name = $newName;
        $this->surname = $newSurname;
        $this->email = $newMail;
        $this->password = $newPassword;
        $this->address = $newAddress;
    }

    //this function returns:
    //null if user exist in database
    //new User object if new entry was added to table
    public static function CreateUser($userMail, $password) {
        $sqlStatement = "Select * from Users where email = '$userMail'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting user to db
            $options = [
                'cost' => 11,
//                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
            $sqlStatement = "INSERT INTO Users(name, surname, email, password, address) values ('jakies', 'jakies', '$userMail', '$hashed_password', 'jakis')";
            if (User::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new User(User::$conn->insert_id, 'jakies', 'jakies', $userMail, $hashed_password, 'jakis');
            }
        }
        //there is user with this name in db
        return null;
    }

    //this function returns:
    //null if user with given id is not in db
    //User loaded from db if id is ok
    public static function GetUser($id) {
        $sqlStatement = "Select * from Users where id = '$id'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $userData = $result->fetch_assoc();
            return new User($userData['id'], $userData['name'], $userData['surname'], $userData['email'], $userData['password'], $userData['address']);
        }
        //there is user with this name in db
        return -1;
    }

    //this function returns:
    //null if user does not exist in database or password does not match
    //new User object if User was authenticated
    public static function AuthenticateUser($userMail, $password) {
        $sqlStatement = "Select * from Users where email = '$userMail'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $userData = $result->fetch_assoc();
            $user = new User($userData['id'], $userData['name'], $userData['surname'], $userData['email'], $userData['password'], $userData['address']);

            if ($user->authenticate($password)) {
                //User is authenticated - we can return him
                return $user;
            }
        }
        //there is no user with this name in db or User was not authenticated
        return null;
    }
    
    //function to check log in data from user
    public function authenticate($password) {
        $hashed_pass = $this->password;
        if (password_verify($password, $hashed_pass)) {
            //User is verified
            return true;
        }
        return false;
    }

    //this function return:
    //true if user was deleted
    //false if not
    public static function DeleteUser(User $toDelete, $password) {
        if ($toDelete->authenticate($password)) {
            $sql = "DELETE FROM Users WHERE id=" . $toDelete->getId();
            if (User::$conn->query($sql) === TRUE) {
                return true;
            }
        }
        return false;
    }

    //this function return:
    //true if user was deleted
    //false if wrong query
    public static function DeleteUserByAdmin($toDelete) {

        $sql = "DELETE FROM Users WHERE id=$toDelete";
        if (User::$conn->query($sql) === TRUE) {
            return true;
        }

        return false;
    }

    //this function returns:
    //empty array if table Users is empty or
    //table with all users
    public static function GetAllUsers() {
        $ret = array();
        $sqlStatement = "Select * from Users";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new User($row['id'], $row['name'], $row['surname'], $row['email'], $row['password'], $row['address']);
            }
        }
        return $ret;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPassword($newPassword) {
        $options = [
            'cost' => 11,
//            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT, $options);
    }

    //this function is responsible for saving any changes done to User to database
    public function saveToDB() {
        $sql = "UPDATE Users SET name='{$this->name}', surname='{$this->surname}', "
        . "email='{$this->email}', password='{$this->password}', "
        . "address='{$this->address}' WHERE id={$this->id}";
        return User::$conn->query($sql);
    }

}
