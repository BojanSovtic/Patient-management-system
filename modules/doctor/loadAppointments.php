<?php
     session_start();

     try {
        require ('../../core/db.php');
     
             $db = new db();

             $user_id = $_SESSION['id'];


             $_SESSION['doctor'] = $user_id;
             
             $query = $db->query('SELECT * FROM appointments WHERE user_id = ? and `status` = "pending"', $user_id)->fetchAll();

             $data = array();

             foreach($query as $row) {
                 
                $query = $db->query("SELECT `name` FROM patients WHERE patient_id = ?", $row['patient_id'])->fetchArray();

                 $title = $query['name'];

                 $data[] = array (
                 'id' => $row['appointment_id'],
                 'title' => $title,
                 'start'=> $row['start_time'],
                 'end' => $row['end_time']
                 );
             }

             echo json_encode($data);
     
             $db->close();
     
     }
     catch (Exception $ex) {
         echo $ex->getMessage();
     }
?>