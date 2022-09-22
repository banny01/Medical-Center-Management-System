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

    
    <title>My Account</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        $errors = editUser($con);
        $developer = loadUser($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2" > <!-- This div for the content -->
            <h5>User > My Account</h5>
            
            <div class="col-md-6 offset-3 mt-3">
               
                <form class="" action="" method="post" >
                    <div class="">
                        <div class="form-group col-md-6">
                            <label for="">User Name</label>
                            <input type="text" class="form-control " name="ID" value="<?php echo $developer ['id']; ?>" hidden>
                            <input type="text" class="form-control " name="userName" placeholder="Enter a User Name" value="<?php echo $developer ['userName']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Name</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php echo $developer ['name']; ?>" required>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Password</label><i style="color: red;">*</i>
                            <input type="Password" class="form-control" name="password" placeholder="Enter a Password" value="<?php echo $developer ['password']; ?>" required>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="">Designation</label><i style="color: red;">*</i>
                            <select class="form-control" name="designation" id="designation" disabled="disabled">
                                <option value="0">Admin</option>
                                <option value="1">Doctor</option>
                                <option value="2">Reciption</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6 offset-0">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Edit</button>
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
    document.getElementById('designation').value = "<?php echo $developer ['designation']; ?>";

    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);

</script>
</html>

<?php
function loadUser($con){
    $developer = null;
    if(isset($_POST['myAcc'])){
        $search = $_POST['myAcc'];
        $sql_query = "SELECT * FROM user WHERE id = '{$search}'";
        $resultset = mysqli_query($con, $sql_query);
        $developer = mysqli_fetch_assoc($resultset);
    }
    return $developer;
}

function editUser($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $designation = $_POST['designation'];
        $id = $_POST['ID'];

        $query = "UPDATE user SET password = '{$password}', name = '{$name}' WHERE id = '{$id}'";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            if(isset($_POST['myAcc']))
                echo "<script> alert('Successfuly Updated.!');</script>";

            else
                echo "<script> alert('Successfuly Updated.!'); window.location.href = 'manageUser.php';</script>";
        }
        else{
            echo "<script> alert('Not Updated.! Please try again.')</script>";
        }
    }    
    return $errors;                
}
?>