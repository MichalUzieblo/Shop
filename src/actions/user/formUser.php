<?php
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

