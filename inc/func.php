<?php
function userManage($level, $permissions){
    $sup = 0;
    foreach ($permissions as $permission){
        if($level == $permission){
            $sup = 1;
            break;
        }
    }
    if($sup == 0){
        header('Location: index.php');
    }    
}


function addEmployee($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $empID = $_POST['empID'];
        $empFname = $_POST['fName'];
        $empLname = $_POST['lName'];
        $empNIC = $_POST['empNIC'];
        $empCont = $_POST['empCont'];
        $empAddress = $_POST['empAddress'];
        $bank = $_POST['bank'];
        $bankAcc = $_POST['bankAcc'];
        $role = $_POST['role'];
        $division = $_POST['division1'];
        $salary = $_POST['salary'];
        $memberDate = $_POST['memberDate'];

        $query = "SELECT * FROM employee WHERE EmpID = '{$empID}' AND DepID = 1";
        $result_set = mysqli_query($con, $query);

        if (mysqli_num_rows($result_set) > 0) {
            $errors = 1;
        }
        if ($errors == 0) {             

            $query2 = "INSERT INTO employee VALUES ('{$empID}', '{$empFname}', '{$empLname}', '{$empNIC}', '{$empAddress}', '{$empCont}', '{$bank}', '{$bankAcc}', '{$memberDate}', '{$role}', '{$division}', '{$salary}', '1')";
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





function cLedger($con, $status){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $query = "SELECT * FROM customerledger WHERE DepID = 1";
    $qEnd = "ORDER BY Date DESC";
    $resultset = null;
    
    if(isset($_GET['search'])){
        $id = $_GET['id'];
        $date1 = $_GET['date1'];
        $date2 = $_GET['date2'];
        $status2 = $_GET['status'];

        if($id!="")
            $query = "{$query} AND CusID = '{$id}'";

        if($date1!="" && $date2!="")
            $query = "{$query} AND (date(Date) BETWEEN '{$date1}' AND '{$date2}')";

        if($status2!="")
            $query = "{$query} AND Status = '{$status2}'";
            
        $query = "{$query} {$qEnd}";
        $resultset = mysqli_query($con, $query);
    }
    else{
        if($status == "")
            $sql_query = "{$query} {$qEnd}";

        else
            $sql_query = "{$query} AND Status = '{$status}' AND date(Date) = '{$today}' {$qEnd}";

        $resultset = mysqli_query($con, $sql_query);
    }
    return $resultset;
}

function bLedger($con, $status, $fDate, $tDate){
    $result = array();
    
    if($status == "CR"){
        $result = getBankLedger($con, $status, $fDate, $tDate);
        $result[2] = "Income";

        return $result;
    }
    else if($status == "DR"){
        $result = getBankLedger($con, $status, $fDate, $tDate);
        $result[2] = "Expenses";
        
        return $result;
    }
    else if($status == ""){
        $res1 = getBankLedger($con, 'CR', $fDate, $tDate);
        $res2 = getBankLedger($con, 'DR', $fDate, $tDate);
        $result[0] = $res1[1]['Amount'];
        $result[1] = $res2[1]['Amount'];
        $res3 = getBankTotal($con);
        $result[2] = $res3[0]['CR'];
        $result[3] = $res3[1]['DR'];

        return $result;
    }    
}

function getBankLedger($con, $status, $fDate, $tDate){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $month = date("m");
    $query = "SELECT * FROM bankledger WHERE DepID = 1";
    $query2 = "SELECT SUM(Amount) AS Amount FROM bankledger WHERE DepID = 1";
    $qEnd = "ORDER BY Date DESC";
    $result = array();
    
    if(isset($_GET['search'])){
        $fDate = $_GET['fDate'];
        $tDate = $_GET['tDate'];
    }

    if($status != ""){
        $query = "{$query} AND Status = '{$status}'";
        $query2 = "{$query2} AND Status = '{$status}'";
    }

    if($fDate != "" && $tDate != ""){
        if($fDate && $tDate == 'month'){
            $query = "{$query} AND month(Date) = '{$month}'";
        }
        else{
            $query = "{$query} AND (date(Date) BETWEEN '{$fDate}' AND '{$tDate}')";
            $query2 = "{$query2} AND (date(Date) BETWEEN '{$fDate}' AND '{$tDate}')";
        }
    }
    
    if($fDate == "" && $tDate == ""){
        $query = "{$query} AND date(Date) = '{$today}'";
        $query2 = "{$query2} AND date(Date) = '{$today}'";
    }

    $query = "{$query} {$qEnd}";
    $result[0]= mysqli_query($con, $query);
    $res2 = mysqli_query($con, $query2);
    $result[1] = mysqli_fetch_assoc($res2);

    return $result;

}

function getBankTotal($con){
    $result = array();
    $query1 = "SELECT SUM(Amount) AS CR FROM bankledger WHERE Status = 'CR' AND DepID = 1";
    $resultset1 = mysqli_query($con, $query1);
    $query2 = "SELECT SUM(Amount) AS DR FROM bankledger WHERE Status = 'DR' AND DepID = 1";
    $resultset2 = mysqli_query($con, $query2);
    $result[0] = mysqli_fetch_assoc($resultset1);
    $result[1] = mysqli_fetch_assoc($resultset2);

    return $result;
}

function employee($con){
    $resultset = null;
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $sql_query = "SELECT * FROM employee WHERE EmpID = '{$search}' OR Name LIKE '%{$search}%' AND DepID = 1";
        $resultset = mysqli_query($con, $sql_query);
    }
    else{
        $sql_query = "SELECT * FROM employee WHERE DepID = 1";
        $resultset = mysqli_query($con, $sql_query);
    }
    return $resultset;
}

function deletEmp($con){
    $errors = 1;
    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        $query = "DELETE FROM employee WHERE EmpID = '{$id}' AND DepID = 1";
        $result_set = mysqli_query($con, $query);
        if ($result_set) {
            $errors = 0;               
        }

    }
    return $errors;
}





