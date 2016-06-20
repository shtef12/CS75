<?php //require("../data/functions.php");
    if(isset($_GET['symbol']) and !empty($_GET['symbol'])){
        //retrieve the stock information
        $symbol = $_GET['symbol'];
        $fileToOpen = "http://download.finance.yahoo.com/d/quotes.csv?s={$symbol}&f=sl1d1t1c1ohgv&e=.csv";
        $csv = getCsvInfo($fileToOpen);
        //print_r($csv);  
        
        //checks if the stock exists if it does not exist
        //redirect to the same page with no GET   
        foreach($csv as $item){
            if($item == "N/A" || empty($item)){   ?>
                <script> alert("Please enter a stock symbol"); </script>
      <?php     header("Location:http://{$_SERVER['HTTP_HOST']}/");
            } 
        } ?>
        
        <h3><?php echo strtoupper($csv[0]); ?></h3>
        <h4>Price: $<?php echo $csv[1]; ?></h4>
        <h4>Change: <?php echo $csv[4]; ?></h4>
        <h4>Volume: <?php echo $csv[8]; ?></h4>
        
        <form method="post">
            Amount: <input type="text" name="amount">
            <input type="submit" name="Buy" value="Buy">
        </form>
        
<?php   if(isset($_POST['Buy'])){
            $amount = htmlspecialchars($_POST['amount']);
            if(!empty($amount) || $amount != ""){
                $num = intval($amount);
                if(is_int($num)){
                    //echo "is int";
                    $info = getFromDatabase("users","username",$_SESSION['currentUser']);
                    $userRow = $info[0];
                    $money = $userRow['money'];
                    $userId = $userRow['id'];
                    $cost = $amount * floatval($csv[1]); //calculate cost
                    
                    if($cost > $money){
                        echo "Not enough money";
                    }else{
                        //calculate the total money after transaction
                        $money = $money - $cost;
                        //update the user's money in the data
                        $conn = new PDO('mysql:host=localhost;dbname=project1','jharvard','crimson');
                        
                        $conn->beginTransaction();
                        try{
                            $query = sprintf("UPDATE `project1`.`%s` 
                                              SET %s = %s
                                              WHERE id = %s","users","money",$money,$userId);
                            $statement = $conn->prepare($query);
                            $statement->execute();
                            $conn->commit();
                            
                        }catch(Exception $e){
                            echo $e->getMessage();
                            $conn->rollBack();
                        }
                        
                        $stockInfo = getFromDatabase("stocks","symbol",$_GET['symbol']);
                        
                        if(!empty($stockInfo)){
                            //update stock info in database
                            //adds the amount bought to the table
                            $query = sprintf("UPDATE `project1`.`stocks`
                                              SET amount = amount + %s
                                              WHERE userid = %s AND symbol = '%s'",$amount,$userId,$_GET['symbol']);
                            $statement = $conn->query($query);
                            
                            //redirect the page to prevent buying more if user reloads
                            header("Location: http://{$_SERVER['HTTP_HOST']}/?symbol={$_GET['symbol']}");
                            
                        }else{
                            //add new entry to stocks table
                            $values = "'".$userId."','".$_GET['symbol']."',".$amount.",".$csv[1];
                            insertIntoDatabase("stocks","userid,symbol,amount,price",$values);
                            echo "Successfully bought stocks";
                        }
                    }
                    //update the amount of money the user has
                    //updtae the amount of stocks the user has
                    //check if user already has stocks form this symbol
                    //if so, update amount else, add to database
                }else{
                    echo "Please enter a number";
                }
            }
        } ?>
<?php }
?>


<div>
    <form method="get">
        Enter stock symbol:<input type="text" name="symbol" id="stockInput">
        <input type="submit" value="Search">
    </form>
</div>
<script> document.getElementById("stockInput").focus(); </script>


<!--http://download.finance.yahoo.com/d/quotes.csv?s=ROSV&f=sl1d1t1c1ohgv&e=.csv
-->
