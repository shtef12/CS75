<?php require('../data/header.php');
      require('../data/functions.php');
 
    //set the cart variable in session, if not already set
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    //load the menu xml file
    $xml = simplexml_load_file('../data/menu.xml');

    echo "<div>";
    addCategories($xml);
    echo "</div>";
 
    require('../data/footer.php'); 
 ?>
