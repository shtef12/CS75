<?php //require("../data/functions.php");
    //handles logging in
    if(isset($_POST['login'])){
        if(empty($_POST['username']) or empty($_POST['password'])){
            echo "Enter username or password";
        }else{
            $name = htmlspecialchars($_POST['username']);
            $pass = htmlspecialchars($_POST['password']);
            
            if(!isInDatabase("users","username",$name)) echo "Incorrect username or password";
            else{
                $result = getFromDatabase("users","username",$name);
                $userRow = $result[0];
            
                if($pass != $userRow['password']) echo "Incorrect username or password";
                else{
                        //echo $result['password'];
                        $_SESSION['authenticated'] = true;
                        $_SESSION['currentUser'] = $name;
                        
                        $url = "http://".$_SERVER['HTTP_HOST'];
                        header("Location:{$url}");
                }
            }
        }
    //handles registration
    }else if(isset($_POST['register'])){
        if(empty($_POST['username']) or empty($_POST['password'])){
            echo "Enter username or password";
        }else{
            $name = htmlspecialchars($_POST['username']);
            $pass = htmlspecialchars($_POST['password']);
            if(isInDatabase("users","username",$name)) echo $name." already registered";
            else{
                //add the user to the database and log them in
                $value = sprintf("'%s','%s'",$name,$pass);
                insertIntoDatabase("users","username,password",$value);
                
                //log the person in
                $_SESSION['authenticated'] = true;
                $_SESSION['currentUser'] = $name;
                
                $url = "http://".$_SERVER['HTTP_HOST'];
                header("Location:{$url}");
            }
        }
    }
        
    ?>
    
    <!--The login form-->
    <h2>Login</h2>
    <form  method="post">
        Username:<input type="input" name="username" id="userInput"><br>
        Password:<input type="input" name="password"><br>
        <input type="submit" name="login" value="login">
        <input type="submit" name="register" value="register">
    </form>  
    <script> document.getElementById("userInput").focus(); </script>
