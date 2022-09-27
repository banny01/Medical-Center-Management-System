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
                            <button type="button" onclick="manageDiseases()" class="col-md-3 btn btn-light mr-4 mt-2">
                                <i class="fa fa-stethoscope" aria-hidden="true"></i><br>View Diseases
                            </button>
                            <button type="button" onclick="manageMedicines()" class="col-md-3 btn btn-light mr-4 mt-2">
                                <i class="fa fa-medkit" aria-hidden="true"></i><br>View Medicines
                            </button>
                                <button type="button" onclick="manageResutls()" class="col-md-3 btn btn-light mr-4 mt-2">
                                    <i class="fa fa-list" aria-hidden="true"></i><br>View Test Resutls
                                </button>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if($level == 0 || $level == 1){ ?>
                            <button type="button" class="col-md-3 btn btn-light mr-4 mt-2" data-toggle="modal" data-target="#addDisease">
                                <i class="fa fa-user-md" aria-hidden="true"></i><br>Add Disease
                            </button>
                            <button type="button" class="col-md-3 btn btn-light mr-4 mt-2" data-toggle="modal" data-target="#addMedicine">
                                <i class="fa fa-plus-square" aria-hidden="true"></i><br>Add Medicine
                            </button>
                            <?php } 
                            if($level == 0 || $level == 1 || $level == 2){ ?>
                            <button type="button" class="col-md-3 btn btn-light mr-4 mt-2" data-toggle="modal" data-target="#addTest">
                                <i class="fa fa-heartbeat" aria-hidden="true"></i><br>Add Test
                            </button>
                            <?php } 
                            if($level == 0 || $level == 2){ ?>
                            <button type="button" class="col-md-3 btn btn-light mr-4 mt-2" onclick="addRes()">
                                <i class="fa fa-edit" aria-hidden="true"></i><br>Add Results
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div id="addDisease" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Disease</h4>
                </div>
                <div class="modal-body">
                    <div class="messege"></div>
                    <label for="">Disease Description</label>
                    <textarea type="text" class="col-md-12 form-control" placeholder="Write here..." id="dis" require></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addDis(<?php echo $uID; ?>)">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="addMedicine" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Medicines</h4>
                </div>
                <div class="modal-body">
                    <div class="messege"></div>
                    <label for="">Medicine List</label>
                    <textarea type="text" class="col-md-12 form-control" placeholder="Write here..." id="medi" require></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addMedi(<?php echo $uID; ?>)">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="addTest" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Test</h4>
                </div>
                <div class="modal-body">
                    <div class="messege"></div>
                    <label for="">Test Name</label>
                    <input type="text" class="col-md-12 form-control" id="test" placeholder="Test Name here..." require>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addTest(<?php echo $uID; ?>)">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php include_once('inc/footer.php'); ?>
    </div>
</body>
<script>
    
    function manageDiseases(){
        search = document.getElementById("pID").value;
        window.open('manageDiseases.php?pID='+search);
    }

    function manageMedicines(){
        search = document.getElementById("pID").value;
        window.open('manageMedicines.php?pID='+search);
    }

    function manageResutls(){
        search = document.getElementById("pID").value;
        window.open('manageResutls.php?pID='+search);
    }

    function search(pID){
        var search = "";
        if(pID == ""){
            search = document.getElementById("pID").value;
        } else{
            search = pID;
            document.getElementById("pID").value = pID;
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

    function addDis(uID){
        pID = document.getElementById("pID").value;
        dis = document.getElementById("dis").value;
        doctorID = uID;
        if(dis != null && dis != ""){
            let data = {pID: pID, doctorID: doctorID, dis: dis};
            var Url = "addDis.php";
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Url, true);
            xhr.send(JSON.stringify(data));
            xhr.onreadystatechange = processRequest;
            function processRequest(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response1 = JSON.parse(xhr.responseText);
                    if(response1 == true){
                        alert("Record added succesfully.!");
                        document.getElementById("dis").value = "";
                    } else{
                        alert("Recorde Not Saved.! Please check and try again.");
                    }
                }
            }
        }
    }

    function addMedi(uID){
        pID = document.getElementById("pID").value;
        medi = document.getElementById("medi").value;
        doctorID = uID;
        if(medi != null && medi != ""){
            let data = {pID: pID, doctorID: doctorID, medi: medi};
            var Url = "addMedi.php";
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Url, true);
            xhr.send(JSON.stringify(data));
            xhr.onreadystatechange = processRequest;
            function processRequest(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response1 = JSON.parse(xhr.responseText);
                    if(response1 == true){
                        alert("Record added succesfully.!");
                        document.getElementById("medi").value = "";
                    } else{
                        alert("Recorde Not Saved.! Please check and try again.");
                    }
                }
            }
        }
    }

    function addTest(uID){
        pID = document.getElementById("pID").value;
        test = document.getElementById("test").value;
        doctorID = uID;
        if(medi != null && medi != ""){
            let data = {pID: pID, doctorID: doctorID, test: test};
            var Url = "addTest.php";
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Url, true);
            xhr.send(JSON.stringify(data));
            xhr.onreadystatechange = processRequest;
            function processRequest(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response1 = JSON.parse(xhr.responseText);
                    if(response1 == true){
                        alert("Record added succesfully.!");
                        document.getElementById("test").value = "";
                    } else{
                        alert("Recorde Not Saved.! Please check and try again.");
                    }
                }
            }
        }
    }

    function addRes(){
        pID = document.getElementById("pID").value
        window.location = "manageResutls.php?pID="+pID+"&done=0";
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