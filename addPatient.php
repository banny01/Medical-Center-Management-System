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

    
    <title>Add Patient</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0,2));
        $errors = addPatient($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2" > <!-- This div for the content -->
            <h5>Patient > Add</h5>
            
            <div class="col-md-12 mt-3">
                <?php 
                if ($errors==1) {                    
					echo ('<p id="info" class="alert alert-danger text-center fade show">Patient ID Already Exists.!</p>');					
				}
                else if($errors==2){
                    echo ('<p id="info" class="alert alert-success text-center fade show">Patient added succesfully.!</p>');
                }
                else if($errors==3){
                    echo ('<p id="info" class="alert alert-danger text-center fade show">Patient added Faild.! Please try again.</p>');
                }
                ?>
                <form class="row" action="" method="post" id="addPat">
                    <div class="col-md-6">
                        <div class="form-group col-md-6">
                            <label for="">Patient ID</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patID" placeholder="Enter Patient ID" required>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Patient Name</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patName" placeholder="Enter Patient Name" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Age</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patAge" placeholder="Years" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patCont" placeholder="Enter Contact Number" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="">Address</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patAddress" placeholder="Enter Patient Address" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Note</label>
                            <textarea type="text" class="form-control" name="patNote" placeholder="note..."></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Membership Date</label><i style="color: red;">*</i>
                            <input type="date" name="memberDate" class="form-control mt-3" id="date" required>
                        </div>
                    </div>
                    <div class="col-md-6 offset-4">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Add</button>
                        <button type="reset" id="reset"  class="btn btn-danger">Reset</button>
                    </div>
                    
                </form>
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

</script>

</html>
<?php 
function addPatient($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $patID = $_POST['patID'];
        $patName = $_POST['patName'];
        $patAge = $_POST['patAge'];
        $patCont = $_POST['patCont'];
        $patAddress = $_POST['patAddress'];
        $patNote = $_POST['patNote'];
        $memberDate = $_POST['memberDate'];

        $query = "SELECT * FROM patient WHERE id = '{$patID}'";
        $result_set = mysqli_query($con, $query);

        if (mysqli_num_rows($result_set) > 0) {
            $errors = 1;
        }
        if ($errors == 0) {            
            $query2 = "INSERT INTO patient VALUES ('{$patID}', '{$patName}', '{$patAge}', '{$patAddress}', '{$patCont}', '{$patNote}', '{$memberDate}')";
            $result_set2 = mysqli_query($con, $query2);
            
            if ($result_set2) {
                $errors = 2;               
            }
            else{
                $errors = 3;
            }
        }
    }
    
    return $errors;
                
}
?>