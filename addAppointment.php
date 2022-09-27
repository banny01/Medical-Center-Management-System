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
                echo ('<p id="info" class="alert alert-danger text-center fade show">Recorde Not Saved.! Please check and try again.</p>');					
            }
            if ($errors==0) {                    
                echo ('<p id="info" class="alert alert-success text-center fade show">Appointment added succesfully.!</p>');
            }
            ?>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <form class="" action="" method="post">
                        <div class="">
                            <div class="form-group col-md-10">
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
                            <div class="form-group col-md-12">
                                <label for="">Patient Name</label>
                                <input type="text" class="col-md-12 form-control" name="pName" id="pName" readonly>
                            </div>
                            <div class="form-group col-md-10">
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
                            <div class="form-group col-md-12">
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
                        <div class="col-md-8 mt-4">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary"> &emsp;Add&emsp;</button>
                            <button type="reset" id="reset"  class="btn btn-danger">Reset</button>
                        </div>                        
                    </form>
                </div>
                <div class="col-md-8 mt-3">
                    <div class="col-md-10 offset-2 input-group mb-2">
                        <div class="form-outline">
                            <input type="search" id="form1" class="form-control" placeholder="Search Patient"/>
                        </div>
                        <div class="form-outline ml-2">
                            <input type="date" id="sDate" class="form-control" placeholder="Search Patient"/>
                        </div>
                        <button type="button" onclick="searchAP()" class="btn btn-primary ml-4">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" onclick="location.href='addAppointment.php'" class="btn btn-danger ml-1">Reset</button>
                    </div>

                    <script src="js/jquery-1.11.1.min.js"></script> <!-- Table with Pagination -->
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>Appointment</th>
                                        <th>Date</th>
                                        <th>Cancel</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    <?php 
                                    $resultset = getAPList($con);
                                    $i = 1;
                                    while( $developer = mysqli_fetch_assoc($resultset) ) {
                                    ?>
                                        <tr>
                                            <td style="font-weight: bold;"><?php echo $i; ?></td>
                                            <td title="<?php echo $developer ['patientID']; ?>"><?php echo $developer ['patientID']; ?></td>
                                            <td title="<?php echo $developer ['pName']; ?>"><?php echo $developer ['pName']; ?></td>
                                            <td title="<?php echo $developer ['dName']; ?>"><?php echo $developer ['dName']; ?></td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($developer ['date'])); ?></td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($developer ['addedDate'])); ?></td>
                                            <td class="font-weight-bold"><?php if($developer ['cancel'] == 1){
                                                echo "Canceled";
                                            } else{ ?>
                                                <button type="button" onclick="cancel(<?php echo $developer ['id']; ?>)" class="btn btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php } ?></td>  
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>   
                            </div>
                            <div class="col-md-12 text-center">
                                <ul class="pagination pagination-lg pager" id="myPager"></ul>
                            </div>
                        </div>
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
    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);
    
    $.fn.pageMe = function(opts){
        var $this = this,
            defaults = {
                perPage: 7,
                showPrevNext: false,
                hidePageNumbers: false
            },
            settings = $.extend(defaults, opts);
        
        var listElement = $this;
        var perPage = settings.perPage; 
        var children = listElement.children();
        var pager = $('.pager');
        
        if (typeof settings.childSelector!="undefined") {
            children = listElement.find(settings.childSelector);
        }
        
        if (typeof settings.pagerSelector!="undefined") {
            pager = $(settings.pagerSelector);
        }
        
        var numItems = children.size();
        var numPages = Math.ceil(numItems/perPage);

        pager.data("curr",0);
        
        if (settings.showPrevNext){
            $('<li class="btn "><a href="#" class="prev_link"><<</a></li>').appendTo(pager);
        }
        
        var curr = 0;
        while(numPages > curr && (settings.hidePageNumbers==false)){
            $('<li class="btn "><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
            curr++;
        }
        
        if (settings.showPrevNext){
            $('<li class="btn "><a href="#" class="next_link">>></a></li>').appendTo(pager);
        }
        
        pager.find('.page_link:first').addClass('active');
        pager.find('.prev_link').hide();
        if (numPages<=1) {
            pager.find('.next_link').hide();
        }
        pager.children().eq(1).addClass("active");
        
        children.hide();
        children.slice(0, perPage).show();
        
        pager.find('li .page_link').click(function(){
            var clickedPage = $(this).html().valueOf()-1;
            goTo(clickedPage,perPage);
            return false;
        });
        pager.find('li .prev_link').click(function(){
            previous();
            return false;
        });
        pager.find('li .next_link').click(function(){
            next();
            return false;
        });
        
        function previous(){
            var goToPage = parseInt(pager.data("curr")) - 1;
            goTo(goToPage);
        }
        
        function next(){
            goToPage = parseInt(pager.data("curr")) + 1;
            goTo(goToPage);
        }
        
        function goTo(page){
            var startAt = page * perPage,
                endOn = startAt + perPage;
            
            children.css('display','none').slice(startAt, endOn).show();
            
            if (page>=1) {
                pager.find('.prev_link').show();
            }
            else {
                pager.find('.prev_link').hide();
            }
            
            if (page<(numPages-1)) {
                pager.find('.next_link').show();
            }
            else {
                pager.find('.next_link').hide();
            }
            
            pager.data("curr",page);
            pager.children().removeClass("active");
            pager.children().eq(page+1).addClass("active");
        
        }
    };

    $(document).ready(function(){
        
        $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});
        
    });

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

    function searchAP(){
        var text = document.getElementById("form1").value;
        var date = document.getElementById("sDate").value;
        var link = "addAppointment.php?search="+text;
        if(date != ""){
            link = link + "&date="+date;
        }
        window.location.href = link;

    }
    
    function cancel(text) {
        var link = "addAppointment.php?cancel="+text;
        window.location.href = link;
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
        $query = "SELECT COUNT(id) as count FROM appointment WHERE date BETWEEN '{$datetime1}' AND '{$datetime2}' AND cancel = 0;";
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

function getAPList($con){
    $resultset = null;
    $sql_query = null;

    if(isset($_GET['cancel'])){
        $id = $_GET['cancel'];
        $query = "UPDATE appointment SET cancel = 1 WHERE id = '{$id}'";
        $result_set = mysqli_query($con, $query);

        $sql_query = "SELECT a.id, a.patientID, a.date, a.addedDate, a.cancel, p.name AS pName, u.name AS dName FROM appointment a INNER JOIN patient p ON a.patientID = p.id INNER JOIN user u ON a.doctorID = u.id WHERE a.id = $id;";
        $resultset = mysqli_query($con, $sql_query);
    }
    else if((isset($_GET['search']) && $_GET['search'] != "") || isset($_GET['date'])){
        $sql_query = "SELECT a.id, a.patientID, a.date, a.addedDate, a.cancel, p.name AS pName, u.name AS dName FROM appointment a INNER JOIN patient p ON a.patientID = p.id INNER JOIN user u ON a.doctorID = u.id WHERE ";
        if(isset($_GET['search']) && isset($_GET['date']) && $_GET['search'] != "" && $_GET['date'] != ""){
            $patientID = $_GET['search'];
            $date = $_GET['date'];
            $sql_query = $sql_query . "a.patientID = '{$patientID}' AND DATE(a.date) = '{$date}'";
        }
        else if(isset($_GET['search']) && $_GET['search'] != ""){
            $patientID = $_GET['search'];
            $sql_query = $sql_query . "a.patientID = $patientID ";
        }
        else if(isset($_GET['date']) && $_GET['date'] != ""){
            $date = $_GET['date'];
            $sql_query = $sql_query . "DATE(a.date) = '{$date}' ";
        }
        $resultset = mysqli_query($con, $sql_query);
    } else{
        $sql_query = "SELECT a.id, a.patientID, a.date, a.addedDate, a.cancel, p.name AS pName, u.name AS dName FROM appointment a INNER JOIN patient p ON a.patientID = p.id INNER JOIN user u ON a.doctorID = u.id;";
        $resultset = mysqli_query($con, $sql_query);
    }
    return $resultset;
}
?>