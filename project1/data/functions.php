<?php 
    function error_message($message){  ?>
        <script type="text/javascript">
        var message = <?php $message ?>;
        alert(message);
        </script>
<?php }

    //checks if the column where column equals value is in the table
    function isInDatabase($table, $column,$value){
        $conn = new PDO('mysql:host=localhost;dbname=project1','jharvard','crimson');
        $query = sprintf("SELECT * FROM `project1`.`%s` 
                          WHERE `%s` = '%s'",$table,$column,$value);
                              
        $statement = $conn->query($query);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) return false;
        else return true;
    }
    
    //gets a result from the table where the column equals value
    function getFromDatabase($table, $column, $value){
        $conn = new PDO('mysql:host=localhost;dbname=project1','jharvard','crimson');
        $query = sprintf("SELECT * FROM `project1`.`%s` 
                          WHERE `%s` = '%s'",$table,$column,$value);
                              
        $statement = $conn->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //print_r($result);
        return $result;
    }
    
    //inserts values into the database
    //$columns->a string of columns (ex: "name,addr,num")
    //$values->a string of values (ex: "'jon','wall',222-222")
    function insertIntoDatabase($table, $columns, $values){
        $conn = new PDO('mysql:host=localhost;dbname=project1','jharvard','crimson');
        $query = sprintf("INSERT INTO `project1`.`%s` (%s) 
                          VALUES (%s)",$table,$columns,$values);
        //echo $query;
        $statement = $conn->query($query);
    }
    
    function getCsvInfo($filename){
        if(!empty($filename)){
            $file = fopen($filename,"r");
            $csv = fgetcsv($file);
            return $csv;
        }
    }
?>