function loadEmployee($con){
    $developer = null;
    if(isset($_GET['id'])){
        $search = $_GET['id'];
        $sql_query = "SELECT * FROM employee WHERE EmpID = '{$search}' AND DepID = 1";
        $resultset = mysqli_query($con, $sql_query);
        $developer = mysqli_fetch_assoc($resultset);
    }
    return $developer;
}



function loadRates($con, $id, $dep){
    $developer = null;
    $sql_query = "SELECT * FROM rates WHERE ID = $id AND DepID = $dep";
    $resultset = mysqli_query($con, $sql_query);
    $developer = mysqli_fetch_assoc($resultset);
    
    return $developer;
}

function editRates($con){
    $errors = -1;
    if (isset($_POST['submit'])){
        if(isset($_POST['clean']) && $_POST['clean'] != ""){
            $query = "UPDATE rates SET Rate = '{$_POST['clean']}' WHERE ID = 13 AND DepID = 2";
            $result_set = mysqli_query($con, $query);
            if ($result_set)             
                $errors = 0;
        }
        else{
            $data = array(
                array(2, $_POST['conB']),
                array(1, $_POST['conH']),
                array(8, $_POST['etf']),
                array(9, $_POST['epfC']),
                array(10, $_POST['epfE']),
                array(3, $_POST['u1-15']),
                array(4, $_POST['u15-25']),
                array(5, $_POST['u25-35']),
                array(6, $_POST['u35']),
                array(7, $_POST['uB'])
            );
            
            for($row = 0; $row < 10; $row++){
                if($errors <= 0){
                    $query = "UPDATE rates SET Rate = '{$data[$row][1]}' WHERE ID = '{$data[$row][0]}' AND DepID = 1";
                    $result_set = mysqli_query($con, $query);
                    if ($result_set)             
                        $errors = 0;

                    else
                    $errors = 1;
            
                }
            }
        } 
    }
    return $errors;
}



function editEmployee($con){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $empID = $_POST['empID'];
        $empFname = $_POST['fName'];
        $empLname = $_POST['lName'];
        $empNIC = $_POST['empNIC'];
        $empCont = $_POST['empCont'];
        $empAddress = $_POST['empAddress'];
        $bank = $_POST['bank'];
        $bankAcc = $_POST['bankAcc'];
        $role = $_POST['role'];
        $division = $_POST['division1'];
        $salary = $_POST['salary'];
        $memberDate = $_POST['memberDate'];

        $query = "UPDATE employee SET EmpID = '{$empID}', Name = '{$empFname}', lName = '{$empLname}', NIC = '{$empNIC}', Address = '{$empAddress}', Contact = '{$empCont}', Bank = '{$bank}', AccNO = '{$bankAcc}', JoinedDate = '{$memberDate}', Role = '{$role}', Division = '{$division}', Salary = '{$salary}', DepID = '1' WHERE EmpID = '{$empID}' AND DepID = 1";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            echo "<script> alert('Successfuly Updated.!'); window.location.href = 'employee.php';</script>";
        }
        else{
            echo "<script> alert('Not Updated.! Please try again.')</script>";
        }
    }    
    return $errors;                
}



