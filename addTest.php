<?php
include_once('inc/connection.php');
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $pID = $data->pID;
        $doctorID = $data->doctorID;
        $test = $data->test;

        $query = "INSERT INTO test (patientID, doctorID, testName) VALUES ('{$pID}', '{$doctorID}', '{$test}')";
        $result_set = mysqli_query($con, $query);
        
        echo json_encode($result_set);
?>