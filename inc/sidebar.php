<!--menu side bar-->
    <link rel='stylesheet' href='./css/animate.min.css'>
    <link rel='stylesheet' href='./css/tether.min.css'>
	<!-- Demo CSS -->
	<link rel="stylesheet" href="./css/demo.css">

<div class="sidebar-container">
    <a href="index.php">
        <img class="mb-2 mt-2 offset-3" src="img/Logo.png" alt="" width="72" height="72"> 
    </a>
  <div class="sidebar-logo">
    Main Menu
  </div>
  <ul class="sidebar-navigation">
    <li>
      <a href="index.php">
        <i class="fa fa-home" aria-hidden="true"></i> Dashboard
      </a>
    </li>
    <?php if($level == 0 || $level == 1 || $level == 2){ ?>
    <li>
    <a href="searchPatient.php">
        <i class="fa fa-search" aria-hidden="true"></i> Search Patients
    </a>
    </li>
    <?php } 
    if($level == 0 || $level == 2){ ?>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-users" aria-hidden="true"></i> Patient
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Patient</div>
            <li><a href="addPatient.php">Add Patient</a></li>
            <li><a href="managePatient.php">Manage Patient</a></li>
        </ul>
    </li>
    <?php } 
    if($level == 0 || $level == 1 || $level == 2){ ?>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-calendar" aria-hidden="true"></i> Appointment
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Appointment</div>
            <?php if($level == 0 || $level == 2){ ?>
            <li><a href="addAppointment.php">Add Appointment</a></li>
            <li><a href="manageAppointment.php">Manage Appointments</a></li>
            <?php } 
            if($level == 0 || $level == 1){ ?>
            <li><a href="myAppointment.php">My Appointments</a></li>
            <?php } ?>
        </ul>     
    </li>
    <?php } ?>

    <li class="header">Software Settings</li>
    <?php if($level == 0){ ?>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-user-circle" aria-hidden="true"></i> Users
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Users</div>
            <li><a href="addUser.php">Add User</a></li>
            <li><a href="manageUser.php">Manage Users</a></li>
        </ul>
    </li>
    <?php } ?>
    <li>
      <a href="info.php">
        <i class="fa fa-info-circle" aria-hidden="true"></i> Information
      </a>
    </li>
  </ul>
</div>

<script src='./js/jquery-3.3.1.slim.min.js'></script>
    <script src='./js/bootstrap.min.js'></script>
    <script src='./js/tether.min.js'></script>
    <script  src="./js/script.js"></script>