<?php

    try {
        require '../../core/db.php';

    $db = new db();
    
    $email = $_POST['email'];

    $db->query('UPDATE users SET is_active = 0 WHERE email = ?', $email);

    $db->close();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?>