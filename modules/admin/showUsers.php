<?php
try {
    require 'core/db.php';

    $db = new db();

    $sql = $db->query("SELECT username, password, forename, surname, email, address, phone, salary, name FROM users
        INNER JOIN roles on users.role_id = roles.role_id WHERE is_active = 1")->fetchAll();

    $num_of_pages = count($sql);
    $result_per_page = 10;

    if (!isset($_GET["page"])) {
        $page = 1;
    } else {
        $page = $_GET["page"];
    }

    $pages = ceil($num_of_pages / $result_per_page);
    $func = ($page - 1) * $result_per_page;

    $sql = $db->query('SELECT user_id, username, password, forename, surname, email, address, phone, salary, name FROM users
        INNER JOIN roles on users.role_id = roles.role_id WHERE is_active = 1 LIMIT ' . $func . ', 10')->fetchAll();

    $db->close();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>

<div class="container">

<div class="row row-my">
<?php
if ($_SESSION['role'] == 7) {
    echo '<div class="col-lg-3">

            <h1 class="my-4">Izaberite opciju</h1>
            <div class="list-group">

            <a class="nav-link" href="./index.php?modul=createUser"><button type="button" class= "btn-primary btn-sm">Kreiraj novog korisnika</button></a><br>
            <a class="nav-link" href="./index.php?modul=showUsers"><button type="button" class= "btn-primary btn-sm">Pogledaj korisnike</button></a><br>
            <a class="nav-link" href="./index.php?modul=deleteUser"><button type="button" class= "btn-primary btn-sm">Obriši korisnika</button></a><br>
            </div>

        </div>';
}
;
?>


        <div class="col-lg-9">
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Adresa</th>
                        <th>Telefon</th>
                        <th>Plata</th>
                        <th>Pozicija</th>
                        <th>Izmeni</th>
                    </tr>
                </thead>
                <tbody>
                <?php
foreach ($sql as $row) {
    $id = $row['user_id'];
    echo ' <tr>' .
        '<td>' . $row['username'] . '</td>' .
        '<td>' . $row['email'] . '</td>' .
        '<td>' . $row['forename'] . '</td>' .
        '<td>' . $row['surname'] . '</td>' .
        '<td>' . $row['address'] . '</td>' .
        '<td>' . $row['phone'] . '</td>' .
        '<td>' . $row['salary'] . '</td>' .
        '<td>' . $row['name'] . '</td>' .
        "<td><a class=\"nav-link\" href=\"./index.php?modul=editUser&id=$id\"><button type=\"button\" class= \"btn-primary btn-sm value=\"$id\">Izmeni</button></a></td>" .
        '</tr>';
}
;

?>
                </tbody>
            </table>

            <?php

echo "<p class='my-pagination'>";
for ($i = 1; $i <= $pages; $i++) {
    echo "<a "; 
    if (isset($_GET['page']) && $_GET['page'] == $i) {
        echo "class='currentPage'";
    }
    echo "href='index.php?modul=showUsers&page=" . $i . "'>" . $i . "</a></li>";
}
echo '</p>';

?>
        </div>


        <div class="row">


        </div>


    </div>


</div>


