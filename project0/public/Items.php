<?php require('../data/header.php'); 
      require('../data/functions.php'); 
      
      //if post is not empty, redirect to the item page with no post
      if(!empty($_POST)) {
        header('Location: http://project0/Items.php?item='.$_GET['item']);
      } ?>
     
    <!--Print the item name -->
    <h2 style="text-align: center"><u><?php echo $_GET['item'] ?></u></h2>
    <!--Load the xml file -->
    <?php $xml = simplexml_load_file('../data/menu.xml'); ?>
    
    <h2>
    <?php 
            //searches for the correct category
            $index = getCategoryIndex($xml,$_GET['item']); ?>
            
       <table class="tableCenter itemTable">     
       <!--Creates a list of menu items with buttons to add to cart -->
       <form method="post" action= <?php echo "Items.php?item=".$_GET['item']; ?> >
       <?php foreach($xml->category[$index] as $item){
                //remove whitespace from name
                $name = $item->name;                                ?>
           <tr>
            <td>
          <?php $name = preg_replace('/\s+/','',$name); echo $name; ?>
            </td>
                <!--&nbsp &nbsp-->
            <td>
                small
                <input type="submit" <?php echo "name=".$name ?> value=<?php echo $item->price->small ?> >
            </td>
                <!--&nbsp &nbsp -->
            <td>
                 large 
                <input type="submit" <?php echo "name=".$name ?> value=<?php echo $item->price->large ?> >
            </td>    
                <br>
            </tr>
      <?php } ?>
            <!--<input type="submit" name="submit" value="Add to cart"> -->
          </form>
          </table>
    </h2>
    
    <?php //checks if the item was the one to be added to the cart
        foreach($xml->category[$index] as $item){
            //strip out the whitespace in the name
            $name = $item->name;
            $name = preg_replace('/\s+/','',$name);
            //if the item button was pressed
            if(isset($_POST[$name])){
                //echo $_POST[$name]." is set, ";
                if(isset($_SESSION['cart'])){
                    //create the item and add to the cart
                    $itemToCart = new MenuItem();
                    $itemToCart->name = $name;
                    $itemToCart->price = $_POST[$name];
                    array_push($_SESSION['cart'],$itemToCart);
                }else echo "cart not set";
            } 
            //else echo $item->name." not set, "; 
        }
        ?>
        <br>
<?php require('../data/footer.php'); ?>
