<?php require("../data/header.php"); 

      if($_SESSION['authenticated'] == true){  ?>
        <h2>Logged In</h2> 
  <?php $url = "http://".$_SERVER["HTTP_HOST"]."/mystocks.php"; ?>
        <form action= <?php echo $url ?> >
            <input type="submit" value="My Stocks">
        </form>
      <?php require("../data/stocks.php"); ?>
<?php }else{
        require("../data/login.php");
      }
      
require("footer.php"); ?>
    