function noPay($con, $loggedDet){
    $error = -1;
    if (isset($_POST['submit'])){
        
        $empID = $_POST['id'];
        $status = $_POST['des'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $days = $_POST['days'];

        $query = "INSERT INTO nopay (EmpID, Status, FromD, ToD, Count, DoneBy, DepID) VALUES ('{$empID}', '{$status}', '{$from}', '{$to}', '{$days}', '{$loggedDet}', 1)";
        echo $query;
        $result_set = mysqli_query($con, $query);
        if($result_set){
            $error = 0;
        }
        else{
            $error = 1;
        }
    }
    return $error;
}

function cPay($con, $loggedDet){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $AI = autoIncrement($con, 'ID', 'customerledger', 1);
    $errors = -1;
    if (isset($_POST['submit'])){
        
        $cusID = $_POST['accNO'];
        $ammount = $_POST['ammount'];

        $query = "INSERT INTO customerledger (ID, CusID, Status, Amount, DoneBy, DepID) VALUES ('{$AI}', '{$cusID}', 'Bill Payment', 'CR', '{$ammount}', '{$loggedDet}', 1)";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $query2 = "INSERT INTO bankledger (PayID, Des, Status, Amount, Date, DepID) VALUES ('CP-{$AI}', '{$cusID} Customer bill payment', 'CR', '{$ammount}', '{$today}', 1)";
            $result_set2 = mysqli_query($con, $query2);
            if ($result_set2) {
                $errors = 0;
            }
            else{
                $errors = 1;
                $query3 = "DELETE FROM customerledger WHERE ID = {$AI}";
                mysqli_query($con, $query3);
            }              
        }
        else{
            $errors = 1;
        }
    }
    if (isset($_POST['delete'])){
        $id = $_POST['delete'];
        $query = "UPDATE customerledger SET Cancel = 'Canceled', CanceledBy = '{$loggedDet}' WHERE ID = '{$id}' AND DepID = 1";
        $res = mysqli_query($con, $query);
        if ($res) {
            $query2 = "DELETE FROM bankledger WHERE PayID = 'CP-{$id}'";
            $result_set = mysqli_query($con, $query2);
            if ($result_set) {
                echo "<script> alert('Successfuly Canceled.!');</script>";
            }
        }
    }
    return $errors;
}

function sPay($con){
    $res = NULL;

    if(isset($_GET['search'])){
        $res[0] = $from = $_GET['from'];
        $res[1] = $to = $_GET['to'];
        $query = "SELECT * FROM employee a WHERE NOT EXISTS (SELECT EmpID FROM salary b WHERE a.EmpID = b.EmpID AND b.PaidBy != '' AND b.DepID = 1 AND DATE(b.Date) BETWEEN '$from' AND '$to' ) AND a.DepID = 1;";
        $res[2] = mysqli_query($con, $query);

    }

    return $res;
}

