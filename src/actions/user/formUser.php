<?php

session_start();
require_once dirname(__FILE__) . "/../connection/connect.php";
require_once dirname(__FILE__) . "/../log/isLogged.php";

if ($isLogged) {
    
?>

<div class="form-group">
    <label for="">Name</label>
    <input type="text" class="form-control" name="name" id="name"
           value='<?php echo $user->getName(); ?>'>
</div>
<div class="form-group">
    <label for="">Surname</label>
    <input type="text" class="form-control" name="surname" id="username"
           value='<?php echo $user->getSurname(); ?>'>
</div>
<div class="form-group">
    <label for="">Address</label>
    <input type="text" class="form-control" name="address" id="address"
           value='<?php echo $user->getAddress(); ?>'>
</div>

<?php
} else {
    header("Location: ../../../index.php");
}
?>
