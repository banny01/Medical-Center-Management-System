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
    
    <title>Dashboard - Water Supply</title>
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
            <h5>Dashboard</h5>
            <div class="offset-1 mt-2">
                <a href="cPay.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-credit-card" aria-hidden="true"></i><br>Customer Payments
                    </button>
                </a>
                <a href="oCost.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i><br>Other Costs
                    </button>
                </a>
                <a href="billing.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-file" aria-hidden="true"></i><br>Customer Billing
                    </button>
                </a>
                <a href="cBill.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-paperclip" aria-hidden="true"></i><br>Collect Bills
                    </button>
                </a>
            </div>
            <div class="offset-1 mt-2">
                <a href="addCustomer.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-user-plus" aria-hidden="true"></i><br>Add Customer
                    </button>
                </a>
                <a href="addEmployee.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-user-plus" aria-hidden="true"></i><br>Add Employee
                    </button>
                </a>
                <a href="addNoPay.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-share" aria-hidden="true"></i><br>Add No Pay Leaves
                    </button>
                </a>
                <a href="rates.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-list-ol" aria-hidden="true"></i><br>Rates
                    </button>
                </a>
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