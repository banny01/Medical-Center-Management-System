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

    
    <title>Add User</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0));
        $errors = addUser($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2" > <!-- This div for the content -->
            <h5>User > Add</h5>
            
            <div class="col-md-12 mt-3">
                <?php 
                if ($errors==1) {                    
					echo ('<p id="info" class="alert alert-danger text-center fade show">User Name or An User For The Employee ID Already Exists.!</p>');					
				}
                else if($errors==2){
                    echo ('<p id="info" class="alert alert-success text-center fade show">User added succesfully.!</p>');
                }
                else if($errors==3){
                    echo ('<p id="info" class="alert alert-danger text-center fade show">User added Faild.! Please try again.</p>');
                }
                else if($errors==4){
                    echo ('<p id="info" class="alert alert-danger text-center fade show">User added Faild.! Invalid Employee ID.</p>');
                }
                ?>
                <form class="row" action="" method="post">
                    <div class="col-md-6">
                        <div class="form-group col-md-6">
                            <label for="">User Name</label><i style="color: red;">*</i>
                            <input type="text" class="form-control addCus" name="userName" placeholder="Enter a User Name" required>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Name</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Password</label><i style="color: red;">*</i>
                            <input type="Password" class="form-control" name="password" placeholder="Enter a Password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Gender</label><i style="color: red;">*</i>
                            <select class="form-control" name="gender">
                                <option value="" selected>Please Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Designation</label><i style="color: red;">*</i>
                            <select class="form-control" name="designation">
                                <option value="" selected>Please Select a Designation</option>
                                <option value="0">Admin</option>
                                <option value="1">Doctor</option>
                                <option value="2">Reciption</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-10">
                            <label for="">Address</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact</label><i style="color: red;">*</i>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Details</label>
                            <input type="text" class="form-control" name="special">
                        </div>
                        <div class="form-group col-md-10">
                            <label for="">Note</label>
                            <textarea type="text" class="form-control" name="note"></textarea>
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
function addUser($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $designation = $_POST['designation'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $special = $_POST['special'];
        $note = $_POST['note'];

        $query = "SELECT * FROM user WHERE userName = '{$userName}'";
        $result_set = mysqli_query($con, $query);
        if (mysqli_num_rows($result_set) > 0) {
            $errors = 1;
        }
        if ($errors == 0) {             

            $query2 = "INSERT INTO user (userName, Password, name, designation, gender, address, phone, special, note) VALUES ('{$userName}', '{$password}', '{$name}', '{$designation}', '{$gender}', '{$address}', '{$phone}', '{$special}', '{$note}')";
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