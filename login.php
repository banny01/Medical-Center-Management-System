<?php
    // Start the session
    session_start();
    include_once('inc/connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>Medical Center Management System - Login</title>
    <link rel="icon"  href="inc/img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
    
</head>

<body class="container">

 <?php
    if(isset($_SESSION['UserID'])){
        header("Location: index.php");
    }
    if (isset($_POST['submit'])){
        $errors = 0;

        if (!isset($_POST['UserName'])||!isset($_POST['UserPassword'])) {
            $errors = 1;
        }
        if ($errors == 0) {
            $UserName = $_POST['UserName'];
            $Password = $_POST['UserPassword'];

            $query = "SELECT * FROM user WHERE userName = '{$UserName}' AND password = '{$Password}'";

            $result_set = mysqli_query($con, $query);

            if ($result_set) {
                
                if (mysqli_num_rows($result_set)==1) {
                    $loggedDet = mysqli_fetch_assoc($result_set);
                    $_SESSION['UserID'] = $loggedDet['userName'];
                    
                    header("Location: index.php");
                }
                else{
                    $errors = 1;
                }
            }
        }
    }
    else{
        $errors=0;
    }
 ?>
	
    <div class="row text-center " style="margin-top: 7%">
        <div class="col-md-4 offset-md-4 col-xs-8 offset-xs-2"> 		
            <form class="form-signin" action='login.php' method="post"> 
                <img class="mb-4" src="inc/img/Logo.png" alt="" width="128" height="128">
                <fieldset class="form-control"> 
                    <legend><h1 class="h1 mb-3 font-weight-normal">Log In</h1></legend>
                    <?php if ($errors==1) {
                        echo ('<p class="alert alert-danger">Invalid User Name or Password.!</p>');
                        
                    } ?>
                    
                    <input class="form-control" type="text" name="UserName" placeholder="User Name">
                    <input class="form-control" type="Password" name="UserPassword" placeholder="Password"><br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Log In</button>
                    
                    
                </fieldset>
            </form>
                    
        </div>
        <div class="col-md-12 text-center">
            <br>
            <p class="col-md-12 col-xs-12 text-muted">© <a href="http://www.bannysware.com">BANNY'sware Company Ltd.</a> All rights reserved.</p>
        </div> 
    </div>
        
</body>

</html>