<?php
//Search Customers, Employees and Bills API
include_once('inc/connection.php');
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        
        if(isset($_GET['time'])){
            $time = $_GET['time'];
            $time = str_replace("T"," ", $time);
            $timestamp = strtotime($time);
            $time1 = $timestamp - (30 * 60);
            $time2 = $timestamp + (30 * 60);
            $datetime1 = date("Y-m-d H:i:s", $time1);
            $datetime2 = date("Y-m-d H:i:s", $time2);
            $query = "SELECT COUNT(id) as count FROM appointment WHERE date BETWEEN '{$datetime1}' AND '{$datetime2}' AND cancel = 0;";
            $result_set = mysqli_query($con, $query);
        } else {
            $id = $data->id;

            if($id != ''){
                $query = "SELECT * FROM patient WHERE id = '{$id}'";
                $result_set = mysqli_query($con, $query);
            }
        }
        $out = array();
        while($row =mysqli_fetch_assoc($result_set)) {
            $out[] = $row;
        }
        echo json_encode($out);
?>