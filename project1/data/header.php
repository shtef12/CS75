<?php session_start(); 
      require("functions.php");
      
      if(empty($_SESSION['authenticated'])){
        $_SESSION['authenticated'] = false; 
      } 
      
      //if the user is logged in, get the money the user has
      if($_SESSION['authenticated'] == true and isset($_SESSION['currentUser']) and !empty($_SESSION['currentUser'])){
        $info = getFromDatabase("users","username",$_SESSION['currentUser']);
        $row = $info[0];
        $money = $row['money'];
      } ?>

<html>
    <title>C$75</title>
    <a href="http://project1"><h1>C$75</h1></a>
    
    <!--Show the money the user has-->
<?php if(isset($money)){ ?>
        <h3>Your money: $<?php echo $money ?></h3>
<?php }   ?>
