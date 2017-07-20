<?php
session_start();
require_once dirname(__FILE__) . "/../src/actions/connection/connect.php";
require_once dirname(__FILE__) . "/../src/actions/log/isLogged.php";
//require_once dirname(__FILE__) . "/../src/actions/log/isLogout.php";

//place for logic part






$title = 'Shop - admin panel';
require_once dirname(__FILE__) . "/../src/html/htmlHeader.php";
?>

<div class="row">
    
    <center>
        <form action="../src/actions/log/logIn.php" method="post" role="form" id="center">
            <button type="submit" value="logInAdmin" name="logInAdmin" class="btn btn-success">Log in</button>
        </form>
              
    </center> 
    
</div>


<!--Structure-->
<div class="row">
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>

    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    </div>
 
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    </div>    
     
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    </div>
    
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    
</div>

    <div>
    <hr>
    </div>
 
<!--Place to show all "items"-->
<div class="row">
    <?php
//        require_once dirname(__FILE__) . "/src/html/htmlProducts.php";
    ?>  
</div> 

<?php
require_once dirname(__FILE__) . "/../src/html/htmlFooter.php";