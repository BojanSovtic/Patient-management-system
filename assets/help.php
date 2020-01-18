<?php

    require('core/db.php');
    $db = new db();
    $username = 'Bojan';
    $string = 'Outlaws8';
    $password = password_hash($string, PASSWORD_DEFAULT);
    $email = 'bojansovtic92@gmail.com';
    $forename = 'Bojan';
    $surename = 'Sovtić';
    $address = 'Vrbnička 28';
    $phone = '0642574803';
    $salary = '1000000';
    $role_id = '7';
    $db->query('INSERT INTO users (username, password, email, forename, surname, address, phone, salary, role_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', $username, $password, $email, $forename, $surename, $address, $phone, $salary, $role_id);


?>