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

    
    <title>Add Result</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/connection.php');
        include_once('inc/func.php');
        userManage($level, array(0,2));
        $resultset = loadTest($con);
        $developer = mysqli_fetch_assoc($resultset);
        $errors = addResults($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2" > <!-- This div for the content -->
            <h5>Test Resutls > Add Result</h5>
            
            <div class="col-md-12 mt-3">
                <?php 
                if($errors==0){
                    echo ('<p id="info" class="alert alert-success text-center fade show">Results added succesfully.!</p>');
                }
                else if($errors==1){
                    echo ('<p id="info" class="alert alert-danger text-center fade show">Results added Faild.! Please try again.</p>');
                }
                ?>
                <form class="row" action="" method="post">
                    <div class="col-md-6 font-weight-bold offset-2">
                        <div class="form-group col-md-12">
                            <label class="col-md-4">Test Name : </label><label class="" id="test"><?php echo $developer['testName']; ?></label>
                            <input type="text" name="id" id="id" value="<?php echo $developer['id']; ?>" hidden>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="col-md-4">Date : </label><label class="" id="date"><?php echo date('Y-m-d', strtotime($developer['date'])); ?></label>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4"><label >Results : </label><i style="color: red;">*</i></div>
                            <textarea type="text" rows="9" class="form-control col-md-12" name="result" placeholder="Enter Results..." required></textarea>
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
function addResults($con){
    $errors = -1;
    if (isset($_POST['submit'])){
        date_default_timezone_set("Asia/Colombo");
        $today = date("Y-m-d");
        $id = $_POST['id'];
        $result = $_POST['result'];
        $query = "UPDATE test SET results = '{$result}', doneDate = '{$today}', done = 1 WHERE id = $id;";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $errors = 0;               
        }
        else{
            $errors = 1;
        }
    }
    return $errors;
}

function loadTest($con){
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT * FROM test WHERE id = '{$id}'";
        $result_set = mysqli_query($con, $query);
    }
    return $result_set;
}
?>