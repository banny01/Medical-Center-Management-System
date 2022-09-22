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
    
    <title>Medical Center - Dashboard</title>
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
            <?php if($level == 0 || $level == 1 || $level == 2){ ?>
            <div class="offset-1 mt-2">
                <div class="clo h5 mt-4">Patient</div>
                <?php if($level == 0 || $level == 2){ ?>
                <a href="addPatient.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-user-plus" aria-hidden="true"></i><br>Add Patient
                    </button>
                </a>
                <a href="managePatient.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-address-card" aria-hidden="true"></i><br>Manage Patients
                    </button>
                </a>
                <?php } 
                if($level == 0 || $level == 1){ ?>
                <a href="searchPatient.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-search" aria-hidden="true"></i><br>Search Patients
                    </button>
                </a>
                <?php } ?>
            </div>
            <?php } 
            if($level == 0 || $level == 1 || $level == 2){ ?>
            <div class="offset-1 mt-2">
                <div class="clo h5 mt-4">Appointment</div>
                <?php if($level == 0 || $level == 2){ ?>
                <a href="addAppointment.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-calendar-check" aria-hidden="true"></i><br>Add Appointment
                    </button>
                </a>
                <a href="manageAppointment.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-share" aria-hidden="true"></i><br>Manage Appointments
                    </button>
                </a>
                <?php } 
                if($level == 0 || $level == 1){ ?>
                <a href="myAppointment.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-calendar" aria-hidden="true"></i><br>My Appointments
                    </button>
                </a>
                <?php } ?>
            </div>
            <?php } 
            if($level == 0){ ?>
            <div class="offset-1 mt-2">
                <div class="clo h5 mt-4">User</div>
                <a href="addUser.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-user-circle" aria-hidden="true"></i><br>Add User
                    </button>
                </a>
                <a href="manageUser.php">
                    <button type="button" class="btn btn-outline-dark mr-4 mt-2 hbtn">
                        <i class="fa fa-id-card" aria-hidden="true"></i><br>Manage User
                    </button>
                </a>
            </div>
            <?php } ?>
        </div>

    </div>

    <div class="row">
        <?php include_once('inc/footer.php'); ?>
    </div>
</body>
<script>
    
</script>

</html>