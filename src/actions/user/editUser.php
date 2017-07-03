<?php
session_start();

require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

$switch = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])
        && isset($_POST['surname'])&& isset($_POST['email']) 
        && isset($_POST['address']) && isset($_POST['password']) 
        && isset($_POST['repeatPassword']) && is_numeric($_SESSION['id']) && !empty($_SESSION['id'])) {
    
    if (!empty($_POST['name']) && !empty($_POST['surname']) 
            && !empty($_POST['email']) && !empty($_POST['address']) 
            && !empty($_POST['password']) && !empty($_POST['repeatPassword'])) {
        
        $newName = trim($_POST['name']);
        $newSurname = trim($_POST['surname']);
        $newEmail = trim($_POST['email']);
        $newAddress = trim($_POST['address']);
        
        $newPassword = trim($_POST['password']);
        $newRepeatPassword = trim($_POST['repeatPassword']);
        
        
        if ($newPassword == $newRepeatPassword ) {

            $editUser = User::GetUser($id);
            $editUser ->setName($newName);
            $editUser ->setSurname($newSurname);
            $editUser ->setEmail($newEmail);
            $editUser ->setPassword($newPassword);
            $editUser ->setAddress($newAddress);
            $isExist = $editUser ->saveToDB();            var_dump($editUser);
            if ($isExist == null) {
                $switch = 1;
            } else {
                $_SESSION['id'] = $editUser ->getId();
//                header("Location: pageUser.php");
            }
        } else {
            $switch = 2;           
        }
        
    } else {
        $switch = 3;        
    } 
} 

$title = 'Shop - Edit Profile';
require_once dirname(__FILE__) . "/../../html/htmlHeader.php";

?>

<?php
switch ($switch) {
    case 1:
        echo 'Email się powtarza';
        break;
    case 2:
        echo 'Podane hasła nie zgadzają się';
        break;
    case 3:
        echo 'Wypełnij wszystkie pola lub zaloguj się ponownie';
        break;                    
}
?>
<div class="container">
    <div class="row">
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
            <center>
                </form><br>
                <form action="../log/logOut.php" method="post" role="form">
                    <button type="submit" value="logOut" name="logOut" class="btn btn-success">Log Out</button>
                </form><br>
                <form action="pageUser.php" method="post" role="form">
                    <button type="submit" value="userBoard" class="btn btn-success">User Page</button>
                </form><br>
                <form action="../../../index.php" method="post" role="form">
                    <button type="submit" value="mainPage" class="btn btn-success">Main Page</button>
                </form><br>
                <form action="deleteUser.php" method="post" role="form">
                    <button type="submit" value="deleteUser" class="btn btn-success">Delete User</button>
                </form>
            </center>
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            
            <form action="" method="post" role="form">
                <legend>Hello <?php echo $user->getName(); ?></legend>
                <div class="form-group">
                    <label for="">New Name</label>
                    <input type="text" class="form-control" name="name" id="name"
                           value='<?php echo $user->getName(); ?>'>
                </div>
                <div class="form-group">
                    <label for="">New Surname</label>
                    <input type="text" class="form-control" name="surname" id="username"
                           value='<?php echo $user->getSurname(); ?>'>
                </div>
                <div class="form-group">
                    <label for="">New E-mail</label>
                    <input type="email" class="form-control" name="email" id="email"
                           value='<?php echo $user->getEmail(); ?>'>
                </div>
                <div class="form-group">
                    <label for="">New Address</label>
                    <input type="text" class="form-control" name="address" id="address"
                           value='<?php echo $user->getAddress(); ?>'>
                </div>
                <div class="form-group">
                    <label for="">New password</label>
                    <input type="password" class="form-control" name="password" id="email"
                           placeholder="New password">
                    <input type="password" class="form-control" name="repeatPassword" id="email"
                           placeholder="Repeat new password">
                </div>
                <center><button type="submit" value="editProfile" class="btn btn-success">Save</button></center>              
            <center>
            
            </center>
                
        </div>
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">            
        </div>
        
    </div>
</div>
                
<?php
require_once dirname(__FILE__) . "/../../html/htmlFooter.php";