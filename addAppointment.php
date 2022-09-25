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

    
    <title>Add Appointment</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0,2));
        $errors = appointment($con, $loggedDet);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2"> <!-- This div for the content -->

            <h5>Appointments > Add Appointment</h5>
            <?php 
            if ($errors==1) {                    
                echo ('<p id="info" class="alert alert-danger text-center fade show">Recode Not Saved.! Please check and try again.</p>');					
            }
            if ($errors==0) {                    
                echo ('<p id="info" class="alert alert-success text-center fade show">Appointment added succesfully.!</p>');
            }
            ?>
            <div class="row">
                <div class="col-md-6 offset-3 mt-3">
                    
                    <form class="" action="" method="post">
                        <div class="">
                            <div class="form-group col-md-8">
                                <label for="">Patient ID</label><i style="color: red;">*</i>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="pID" id="pID" placeholder="Enter Patient ID" required>
                                    </div>
                                    <div class="col-md-">
                                        <button type="button" onclick="search()" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-10">
                                <label for="">Patient Name</label>
                                <input type="text" class="col-md-8 form-control" name="pName" id="pName" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Doctor</label><i style="color: red;">*</i>
                                <select class="form-control" name="doctorID">
                                    <option value="" selected>Please Select a Doctor</option>
                                    <?php 
                                    $resultset = getDoctors($con);
                                    while( $developer = mysqli_fetch_assoc($resultset) ) { ?>
                                    <option value="<?php echo $developer ['id']; ?>"><?php echo $developer ['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="">Appointment Date</label><i style="color: red;">*</i>
                                <div class="row mt-3">
                                    <div class="col-md-7">
                                        <input type="datetime-local" name="dateTime" id="dateTime" class="form-control" required>
                                    </div>
                                    <div class="col-md-1" id="valied"></div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="searchTime()" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-6 offset-0">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary"> &emsp;Add&emsp;</button>
                            <button type="reset" id="reset"  class="btn btn-danger">Reset</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php include_once('inc/footer.php'); ?>
    </div>
</body>
<script>
    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);
    
    function search(){
        var search = document.getElementById("pID").value;
        let data = {id: search};
        var Url = "search.php";
        var xhr = new XMLHttpRequest();
        xhr.open('POST', Url, true);
        xhr.send(JSON.stringify(data));
        xhr.onreadystatechange = processRequest;
        function processRequest(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response1 = JSON.parse(xhr.responseText);
                pName = response1[0].name;
                if(pName != ''){
                    document.getElementById("pName").value = pName;
                }
            }
        }
    }

    function searchTime(){
        var search = document.getElementById("dateTime").value;
        var Url = "search.php?time="+search;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', Url, true);
        xhr.send( null );
        xhr.onload = function(){
            var response1 = JSON.parse(xhr.responseText);
                res = response1[0].count;
                if(res == 0){
                    // alert("This time slot already selected.");
                    document.getElementById("valied").innerHTML = "<i class='fa fa-lg fa-check mt-2' style='color:green;'></i>";
                }
                if(res > 0){
                    // alert("This time slot already selected.");
                    document.getElementById("valied").innerHTML = "<i class=\"fa fa-lg fa-times mt-2\" style=\"color:red;\">";
                }
        }
    }
</script>
</html>
<?php
function appointment($con, $loggedDet){
    $errors = -1;
    if (isset($_POST['submit'])){
        
        $pID = $_POST['pID'];
        $doctorID = $_POST['doctorID'];
        $time = $_POST['dateTime'];
        $timeT = str_replace("T"," ", $time);
        $timestamp = strtotime($timeT);
        $time1 = $timestamp - (30 * 60);
        $time2 = $timestamp + (30 * 60);
        $datetime1 = date("Y-m-d H:i:s", $time1);
        $datetime2 = date("Y-m-d H:i:s", $time2);
        $query = "SELECT COUNT(id) as count FROM appointment WHERE date BETWEEN '{$datetime1}' AND '{$datetime2}'";
        $result_set = mysqli_query($con, $query);
        while( $row = mysqli_fetch_assoc($result_set)){
            if($row['count'] == 0){
                $query2 = "INSERT INTO appointment (patientID, doctorID, date) VALUES ('{$pID}', '{$doctorID}', '{$time}')";
                $result_set2 = mysqli_query($con, $query2);
                
                if ($result_set2) {   
                    $errors = 0;
                } else{
                    $errors = 1;
                }
            } else{
                $errors = 1;
            }
        }
        
    }
    
    return $errors;
}

function getDoctors($con){
    $sql_query = "SELECT id, name FROM user WHERE designation = 1;";
    $resultset = mysqli_query($con, $sql_query);

    return $resultset;
}
?>