<?php
    // Start the session
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/clock.css">
    <link rel="stylesheet" type="text/css" href="css/sidebar.scss">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
    <script src="js/fontawesome.js"></script>
    <script src="js/solid.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>

    
    <title>About - Water Supply</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php include_once('inc/header.php'); ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2"> <!-- This div for the content -->

            <h5>About</h5>
            <div class="col-10 mt-4 font-weight-bold">
                <div class="col-6 offset-3">Name : Medical Center Management System</div>
                <div class="col-6 offset-3">App Version : 1.0.0</div>
            </div>
            <br>
            <div class="col-10 mt-4 font-weight-bold">
                Contact Us for more information.
                <div class="row mt-4">
                    <div class="col-2 offset-3">
                        Call us,
                    </div>
                    <div class="col-6">
                        Krishan : (+94)71 034 7725 / (+94)77 505 7725
                    </div>
                </div>
                <div class="col-10 offset-2">
                    <div class="row mt-2">
                        <div class="col-4">Web : <a href="http://www.bannysware.com" class="text-dark">www.bannysware.com</a></div>
                        <div class="col-4">Email : <a href="mailto: bannysware@gmail.com" class="text-dark">bannysware@gmail.com</a></div>
                        <div class="col-4">Facebook : <a href="http://www.facebook.com/BANNYsware" class="text-dark">BANNY'sware</a></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <?php include_once('inc/footer.php'); ?>
    </div>
</body>
<script>
    
</script>

</html>