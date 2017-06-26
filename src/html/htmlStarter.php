<center>
        <form action="src/actions/log/logIn.php" method="post" role="form" id="center">
        <?php
        if ($isLogOut) {
            echo 'Pomyslnie wylogowano<br>';
        }
        ?>
        <legend>Welcome in The Skyscraper's Shop</legend>                               
        <button type="submit" value="logInn" class="btn btn-success">Log in</button>
    </form>
    <br>
    <form action="src/actions/user/newUser.php" method="post" role="form">
        <button type="submit" value="newUser" class="btn btn-success">Register</button>
    </form>                
</center> 