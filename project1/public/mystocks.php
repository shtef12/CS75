<?php require("../data/header.php"); 
      //require("../data/functions.php"); ?>

<?php echo "This is user: ".$_SESSION['currentUser']; 
      //gets the current user and gets there stock info from the database
      $user = $_SESSION['currentUser'];
      $userInfo = getFromDatabase("users","username",$user); 
      //print_r($userInfo);
      $userRow = $userInfo[0];
      $userId = $userRow["id"]; 
      echo "<br>";
      
      //displays the stock information
      $stockInfo = getFromDatabase("stocks","userid",$userId);
      $symbols = array();
      for($i = 0; $i < count($stockInfo); $i++){
          $row = $stockInfo[$i];
          if($row['amount'] == 0)
            continue;
          array_push($symbols,$row["symbol"]);
          echo $row["symbol"]." "; echo "Price: ".$row["price"]." "; echo "Amount: ".$row["amount"]." ";
          echo "<br>"; 
      }
      ?>
      
      <!--Adds a select form and adds stock symbols as options-->
      <form method="post">
        <select name="toSell" >
<?php for($i = 0; $i < count($symbols); $i++){    ?>
          <option value="<?php echo $symbols[$i]; ?>"><?php echo $symbols[$i]; ?></option>
<?php }               ?>
        </select>
          <input type="text" name="amount">
          <input type="submit" name="submit" value="Sell">
      </form>
      
<?php echo "<br>";
      //if the user selects to sell a stock
      if(isset($_POST['toSell']) and isset($_POST['amount'])){
        $conn = new PDO('mysql:host=localhost;dbname=project1','jharvard','crimson'); 
        $query = sprintf("SELECT * FROM `project1`.`stocks`
                         WHERE userid = %s AND symbol = '%s'",$userId,$_POST['toSell']);
        $statement = $conn->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $rowInfo = $result[0];
        
        //make sure the num of stocks does not go negative
        if((intval($rowInfo['amount']) - intval($_POST['amount'])) > -1){
            $conn->beginTransaction();
            try{
                //updates the amount of stocks the user has
                $query = sprintf("UPDATE `project1`.`stocks`
                                  SET amount = amount - %s
                                  WHERE userid = %s AND symbol = '%s'",$_POST['amount'],$userId,$_POST['toSell']);
                $statement = $conn->prepare($query);
                $statement->execute();
                $conn->commit();
            
            }catch(Exception $e){
                $e->getMessage();
                $conn->rollBack();
            }
            
            updateMoney($conn,$userId,$_POST['amount']);
            
            header("Location: http://{$_SERVER['HTTP_HOST']}/mystocks.php");
        }
      }  
      
      //updates the amount of money the user has after a transaction
      function updateMoney($conn, $id, $amountSold){
        $fileToOpen = "http://download.finance.yahoo.com/d/quotes.csv?s={$_POST['toSell']}&f=sl1d1t1c1ohgv&e=.csv";
        $csv = getCsvInfo($fileToOpen);
        //print_r($csv);
        
        //calculate the amount of money gained
        $currentPrice = $csv[1];
        $moneyGained = floatval($currentPrice) * floatval($amountSold);
        
        $conn->beginTransaction();
        try{
            //updates the current price in the table for this stock
            $query = sprintf("UPDATE `project1`.`stocks`
                              SET price = %s
                              WHERE symbol = '%s'",$currentPrice,$csv[0]);
            $stmt = $conn->prepare($query);
            $stmt->execute();
        
            //updates the amount of money the user has after selling
            $q2 = sprintf("UPDATE `project1`.`users`
                           SET money = money + %s
                           WHERE id = %s", $moneyGained, $id);
            $stmt = $conn->prepare($q2); 
            $stmt->execute();
        
            $conn->commit();
            
        }catch(Exception $e){
            $e->getMessage();
            $conn->rollBack();
        }
      } ?>     

<?php require("footer.php"); ?>