function sPayDet($con, $loggedDet){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $res = NULL;

    if(isset($_POST['submit'])){
        $from = $_POST['from'];
        $to = $_POST['to'];
        $select = $_POST['select'];
        $noPayValue = 0.0;
        $date = date('Y-m', strtotime($from));
        $date = "$date-20";
        $subTotal = 0;
        if($select != NULL || $select != ''){
            for($i=0; $i<count($select); $i++){

                $query = "SELECT ID FROM salary WHERE EmpID = '$select[$i]' AND DATE(Date) BETWEEN '$from' AND '$to' AND DepID = 1;";
                $res1 = mysqli_query($con, $query);
                $transaction = mysqli_fetch_assoc($res1);

                $empDet = getEmp($con, $select[$i], 1);
                $etfRate = getRates($con, 8);
                $epfcRate = getRates($con, 9);
                $epfeRate = getRates($con, 10);
                $noPayCount = getNopayCount($con, $select[$i], $from, $to, 1);
                $salaryUnit = 1*$empDet['Salary']/30;

                $noPayValue = 1*$noPayCount*$salaryUnit;
                $etf = number_format(1*$empDet['Salary']*$etfRate['Rate']/100, 2, ".", "");
                $epfc = number_format(1*$empDet['Salary']*$epfcRate['Rate']/100, 2, ".", "");
                $epfe= number_format(1*$empDet['Salary']*$epfeRate['Rate']/100, 2, ".", "");
                $salary = number_format(1*$empDet['Salary'] - $noPayValue - $epfe, 2, ".", "");
                $totalPayble = number_format(1*$empDet['Salary'] + $epfc + $etf - $noPayValue, 2, ".", "");
                $subTotal = $subTotal + $totalPayble;

                if($transaction['ID'] == NULL || $transaction['ID'] == ''){
                    // echo $select[$i];
                    $AI = autoIncrement($con, 'ID', 'salary', 1);                    
                    $query1 = "INSERT INTO salary (ID, EmpID, ETF, EPFC, EPFE, Leaves, Salary, TotalSalary, Date, DepID) VALUES ('{$AI}', '{$select[$i]}', '{$etf}', '{$epfc}', '{$epfe}', '{$noPayValue}', '{$salary}', '{$totalPayble}', '{$date}', 1)";
                    // echo $query1;
                    mysqli_query($con, $query1);
                    $tempArr = [$AI, $select[$i], $etf, $epfc, $epfe, $noPayValue, $salary, $totalPayble];
                    $res[0][$i] = $tempArr;
                }
                else{
                    $query1 = "UPDATE salary SET ETF = '{$etf}', EPFC = '{$epfc}', EPFE = '{$epfe}', Leaves = '{$noPayValue}', Salary = '{$salary}', TotalSalary = '{$totalPayble}', Date = '{$date}' WHERE ID = '{$transaction['ID']}' AND DepID = 1;";
                    mysqli_query($con, $query1);
                    $tempArr = [$transaction['ID'], $select[$i], $etf, $epfc, $epfe, $noPayValue, $salary, $totalPayble];
                    $res[0][$i] = $tempArr;
                }
            }
        }
        $res[1] = number_format($subTotal, 2, ".", "");
    }
    if(isset($_POST['pay'])){
        $arr = $_POST['arr'];
        $sal = $_POST['sal'];
        $id = $_POST['EmpID'];
        $name = $_POST['Name'];
        $query = "";
        if($arr != NULL || $arr != ''){
            $total = 0;
            $detail = "";
            $detailL = "";
            $error = 0;
            for($i=0; $i<count($arr); $i++){
                $query = "UPDATE salary SET PaidDate = '{$today}', PaidBy = '{$loggedDet}' WHERE ID = '{$arr[$i]}' AND DepID = 1;";
                $result = mysqli_query($con, $query);

                if($result){
                    $total = $total + $sal[$i];
                    $detail = "$detail, $id[$i]-$name[$i] ";
                    $detailL = "$detailL, $id[$i] ";
                }
                else{
                    $error = 1;
                }
            }
            
            itarativeLedger($con, $detailL, $total, $today);
            if($error == 0){
                echo "<script> alert('Rs. $total Paid Successfuly.!'); window.location.href = 'sPay.php';</script>";
            }
            else{
                echo "<script> alert('Error.! \n Rs. $total Paid for following employees.\n $detail'); window.location.href = 'sPay.php';</script>";
            }
        }
    }

    return $res;
}

function cBill($con, $loggedDet){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $AI = autoIncrement($con, 'ID', 'customerledger', 1);
    $errors = -1;
    if (isset($_POST['submit'])){
        
        $billID = $_POST['billID'];
        $cusID = $_POST['accNO'];
        $readValue = $_POST['ReadValue'];
        $units = $_POST['units'];
        $ammount = $_POST['ammount'];
        $totalStatus = $_POST['totalStatus'];
        $total = $_POST['total'];
        $other = 0;
        if($_POST['other'] != ""){
            $other = $_POST['other'];
        }

        $query = "INSERT INTO customerledger (ID, CusID, Des, Status, Amount, DoneBy, DepID) VALUES ('{$AI}', '{$cusID}', 'Bill-{$billID}', 'DR', '{$ammount}', '{$loggedDet}', 1)";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $query2 = "UPDATE bill SET ReadValue = '{$readValue}', Units = '{$units}', Other = '{$other}', Amount = '{$ammount}', TotalStatus = '{$totalStatus}', Total = '{$total}', CheckedBy = '{$loggedDet}', CheckedDate = '{$today}' WHERE BillID = '{$billID}' AND DepID = 1";
            $result_set2 = mysqli_query($con, $query2);

            if ($result_set2) {
                $query3 = "UPDATE customer SET MeterValue = '{$readValue}' WHERE CusID = '{$cusID}' AND DepID = 1";
                $result_set3 = mysqli_query($con, $query3);

                if ($result_set3) {
                    $errors = 0;
                }
                else{
                    $errors = 1;
                    $query5 = "UPDATE bill SET ReadValue = NULL, Units = NULL, Other = NULL, Amount = NULL, TotalStatus = '', Total = NULL, CheckedBy = NULL, CheckedDate = NULL WHERE BillID = '{$billID}' AND DepID = 1";
                    mysqli_query($con, $query5);
                    $query6 = "DELETE FROM customerledger WHERE ID = {$AI}";
                    mysqli_query($con, $query6);
                }
            }
            else{
                $errors = 1;
                $query7 = "DELETE FROM customerledger WHERE ID = {$AI}";
                mysqli_query($con, $query7);
            }              
        }
        else{
            $errors = 1;
        }
    }

    if($errors == 1)
        echo "<script> alert('Recode Not Saved.! Please check and try again.');</script>";
    
    return $errors;
}

