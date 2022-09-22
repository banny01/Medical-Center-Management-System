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

    
    <title>Patients</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/func.php');
        include_once('inc/connection.php');
        userManage($level, array(0,2));
        $errors = deletPat($con);
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2"> <!-- This div for the content -->
            <h5>Patient</h5>
            
            <div class="col-md-4 input-group offset-8 mb-2">
                <div class="form-outline">
                    <input type="search" id="form1" class="form-control" placeholder="Search Name or ID"/>
                </div>
                <button type="button" onclick="search()" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" onclick="location.href='managePatient.php'" class="btn btn-danger ml-1">Reset</button>
            </div>

            <script src="js/jquery-1.11.1.min.js"></script> <!-- Table with Pagination -->
            <div class="container">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Note</th>
                                <th>Membership date</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                            <?php 
                            $resultset = patient($con);
                            $i = 1;
                            while( $developer = mysqli_fetch_assoc($resultset) ) {
                            ?>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo $i; ?></td>
                                    <td title="<?php echo $developer ['id']; ?>"><?php echo $developer ['id']; ?></td>
                                    <td title="<?php echo $developer ['name']; ?>"><?php echo $developer ['name']; ?></td>
                                    <td title="<?php echo $developer ['age']; ?>"><?php echo $developer ['age']; ?></td>
                                    <td class="fixed" title="<?php echo $developer ['address']; ?>"><?php echo $developer ['address']; ?></td>
                                    <td title="<?php echo $developer ['phone']; ?>"><?php echo $developer ['phone']; ?></td>
                                    <td class="fixed" title="<?php echo $developer ['note']; ?>"><?php echo $developer ['note']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($developer ['regDate'])); ?></td>
                                    <td>
                                    <button type="button" onclick="edit(<?php echo $developer ['id']; ?>)" class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" onclick="delete1(<?php echo $developer ['id']; ?>)" class="btn btn-danger">
                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                    </button>
                                    </td>		  
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

    <div class="row">
        <?php include_once('inc/footer.php'); ?>
    </div>
</body>
<script>
    
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
        var text = document.getElementById("form1").value;
        var link = "managePatient.php?search="+text;
        window.location.href = link;

    }
    function edit(id){
        var link = "editPatient.php?id="+id;
        window.location.href = link;
    }
    function delete1(id){
        params = {delete: id};
        const form = document.createElement('form');
        form.method = "post";
        form.action = "managePatient.php";

        for (const key in params) {
            if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }

    
</script>

</html>
<?php
function patient($con){
    $resultset = null;
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $sql_query = "SELECT * FROM patient WHERE id = '{$search}' OR name LIKE '%{$search}%'";
        $resultset = mysqli_query($con, $sql_query);
    }
    else{
        $sql_query = "SELECT * FROM patient";
        $resultset = mysqli_query($con, $sql_query);
    }
    return $resultset;
}

function deletPat($con){
    $errors = 1;
    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        $query = "DELETE FROM patient WHERE id = '{$id}'";
        $result_set = mysqli_query($con, $query);
        if ($result_set) {
            $errors = 0;               
        }

    }
    return $errors;
}
?>