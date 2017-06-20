<?php


class User{
    static private $conn;

    private $id;
    private $name;
    private $surnaname;
    private $email;
    private $password;

    // This function sets connection for this class to use
    // This function needs to be run on startup
    public static function SetConnection($newConnection){
        User::$conn = $newConnection;
    }

    private function __construct($newId, $newName, $newSurname, $newMail, $password){
        $this->id = $newId;
        $this->name = $newName;
        $this->surnaname = $newSurname;
        $this->email = $newMail;        
        $this->password = $password;
    }
    
    //this function returns:
    //   null if user exist in database
    //   new User object if new entry was added to table
    public static function CreateUser($userMail, $password){
        $sqlStatement = "Select * from Users where email = '$userMail'";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 0) {
            //inserting user to db
            $options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
            $sqlStatement = "INSERT INTO Users(name, surname, email, password) values ('', '', '$userMail', '$hashed_password')";
            if (User::$conn->query($sqlStatement) === TRUE) {
                //entery was added to DB so we can return new object
                return new User(User::$conn->insert_id, 'jakies', 'jakies', $userMail, $hashed_password);
            }
        }
        //there is user with this name in db
        return null;
    }

    public function getId(){
        return $this->id;
    }

}