<?php 
    include_once('inc/connection.php');
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    
    if (isset($_SESSION['UserID'])) {
        # code...
        $loggedDet = $_SESSION['UserID'];
        $query2 = "SELECT * FROM user WHERE userName = '$loggedDet'";
        $res2 = mysqli_query($con, $query2);
        $loggeduser = mysqli_fetch_assoc($res2);
        $level = $loggeduser['designation'];
        $uID = $loggeduser['id'];
        
    }
    else{
        header('Location: login.php');
    }
?>

<link rel="icon"  href="img/favicon.png">

<div class="container-fluid text-white bg-dark" style="height: 88px; position: fixed; z-index: 10;">
    <div class="row">
        <div class="col-md-2 col-sm-2">
            <a href="index.php">
                <img class="mb-2 mt-2 offset-3" src="img/Logo.png" alt="" width="72" height="72"> 
            </a>
        </div>
        <div class="col-md-5 offset-1 col-sm-10">
            <div id="div1">
                <p id="time"></p>
                <p id="date"></p>
            </div>  
        </div>
        <div class="col-md-2 navbar navbar-expand-lg navbar-light h5">Welcome <?php echo $loggeduser['name']; ?> !</div>
        <div class="col-md-2 navbar navbar-expand-lg navbar-light" >
            <form method="post" action="editMyAcc.php">
                <input type="hidden" name="myAcc" value="<?php echo $uID; ?>" />
                <a class="nav-item nav-link" href="#" onclick="this.parentNode.submit();">Account</a>
            </form>
            <a class="nav-item nav-link" href="logout.php" >Log out</a>
        </div>
    </div>
</div>

<script>
    window.setInterval(ut, 1000);

    function ut() {
    var d = new Date();
    document.getElementById("time").innerHTML = d.toLocaleTimeString();
    document.getElementById("date").innerHTML = d.toLocaleDateString('zh-Hans-CN');
    }
</script>