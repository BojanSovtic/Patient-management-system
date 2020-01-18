<?php
session_start();
try {
    require '../../core/db.php';

    $db = new db();

    $appointment_id = $_POST['id'];

    $db->query('UPDATE appointments SET status = "canceled" WHERE appointment_id = ?', $appointment_id);
    $_SESSION['message'] = "Pregled otkazan!";

    $db->close();


} catch (Exception $ex) {
    echo $ex->getMessage();
}
