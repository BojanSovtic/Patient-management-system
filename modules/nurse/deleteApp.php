<?php
     session_start();

     try {
        require ('../../core/db.php');
     
             $db = new db();

             print_r($_POST);
             $id = $_POST['id'];
     
             $db->query('DELETE FROM appointments WHERE appointment_id = ?', $id);
     
             $db->close();
     
     }
     catch (Exception $ex) {
         echo $ex->getMessage();
     }

?>