function loadCPay($con){
    $errors = 0;
    if (isset($_GET['id'])){
        
        $id = $_GET['id'];
        $query = "SELECT * FROM customerledger WHERE ID = '$id'";
        $res = mysqli_query($con, $query);
        $transaction1 = mysqli_fetch_assoc($res);
        $query2 = "SELECT * FROM customer WHERE CusID = '$transaction1[CusID]'";
        $res2 = mysqli_query($con, $query2);
        $transaction2 = mysqli_fetch_assoc($res2);
        $transaction = [$transaction1,$transaction2];
    }    
    return $transaction;                
}

function loadCBill($con){
    $errors = 0;
    if (isset($_GET['id'])){
        
        $id = $_GET['id'];
        $query = "SELECT * FROM customerledger WHERE ID = '$id'";
        $res = mysqli_query($con, $query);
        $data = mysqli_fetch_assoc($res);
        $billid = explode("-",$data['Des']);
        $query2 = "SELECT * FROM bill WHERE BillID = '$billid[1]'";
        $res2 = mysqli_query($con, $query2);
        $transaction1 = mysqli_fetch_assoc($res2);
        $transaction = [$transaction1, $id];
    }    
    return $transaction;                
}

function editCPay($con, $loggedDet){
    $errors = 0;
    if (isset($_POST['submit'])){
        
        $id = $_POST['id'];
        $accNO = $_POST['accNO'];
        $ammount = $_POST['ammount'];

        $query = "UPDATE customerledger SET CusID = '{$accNO}', Amount = '{$ammount}', EditedBy = '{$loggedDet}' WHERE ID = '{$id}' AND DepID = 1";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $query2 = "UPDATE bankledger SET Des = '{$accNO} Customer bill payment', Amount = '{$ammount}' WHERE PayID = 'CP-{$id}' AND DepID = 1";
            $result_set2 = mysqli_query($con, $query2);
            
            if ($result_set2) 
                echo "<script> alert('Successfuly Updated.!'); window.location.href = 'cPay.php';</script>";
            //header('Location: customer.php');
        }
        else{
            echo "<script> alert('Not Updated.! Please try again.');</script>";
        }
    }    
           
}

function editCBill($con, $loggedDet){
    date_default_timezone_set("Asia/Colombo");
    $today = date("Y-m-d");
    $AI = autoIncrement($con, 'ID', 'customerledger', 1);
    $errors = -1;
    if (isset($_POST['submit'])){
        
        $id = $_POST['ID'];
        $billID = $_POST['billID'];
        $cusID = $_POST['accNO'];
        $readValue = $_POST['ReadValue'];
        $units = $_POST['units'];
        $ammount = $_POST['ammount'];
        $totalStatus = $_POST['totalStatus'];
        $total = $_POST['total'];
        $other = $_POST['other'];

        $query = "UPDATE customerledger SET CusID = '{$cusID}', Des = 'Bill-{$billID}', Amount = '{$ammount}', DoneBy = '{$loggedDet}' WHERE ID = '{$id}' AND DepID = 1";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $query2 = "UPDATE bill SET ReadValue = '{$readValue}', Units = '{$units}', Other = '{$other}', Amount = '{$ammount}', TotalStatus = '{$totalStatus}', Total = '{$total}', CheckedBy = '{$loggedDet}', CheckedDate = '{$today}' WHERE BillID = '{$billID}' AND DepID = 1";
            $result_set2 = mysqli_query($con, $query2);
            if ($result_set2) {
                $query3 = "UPDATE customer SET MeterValue = '{$readValue}' WHERE CusID = '{$cusID}' AND DepID = 1";
                $result_set3 = mysqli_query($con, $query3);
                if ($result_set3) {
                    $errors = 0;
                    echo "<script> alert('Successfuly Updated.!'); window.location.href = 'cBill.php';</script>";

                }
                else{
                    $errors = 1;                    
                }
            }
            else{
                $errors = 1;
            }
        }
        else{
            $errors = 1;
        }
    }
    if($errors == 1)
        header("Location: cBill.php?id='{$id}'");
    
    return $errors;   
           
}

function oCost($con, $loggedDet){
    $AI = autoIncrement($con, 'ID', 'othercost', 1);
    $errors = -1;
    if (isset($_POST['submit'])){
        
        $bill = $_POST['bill'];
        $desc = $_POST['desc'];
        $ammount = $_POST['ammount'];
        $date = $_POST['date'];

        $query = "INSERT INTO othercost (ID, BillID, Des, Total, Date, DoneBy, DepID) VALUES ({$AI}, '{$bill}', '{$desc}', '{$ammount}', '{$date}', '{$loggedDet}', 1)";
        $result_set = mysqli_query($con, $query);
        
        if ($result_set) {
            $query2 = "INSERT INTO bankledger (PayID, Des, Status, Amount, Date, DepID) VALUES ('OC-{$AI}', '{$desc}', 'DR', '{$ammount}', '{$date}', 1)";
            $result_set2 = mysqli_query($con, $query2);
            if ($result_set2) {
                $errors = 0;
            }
            else{
                $errors = 1;
                $query3 = "DELETE FROM othercost WHERE ID = {$AI}";
                mysqli_query($con, $query3);
            }              
        }
        else{
            $errors = 1;
        }
    }
    return $errors;
}

