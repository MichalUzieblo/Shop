<?php
$ret = ProductGroup::GetAllProductGroups();
?>

<center>
    <legend>Menu</legend>

    <?php
    foreach ($ret as $productGroup) {
        $id = $productGroup->getId();
        $name = $productGroup->getName();
        ?>
        <form action="" method="post" role="form" id="center">                                       
            <button type="submit" name="productGroupId" value="<?php echo $id ?>" class="btn btn-success"><?php echo $name ?></button>            
        </form>
    <br>
<?php } ?>
    <form action="" method="post" role="form">
        <button type="submit" name="productGroupId" value="all" class="btn btn-success">All</button>
    </form>

<?php if ($isLogged) { ?>
        <legend>Profile</legend>
        <center>
            <form action="src/actions/user/editUser.php" method="post" role="form">
                <button type="submit" value="editUser" name="editUser" class="btn btn-success">Edit User</button>
            </form>
            <br>
            <form action="src/actions/user/pageUser.php" method="post" role="form">
                <button type="submit" value="pageUser" name="pageUser" class="btn btn-success">User Page</button>
            </form>
        </center>
<?php } ?>
</center> 