<?php
try {
        require ('../../core/db.php');

        $db = new db();
        $output = '';
        if(isset($_POST["query"]) && (strlen($_POST["query"]) >= 3))
            {
            $search = htmlspecialchars($_POST["query"]);
            $query = "
            SELECT * FROM users 
            WHERE email LIKE '" . $search ."%'
            AND is_active = 1";
            }
    else{
    $query = "
    SELECT * FROM users
    ";
    }
    
    $result = $db->query($query)->fetchAll();
    if(count($result) > 0) {
    $output .= '
    <div class="table-responsive">
    <table class="table table bordered">
        <tr>
        <th>Username</th>
        <th>Ime</th>
        <th>Prezime</th>
        <th>Email</th>
        </tr>
    ';
    foreach($result as $row)
    {
    $output .= '
    <tr>
        <td>'.$row["username"].'</td>
        <td>'.$row["forename"].'</td>
        <td>'.$row["surname"].'</td>
        <td id="forDelete">'.$row["email"].'</td>
    </tr>
    ';
    }
    if (count($result) == 1) {
        $output .= '<input class="btn btn-primary delete" type="button" value="Obriši korisnika"><br>';
    }
    echo $output;

    }
    else
    {
    echo 'Nema podataka';
    }
    $db->close();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
    ?>