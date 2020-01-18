<?php
session_start();
try {
        require ('../core/db.php');

        $db = new db();
        $output = '';
        $query = '';
        $result = [];
        if(isset($_POST["query"]) && (strlen($_POST["query"]) >= 3))
            {
            $search = htmlspecialchars($_POST["query"]);
            $query = "
            SELECT * FROM patients 
            WHERE jmbg LIKE '" . $search ."%'
            OR name LIKE '" . $search ."%'
            OR surname LIKE '" . $search ."%'
            OR LBO LIKE '" . $search ."%'
            ";
            };

            

    
    if ($query != '') {
        $result = $db->query($query)->fetchAll();
    } 
    if(count($result) > 0) {
    $output .= '
    <div class="table-responsive">
    <table class="table table bordered">
        <tr>
        <th></th>
        <th>Pacijent</th>
        <th>Datum rođenja</th>
        <th>Pol</th>
        <th>JMBG</th>
        <th>LBO</th>
        <th>Adresa</th>
        <th>Telefon</th>
        <th>Tip osiguranja</th>
        <th>email</th>
        </tr>
    ';
    foreach($result as $row)
    {
    $output .= '
    <tr>
    <td>
    <input class="btn btn-primary pickPatient" id=' . $row['patient_id'] . ' type="button" value="Izaberi">
</td>
        <td>'.$row["surname"] . " " .$row["name"].'</td>
        <td>'.$row["date_of_birth"].'</td>
        <td>'.$row["gender"].'</td>
        <td>'.$row["jmbg"].'</td>
        <td>'.$row["LBO"].'</td>
        <td>'.$row["address"].'</td>
        <td>'.$row["phone"].'</td>
        <td>'.$row["insurance_type"].'</td>
        <td>'.$row["email"].'</td>


    </tr>
    ';
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
            echo 'Izaberite novog pacijenta';
        }
    }
    $db->close();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
    ?>