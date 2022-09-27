<?php
include_once('inc/connection.php');
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $pID = $data->pID;
        $doctorID = $data->doctorID;
        $medi = $data->medi;

        $query = "INSERT INTO medicine (patientID, doctorID, medicines) VALUES ('{$pID}', '{$doctorID}', '{$medi}')";
        $result_set = mysqli_query($con, $query);
        
        echo json_encode($result_set);
?>