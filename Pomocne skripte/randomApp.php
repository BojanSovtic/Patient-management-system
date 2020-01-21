<?php
    require 'core/db.php';

    $db = new db();

    $query = $db->query("SELECT patient_id FROM patients")->fetchAll();
    
    $pacijentiID = [];
    foreach ($query as $item) {
        $pacijentiID[] = $item['patient_id']; 
    }

    $query = $db->query("SELECT user_id FROM users WHERE role_id = 5")->fetchAll();
    
    $doktoriID = [];
    foreach ($query as $item) {
        $doktoriID[] = $item['user_id']; 
    }
    
    $n = 0;
    while($n != 10000) {
    $pacID = $pacijentiID[rand(0, count($pacijentiID) - 1)];
    // echo $pacID;

    $dokID = $doktoriID[rand(0, count($doktoriID) - 1)];
    // echo $dokID;


    $date = randomDate('1.1.2016', '1.12.2019');
    $hour = rand(7, 19);
    $minutes = ['00', '15', '30', '45'];
    $minut = $minutes[rand(0, 3)];

    $s = $date . ' ' . $hour . ':' . $minut . ':' . '00';
    // echo $s;

    $startTime = date('Y-m-d H:i:s', strtotime($s));
    // echo $startTime . "<br>";

    $endTime = new DateTime($s);
    $endTime->modify("+15 minutes");
    $endTime = $endTime->format('Y-m-d H:i:s');

    // echo $endTime;

    $status = 'finished';

    
    $db->query('INSERT INTO appointments (start_time, end_time, status, patient_id, user_id) 
    VALUES (?, ?, ?, ?, ?)', $startTime, $endTime, $status, $pacID, $dokID);
    
        $n++;
}

    $db->close();
    
    

function randomDate($startDate, $endDate) {
    $format = 'd-m-Y';

    $min = strtotime($startDate);
    $max = strtotime($endDate);

    $rand = random_int($min, $max);

    return date($format, $rand);
}
?>