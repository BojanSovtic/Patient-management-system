<?php
try {
        require ('../../core/db.php');

        $db = new db();
        $output = '';
        $query = '';
        $result = [];
        if(isset($_POST["query"]))
            {
            $search = htmlspecialchars($_POST["query"]);
            $query = "
            SELECT * FROM diagnoses 
            WHERE code LIKE '" . $search . "%'
            OR description LIKE '" . $search . "%'
            LIMIT 5";
            };

            

    
    if ($query != '') {
        $result = $db->query($query)->fetchAll();
    } 
    if(count($result) > 0) {
    $output = '';
    
    foreach($result as $row)
    {
    $output .= $row['code'] . "  " . $row['description'] . "  " . $row['latin'] . "
    <input class=\"btn btn-primary btn-sm pickDiagnose\" id=" . $row['code'] . ' type="button" value="Izaberi"><br>'; 
    
    }
    if ($output != '') {
    echo $output;
    }
    }
    else
    {
        if (isset($_SESSION['patient']) && $_SESSION['patient'] == 0) {
            echo 'Pacijent nije pronađen.';
        } else {
            echo 'Izaberite dijagnozu';
        }
    }
    $db->close();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}