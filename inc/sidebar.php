<!--menu side bar-->
    <link rel='stylesheet' href='./css/animate.min.css'>
    <link rel='stylesheet' href='./css/tether.min.css'>
	<!-- Demo CSS -->
	<link rel="stylesheet" href="./css/demo.css">

<div class="sidebar-container">
    <a href="index.php">
        <img class="mb-2 mt-2 offset-3" src="inc/img/Logo.png" alt="" width="72" height="72"> 
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
    <?php if($level == 1){ ?>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-users" aria-hidden="true"></i> Customer
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Customer</div>
            <li><a href="addCustomer.php">Add Customer</a></li>
            <li><a href="customer.php">Manage Customer</a></li>
            <li><a href="cLedger.php">Customer Ledger</a></li>
        </ul>
    </li>
    
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-suitcase" aria-hidden="true"></i> Employee
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Employee</div>
            <li><a href="addEmployee.php">Add Employee</a></li>
            <li><a href="employee.php">Manage Employee</a></li>
            <li><a href="addNoPay.php">Add No Pay Leaves</a></li>
        </ul>     
    </li>
    <?php } ?>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-credit-card" aria-hidden="true"></i> Bills & Payments
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Bills & Payments</div>
            <li><a href="billing.php">Customer Billing</a></li>
            <li><a href="cBill.php">Collect Bills</a></li>
            <li><a href="cPay.php">Customer Payments</a></li>
            <li><a href="sPay.php">Salary Payments</a></li>
            <li><a href="oCost.php">Other Costs</a></li>
        </ul>
    </li>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-file-pdf" aria-hidden="true"></i> Reports
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Reports</div>
            <li><a href="income.php">Income Report</a></li>
            <li><a href="expense.php">Expense Report</a></li>
            <li><a href="profit.php">Profit Report</a></li>
        </ul>
    </li>

    <li class="header">Software Settings</li>
    <li>
        <a href="#works" class="dropdown-toggle"  data-toggle="dropdown">
            <i class="fa fa-user-circle" aria-hidden="true"></i> Users
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu animated fadeInLeft" role="menu" style="background-color: black;">
            <div class="dropdown-header">Users</div>
            <li><a href="addUser.php">Add User</a></li>
            <li><a href="user.php">Manage Users</a></li>
        </ul>
     
    </li>
    <li>
      <a href="rates.php">
        <i class="fa fa-industry" aria-hidden="true"></i> Rates
      </a>
    </li>
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