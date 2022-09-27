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

    
    <title>Diseases</title>
</head>
<body class="container-fluid backg">

    <div class="row">
        <?php 
        include_once('inc/header.php');
        include_once('inc/func.php');
        include_once('inc/connection.php');
        userManage($level, array(0,1));
        ?>
        
    </div>
    <div class="row myContainer">        
        <div class="col-md-2" style="margin-top: -100px;">  
            <?php include_once('inc/sidebar.php'); ?>         
        </div>

        <div class="col-md-10 mt-2"> <!-- This div for the content -->
            <h5>Diseases</h5>
            <script src="js/jquery-1.11.1.min.js"></script> <!-- Table with Pagination -->
            <div class="container mt-4">
                <div class="row">
                    <div class="table-responsive">
                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th>Date</th>
                                        <th>Disease</th>
                                        <th>Doctor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    <?php 
                                    $resultset = getDisList($con);
                                    $i = 1;
                                    while( $developer = mysqli_fetch_assoc($resultset) ) {
                                    ?>
                                        <tr>
                                            <td style="width: 10%"><?php echo date('Y-m-d', strtotime($developer ['date'])); ?></td>
                                            <td style="width: 65%" title="<?php echo $developer ['des']; ?>"><?php echo $developer ['des']; ?></td>
                                            <td style="width: 25%" title="<?php echo $developer ['name']; ?>"><?php echo $developer ['name']; ?></td>
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

    
</script>

</html>
<?php
function getDisList($con){
    $resultset = null;
    if(isset($_GET['pID'])){
        $pID = $_GET['pID'];
        $sql_query = "SELECT d.id, d.date, d.des, u.name FROM disease d INNER JOIN user u ON d.doctorID = u.id WHERE d.patientID = $pID ORDER BY d.date DESC;";
        $resultset = mysqli_query($con, $sql_query);
    }

return $resultset;
}
?>