<?php require('../data/functions.php'); 
      require('../data/header.php');   ?>
<?php
      $pageURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                       ?>

<?php if(isset($_POST['clear'])){
        unset($_SESSION['cart']);
        header('Location: '.$pageURL);
        unset($_POST['clear']);
        echo "Thank you";
      }
?>

<!--Builds a table of all of the items in the cart 
    |Item name | Item price | Remove button |      -->
<table class="tableCenter">
<?php if(empty($_SESSION['cart'])) echo "Cart is empty"; 
      else {
        $cartList = $_SESSION['cart']; ?>

<?php   for($i = 0; $i < count($cartList); $i++){ 
          $itemName = $cartList[$i]->name; 
          $itemPrice = $cartList[$i]->price;          ?>
          <tr>
            <td> <?php echo $itemName; ?></td>
            <td> <?php echo $itemPrice ?></td>
            <td> <form action="Cart.php" method="post">
                    <input type="submit" name=<?php echo $itemName ?> value="Remove">
                 </form> </td>
         </tr>
<?php   } 
      }?>
</table>

<!--return to index button
<form action="index.php">
    <input type="submit" value="Return">
</form> -->

<!--checkout button -->
<form action=<?php echo $pageURL ?> method='post'>
    <input type="submit" name="clear" value="Checkout">
</from>

<!--Remove item from the cart -->
<?php foreach($_POST as $item){
        //remove the item from the cart and update the page
        for($j = 0; $j < count($_SESSION['cart']); $j++){
            if(key($_POST) == $_SESSION['cart'][$j]->name){
                print("its a match");
                array_splice($_SESSION['cart'],$j,1);
                header('Location: '.$pageURL);
            }
        }
      }                              ?>
<?php require('../data/footer.php'); ?>