function bills($con){
    date_default_timezone_set("Asia/Colombo");
    $year = date("Y");
    $today = date("m");
    $sql_query = "SELECT * FROM bill WHERE DepID = 1";

    $query = "SELECT * FROM bill WHERE DepID = 1 ORDER BY DATE(Date) DESC LIMIT 1";
    $res = mysqli_query($con, $query);

    $query2 = "SELECT COUNT(CusID) AS count FROM customer a WHERE NOT EXISTS (SELECT * FROM bill b WHERE b.CusID = a.CusID AND Month = '{$today}' AND DepID = 1) AND a.DepID = 1;";
    $res2 = mysqli_query($con, $query2);
    
    $query3 = "SELECT COUNT(BillID) AS count FROM bill WHERE PrintedBy = '' AND Reader != '0' AND DepID = 1;";
    $res3 = mysqli_query($con, $query3);
    
    $query4 = "SELECT COUNT(BillID) AS count FROM bill WHERE Reader = '0' AND DepID = 1;";
    $res4 = mysqli_query($con, $query4);

    if(isset($_GET['search'])){
        $id = $_GET['search'];
        $month = $_GET['month'];
        $print = $_GET['print'];
        $readerst = $_GET['readerst'];
        $checkedst = $_GET['checkedst'];

        if($_GET['search']!=""){
            $sql_query = "{$sql_query} AND CusID = '{$id}'";
        }

        if($_GET['month']!=""){
            $sql_query = "{$sql_query} AND MONTH(Date) = $month AND YEAR(Date) = $year";
        }

        if($_GET['print']!=""){
            if($print == 0){
                $sql_query = "{$sql_query} AND PrintedBy = ''";
            }
            if($print == 1){
                $sql_query = "{$sql_query} AND PrintedBy != ''";
            }
        }
        if($_GET['checkedst']!=""){
            if($checkedst == 0){
                $sql_query = "{$sql_query} AND CheckedBy = ''";
            }
            if($checkedst == 1){
                $sql_query = "{$sql_query} AND CheckedBy != ''";
            }
        }
        if($_GET['readerst']!=""){
            if($readerst == 0){
                $sql_query = "{$sql_query} AND Reader = 0";
            }
            if($readerst == 1){
                $sql_query = "{$sql_query} AND Reader != 0";
            }
        }
    }
    else
        $sql_query = "{$sql_query} AND MONTH(Date) = $today";
    
    $resultset[0] = mysqli_query($con, $sql_query);
    $resultset[1] =mysqli_fetch_assoc($res);
    $resultset[2] =mysqli_fetch_assoc($res2);
    $resultset[3] =mysqli_fetch_assoc($res3);
    $resultset[4] =mysqli_fetch_assoc($res4);
    
    return $resultset;
}

function assignReaders($con){
    date_default_timezone_set("Asia/Colombo");
    $year = date("Y");
    $month = date("m");

    if(isset($_POST['submit'])){
        $area = $_POST['area'];
        $reader = $_POST['reader'];

        $query = "UPDATE bill JOIN customer ON bill.CusID = customer.CusID SET bill.Reader = '{$reader}' WHERE YEAR(bill.Date) = '{$year}' AND MONTH(bill.Date) = '{$month}' AND Division = '{$area}' AND bill.PrintedBy = '' AND bill.DepID = 1 AND customer.DepID = 1";
        $res = mysqli_query($con, $query);
        if($res)
            echo "<script> alert('Successfuly Assigned.!');</script>";
            
        else
            echo "<script> alert('Not Assigned Successfuly.! Please try again.');</script>";
    }
    
    $res = array();
    $sql_query = "SELECT * FROM divisions WHERE DepID = 1";
    $res[0] = mysqli_query($con, $sql_query);
    $sql_query1 = "SELECT * FROM divisions WHERE DepID = 1";
    $res[2] = mysqli_query($con, $sql_query1);
    $sql_query2 = "SELECT * FROM employee WHERE Role = 'Biller' AND DepID = 1";
    $res[1] = mysqli_query($con, $sql_query2);

    return $res;
}

