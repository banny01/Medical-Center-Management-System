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

    
    <title>Search Patients</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0,1,2));
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2"> <!-- This div for the content -->

            <h5>Patient > Search Patient</h5>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="font-weight-bold">
                        <div class="form-group col-md-10">
                            <label for="">Patient ID</label><i style="color: red;">*</i>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="pID" id="pID" placeholder="Enter Patient ID" required>
                                </div>
                                <div class="col-md-">
                                    <button type="button" onclick="search('')" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-md-5">Patient Name :</label><label class="col-md-7" id="pName"></label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-md-5">Age :</label><label class="col-md-7" id="age"></label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-md-5">Address :</label>
                            <label class="col-md-12 ml-2" id="address"></label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="col-md-5">Contact :</label><label class="col-md-7" id="phone"></label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Note</label>
                            <textarea type="text" class="form-control" id="patNote" placeholder="note..."></textarea>
                        </div>
                    </div>                       
                </div>
                <div class="col-md-8 mt-3">
                    <div class="offset-1 mt-2">
                        <div>
                            <?php if($level == 0 || $level == 1){ ?>
                            <a href="managePatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-stethoscope" aria-hidden="true"></i><br>View Diseases
                                </button>
                            </a>
                            <a href="managePatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-medkit" aria-hidden="true"></i><br>View Medicines
                                </button>
                            </a>
                            <a href="searchPatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-list" aria-hidden="true"></i><br>View Test Resutls
                                </button>
                            </a>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if($level == 0 || $level == 1){ ?>
                            <a href="addPatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-user-md" aria-hidden="true"></i><br>Add Disease
                                </button>
                            </a>
                            <a href="managePatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i><br>Add Medicine
                                </button>
                            </a>
                            <?php } 
                            if($level == 0 || $level == 1 || $level == 2){ ?>
                            <a href="searchPatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-heartbeat" aria-hidden="true"></i><br>Add Test
                                </button>
                            </a>
                            <?php } 
                            if($level == 0 || $level == 2){ ?>
                            <a href="searchPatient.php">
                                <button type="button" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-edit" aria-hidden="true"></i><br>Add Results
                                </button>
                            </a>
                            <?php } ?>
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
    
    function search(pID){
        var search = "";
        if(pID == ""){
            search = document.getElementById("pID").value;
        } else{
            search = pID;
        }
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
                age = response1[0].age;
                address = response1[0].address;
                phone = response1[0].phone;
                note = response1[0].note;
                regDate = response1[0].regDate;
                if(pName != ''){
                    document.getElementById("pName").innerHTML = pName;
                    document.getElementById("age").innerHTML = age + " years old";
                    document.getElementById("address").innerHTML = address;
                    document.getElementById("phone").innerHTML = phone;
                    document.getElementById("patNote").innerHTML = note;
                }
            }
        }
    }
</script>
</html>
<?php
function getPatList(){
    if(isset($_GET['pID'])){
        $id = $_GET['pID'];
        echo "<script> search('$id'); </script>";
    }

}
getPatList();
?>