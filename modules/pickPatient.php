<?php
session_start();
try {
        require ('../core/db.php');

        $db = new db();

        $id = $_POST['id'];
        $query = $db->query('SELECT * FROM patients WHERE patient_id = ?', $id)->fetchAll();

        $_SESSION['patient'] = $query[0];

        $db->close();

}
catch (Exception $ex) {
    echo $ex->getMessage();
}
    ?>