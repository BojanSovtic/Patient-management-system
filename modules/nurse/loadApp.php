<?php
     session_start();

     try {
        require ('../../core/db.php');
     
             $db = new db();



             if (isset($_POST['doctor_id'])) {
                 $user_id = $_POST['doctor_id'];
             } else {
                $user_id = $_SESSION['doctor'];
             }

             $_SESSION['doctor'] = $user_id;
             
             $query = $db->query('SELECT * FROM appointments WHERE user_id = ?', $user_id)->fetchAll();

             $data = array();

             foreach($query as $row) {
                 
                 $query = $db->query("SELECT `name`, surname, jmbg FROM patients WHERE patient_id = ?", $row['patient_id'])->fetchArray();

                 $title = $query['name'] . " " . $query['surname'] . " " . $query['jmbg'];

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