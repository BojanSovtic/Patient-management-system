<?php
     session_start();

     try {
        require ('../../core/db.php');
     
             $db = new db();

             print_r($_POST);
             $start = $_POST['start'];
             $end = $_POST['end'];
             $pacijent = $_SESSION['patient']['patient_id'];
             $doktor = $_POST['doctor'];
     
             $db->query('INSERT INTO appointments (start_time, end_time, patient_id, user_id)
                        VALUES (?, ?, ?, ?)', $start, $end, $pacijent, $doktor);
     
             $db->close();
     
     }
     catch (Exception $ex) {
         echo $ex->getMessage();
     }
?>