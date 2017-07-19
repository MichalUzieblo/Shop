<center>
    <legend>Menu</legend>
    <form action="" method="post" role="form" id="center">                                       
        <button type="submit" name="productGroup" value="offices" class="btn btn-success">Offices</button>
    </form>
    <!--<br>-->
    <form action="" method="post" role="form">
        <button type="submit" name="productGroup" value="residential" class="btn btn-success">Residential</button>
    </form> 
    <!--<br>-->
    <form action="" method="post" role="form">
        <button type="submit" name="productGroup" value="hotels" class="btn btn-success">Hotels</button>
    </form>
    <!--<br>-->
    <form action="" method="post" role="form">
        <button type="submit" name="productGroup" value="mixed" class="btn btn-success">Mixed</button>
    </form>
    <!--<br>-->
    <form action="" method="post" role="form">
        <button type="submit" name="productGroup" value="all" class="btn btn-success">All</button>
    </form>
    
    <?php if ($isLogged) { ?>
    <legend>Profile</legend>
    <center>
        <form action="src/actions/user/editUser.php" method="post" role="form">
            <button type="submit" value="editUser" name="editUser" class="btn btn-success">Edit User</button>
        </form>
        <form action="src/actions/user/pageUser.php" method="post" role="form">
            <button type="submit" value="pageUser" name="pageUser" class="btn btn-success">User Page</button>
        </form>
    </center>
    <?php } ?>
</center> 