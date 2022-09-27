<?php
include_once('inc/connection.php');
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $pID = $data->pID;
        $doctorID = $data->doctorID;
        $dis = $data->dis;

        $query = "INSERT INTO disease (patientID, doctorID, des) VALUES ('{$pID}', '{$doctorID}', '{$dis}')";
        $result_set = mysqli_query($con, $query);
        
        echo json_encode($result_set);
?>