function getBillByArea($con, $area){
    date_default_timezone_set("Asia/Colombo");
    $year = date("Y");
    $month = date("m");
    
    $result = array();
    $query = "SELECT * FROM bill JOIN customer ON bill.CusID = customer.CusID WHERE Division = '{$area}' AND Reader != 0 AND YEAR(Date) = '{$year}' AND MONTH(Date) = '{$month}' AND bill.DepID = 1 AND customer.DepID = 1 LIMIT 1";
    $res1 = mysqli_query($con, $query);
    $result[0] =mysqli_fetch_assoc($res1);
    $sql_query = "SELECT COUNT(BillID) AS Completed FROM bill JOIN customer ON bill.CusID = customer.CusID WHERE Division = $area AND Reader != 0 AND YEAR(Date) = '{$year}' AND MONTH(Date) = '{$month}' AND bill.DepID = 1 AND customer.DepID = 1";
    $res2 = mysqli_query($con, $sql_query);
    $result[1] =mysqli_fetch_assoc($res2);
    $sql_query = "SELECT COUNT(BillID) AS NotCompleted FROM bill JOIN customer ON bill.CusID = customer.CusID WHERE Division = $area AND Reader = 0 AND YEAR(Date) = '{$year}' AND MONTH(Date) = '{$month}' AND bill.DepID = 1 AND customer.DepID = 1";
    $res2 = mysqli_query($con, $sql_query);
    $result[2] =mysqli_fetch_assoc($res2);

    return $result;
}

function getReaderName($con, $id){
    $sql_query = "SELECT * FROM employee WHERE EmpID = $id AND DepID = 1";
    $resultset = mysqli_query($con, $sql_query);
    $result =mysqli_fetch_assoc($resultset);

    return $result['Name'];
}

function getRates($con, $id){
    $sql_query = "SELECT * FROM rates WHERE ID = $id AND DepID = 1";
    $resultset = mysqli_query($con, $sql_query);
    $result =mysqli_fetch_assoc($resultset);

    return $result;
}

function getDivisions($con, $dep){
    $sql_query = "SELECT * FROM divisions WHERE DepID = $dep;";
    $resultset = mysqli_query($con, $sql_query);

    return $resultset;
}

function getEmp($con, $id, $dep){
    $sql_query = "SELECT * FROM employee WHERE EmpID = '{$id}' AND DepID = $dep LIMIT 1;";
    $resultset = mysqli_query($con, $sql_query);
    $developer = mysqli_fetch_assoc($resultset);

    return $developer;
}

function getNopayCount($con, $id, $from, $to, $dep){
    $sql_query = "SELECT COUNT(Count) AS c FROM nopay WHERE EmpID = '{$id}' AND DepID = $dep AND DATE(From) BETWEEN '{$from}' AND '{$to}';";
    $resultset = mysqli_query($con, $sql_query);
    if($resultset){
        $developer = mysqli_fetch_assoc($resultset);
        return $developer['c'];
    }
}

function getCusData($con, $cusID){
    $query = "SELECT * FROM customer WHERE CusID = '{$cusID}' AND DepID = 1";
    $resultset = mysqli_query($con, $query);
    $developer = mysqli_fetch_assoc($resultset);

    return $developer;
}

function getBillData($con, $id, $cusID, $year, $month, $print){
    if($print == 0){
        $query = "SELECT * FROM bill WHERE DepID = 1";
    }
    if($print == 1){
        $query = "SELECT * FROM bill WHERE DepID = 1 AND Reader != 0";
    }
    if($id != ""){
        $query = "$query AND BillID = '{$id}'";
    }
    if($cusID != ""){
        $query = "$query AND CusID = '{$cusID}'";
    }
    if($month != "" && $year != ""){
        $query = "$query AND YEAR(Date) = '{$year}' AND MONTH(Date) = '{$month}'";
    }
    $resultset = mysqli_query($con, $query);
    if($resultset){
        return $resultset;
    }
}

function itarativeLedger($con, $detailL, $total, $today){
    $detailL = "$detailL Salary Payment.";
    $query1 = "INSERT INTO bankledger (Des, Status, Amount, Date, DepID) VALUES ('{$detailL}', 'DR', '{$total}', '{$today}', 1)";
    $result1 = mysqli_query($con, $query1);

    if(!$result1){
        itarativeLedger($con, $detailL, $total, $today);
    }
}

