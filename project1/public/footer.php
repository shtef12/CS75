<?php //session_start();
    //if user is logged in, show the logout button
    if($_SESSION['authenticated'] == true){  ?>
        <br>
        <form method="post">
            <input type="submit" name="logout" value="logout">
        </form>
<?php }   
    
    //if the user pressed logout
    if(isset($_POST['logout'])){
        $_SESSION['authenticated'] = false;
        //unset($_SESSION['currentUser']);
        //unset($_POST['username']);
        $url = "http://".$_SERVER['HTTP_HOST'];
        header("Location:{$url}");
    } ?>
</html> 
