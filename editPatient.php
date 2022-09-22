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

    
    <title>Edit Patient</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0,2));
        $developer = loadPatient($con);
        $errors = editPatient($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2" > <!-- This div for the content -->
            <h5>Patient > Edit</h5>
            
            <div class="col-md-12 mt-3">
                
                <form class="row" action="" method="post" id="addPat">
                    <div class="col-md-6">
                        <div class="form-group col-md-6">
                            <label for="">Patient ID</label>
                            <input type="text" class="form-control" name="patID" placeholder="Enter Patient ID" value="<?php echo $developer ['id']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Patient Name</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patName" placeholder="Enter Patient Name" value="<?php echo $developer ['name']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Age</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patAge" placeholder="Years" value="<?php echo $developer ['age']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patCont" placeholder="Enter Contact Number" value="<?php echo $developer ['phone']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="">Address</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="patAddress" placeholder="Enter Patient Address" value="<?php echo $developer ['address']; ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Note</label>
                            <textarea type="text" class="form-control" name="patNote" placeholder="note..."><?php echo $developer ['note']; ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Membership Date</label><i style="color: red;">*</i>
                            <input type="date" name="memberDate" class="form-control mt-3" id="date" value="<?php echo date('Y-m-d', strtotime($developer ['regDate'])); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 offset-4">
                        <button type="submit" name="submit" value="submit" class="btn btn-success">Edit</button>
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
</html>
<?php
function loadPatient($con){
    $developer = null;
    if(isset($_GET['id'])){
        $search = $_GET['id'];
        $sql_query = "SELECT * FROM patient WHERE id = '{$search}'";
        $resultset = mysqli_query($con, $sql_query);
        $developer = mysqli_fetch_assoc($resultset);
    }
    return $developer;
}

function editPatient($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $patID = $_POST['patID'];
        $patName = $_POST['patName'];
        $patAge = $_POST['patAge'];
        $patCont = $_POST['patCont'];
        $patAddress = $_POST['patAddress'];
        $patNote = $_POST['patNote'];
        $memberDate = $_POST['memberDate'];      
        
        $query = "UPDATE patient SET name = '{$patName}', age = '{$patAge}', address = '{$patAddress}', phone = '{$patCont}', note = '{$patNote}', regDate = '{$memberDate}' WHERE id = '{$patID}'";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            echo "<script> alert('Successfuly Updated.!'); window.location.href = 'managePatient.php';</script>";
        }
        else{
            echo "<script> alert('Not Updated.! Please try again.')</script>";
        }
    }    
    return $errors;                
}
?>