function calCustomerBal($con){
    $cr = 0;
    $dr = 0;
    
    if(isset($_GET['search'])){
        $cusID = $_GET['id'];
        $sql_query1 = "";
        $sql_query2 = "";        

        if($cusID != ''){
            $sql_query1 = "SELECT SUM(Amount) AS CR FROM customerledger WHERE CusID = '{$cusID}' AND Status = 'CR' AND Cancel = '' AND DepID = 1";
            $result1 = mysqli_query($con, $sql_query1);
            $developer = mysqli_fetch_assoc($result1);
            $cr = $developer['CR'];

            $sql_query2 = "SELECT SUM(Amount) AS DR FROM customerledger WHERE CusID = '{$cusID}' AND Status = 'DR' AND Cancel = '' AND DepID = 1";
            $result2 = mysqli_query($con, $sql_query2);
            $developer = mysqli_fetch_assoc($result2);
            $dr = $developer['DR'];
        }
    }

    return ($dr - $cr);
}

function autoIncrement($con, $col, $table, $dep){
    $AI = 1;
    $sql_query = "SELECT * FROM $table WHERE DepID = $dep ORDER BY $col DESC LIMIT 1";
    $resultset = mysqli_query($con, $sql_query);
    $developer = mysqli_fetch_assoc($resultset);
    if(isset($developer[$col])){
        $AI = $developer[$col] + 1;
    }
    return $AI;
}

function addRec($con, $loggedDet){
    date_default_timezone_set("Asia/Colombo");
    $date = date("Y-m-d");
    $errors = -1;

    if (isset($_POST['submit'])){
        
        $desc = $_POST['desc'];
        $ammount = $_POST['ammount'];
        if($_POST['date'] != ""){
            $date = $_POST['date'];
        }

        $query = "INSERT INTO cleaning (Liters, Amount, Date, User, DepID) VALUES ('{$desc}', '{$ammount}', '{$date}', '{$loggedDet}', 2)";
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

function clean($con){
    date_default_timezone_set("Asia/Colombo");
    $month = date("m");

    $query = "SELECT * FROM cleaning WHERE DepID = 2";
    $query2 = "SELECT SUM(Amount) AS Amount FROM cleaning WHERE DepID = 2";
    if (isset($_GET['fDate']) && isset($_GET['tDate'])){
        $from =$_GET['fDate'];
        $to = $_GET['tDate'];
        $query = "$query AND DATE(Date) BETWEEN '{$from}' AND '{$to}'";
        $query2 = "$query2 AND DATE(Date) BETWEEN '{$from}' AND '{$to}'";
    }
    else if (isset($_POST['fDate']) && isset($_POST['tDate']) && $_POST['fDate'] != "" && $_POST['tDate'] != ""){
        $from =$_POST['fDate'];
        $to = $_POST['tDate'];
        $query = "$query AND DATE(Date) BETWEEN '{$from}' AND '{$to}'";
        $query2 = "$query2 AND DATE(Date) BETWEEN '{$from}' AND '{$to}'";
    }
    else{
        $query = "$query AND MONTH(Date) = '{$month}'";
        $query2 = "$query2 AND MONTH(Date) = '{$month}'";
    }

    $result_set = mysqli_query($con, $query);
    $result_set2 = mysqli_query($con, $query2);
    $developer = mysqli_fetch_assoc($result_set2);

    if ($result_set) {
        return [$result_set, $developer];
    }
}

function records($con){
    $resultset = null;
    $sql_query = "SELECT * FROM cleaning WHERE DepID = 2";

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = $_GET['search'];
        $sql_query = "$sql_query AND id = '{$search}'";
    }
    if(isset($_GET['date']) && $_GET['date'] != ""){
        $date = $_GET['date'];
        $sql_query = "$sql_query AND DATE(Date) = '{$date}' ORDER BY Date DESC";
    }
    else{
        $sql_query = "$sql_query ORDER BY Date DESC";
    }

    $resultset = mysqli_query($con, $sql_query);

    return $resultset;
}

function deletRec($con){
    $errors = 1;
    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        $query = "DELETE FROM cleaning WHERE id = '{$id}' AND DepID = 2";
        $result_set = mysqli_query($con, $query);
        if ($result_set) {
            $errors = 0;               
        }

    }
    return $errors;
}

function editRec($con, $loggedDet){
    $errors = -1;
    if(isset($_GET['id']) && $_GET['id'] != ""){
        $id = $_GET['id'];
        $query = "SELECT * FROM cleaning WHERE id = '{$id}' AND DepID = 2";
        $result_set = mysqli_query($con, $query);
        $developer = mysqli_fetch_assoc($result_set);
    }
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $desc = $_POST['desc'];
        $ammount = $_POST['ammount'];
        $date = $_POST['date'];

        $query = "UPDATE cleaning SET Liters = '{$desc}', Amount = '{$ammount}', Date = '{$date}', Edited = '{$loggedDet}' WHERE id = '{$id}' AND DepID = 2";
        $result_set = mysqli_query($con, $query);
        if ($result_set) {
            $errors = 0;               
        }
        else{
            $errors = 1;               
        }
    }

    return [$developer, $errors];
}
?>