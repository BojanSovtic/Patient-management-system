<?php

    try {
        require './core/db.php';

    $db = new db();
    
    $user_id = $_GET['id'];

    $sql = $db->query('SELECT user_id, username, password, forename, surname, email, address, phone, salary FROM users
WHERE user_id = ?', $user_id)->fetchArray();

    $username = $sql['username'];
    $forename = $sql['forename'];
    $surname = $sql['surname'];
    $email = $sql['email'];
    $address = $sql['address'];
    $phone = $sql['phone'];
    $salary = $sql['salary'];

$greske = [];

// Username
if (isset($_POST['username']) && ($_POST['username'] != $username)) {
    $username = htmlspecialchars(trim($_POST['username']));
    if (checkUsername($username) !== '0') {
        $greske[] = checkUsername($username);
    }
    if (sizeof($greske) == 0) {
        $query = $db->query('UPDATE users SET username = ? WHERE user_id = ?', $username, $user_id);
        header("Refresh:0");
    }
}

/*
// Password
if (isset($_POST['password']) && ($_POST['password'] != $sql['password']) ) {
    $password = htmlspecialchars(trim($_POST['password']));
    if (checkPassword($password) !== '0') {
        $greske[] = checkPassword($password);
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
    if (sizeof($greske) == 0) {
        $query = $db->query('UPDATE users SET password = ? WHERE user_id = ?', $password, $user_id);
        header("Refresh:0");
    }
}
*/

// email
if (isset($_POST['email']) && ($_POST['email'] != $email)) {
    $email = htmlspecialchars(trim($_POST['email']));
    if (checkEmail($email) !== '0') {
        $greske[] = checkEmail($email);
    }
    if (sizeof($greske) == 0) {
        $query = $db->query('UPDATE users SET email = ? WHERE user_id = ?', $email, $user_id);
        header("Refresh:0");
    }
}



if (isset($_POST['forename']) && ($_POST['forename'] != $forename) ) {
    $forename = htmlspecialchars(trim($_POST['forename']));
       
    $query = $db->query('UPDATE users SET forename = ? WHERE user_id = ?', $forename, $user_id);
    header("Refresh:0");
    
}

if (isset($_POST['surname']) && ($_POST['surname'] != $surname)) {
    $surname = htmlspecialchars(trim($_POST['surname']));

    $query = $db->query('UPDATE users SET surname = ? WHERE user_id = ?', $surname, $user_id);
    header("Refresh:0");
}

if (isset($_POST['address']) && ($_POST['address'] != $address)) {
    $address = htmlspecialchars(trim($_POST['address']));

    $query = $db->query('UPDATE users SET address = ? WHERE user_id = ?', $address, $user_id);
    header("Refresh:0");
}

if (isset($_POST['phone']) && ($_POST['phone'] != $phone)) {
    $phone = htmlspecialchars(trim($_POST['phone']));

    $query = $db->query('UPDATE users SET phone = ? WHERE user_id = ?', $phone, $user_id);
    header("Refresh:0");
}

if (isset($_POST['salary']) && ($_POST['salary'] != $salary)) {
    $salary = htmlspecialchars(trim($_POST['salary']));

    $query = $db->query('UPDATE users SET salary = ? WHERE user_id = ?', $salary, $user_id);
    header("Refresh:0");
}




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
            <form action="" method="post">
            <table class="table table-striped">
                <thead>
                    <tr>

                    </tr>
                </thead>
                <tr>
                    <th scope="row">Korisničko ime</th>
                    <td> <input type="text" name="username" value="<?php echo $username; ?>"></td>
                </tr>
                <!--
                <tr>
                    <th scope="row">Nova šifra</th>
                    <td> <input type="text" name="password" value=""></td>
                </tr>
                -->
                <tr>
                    <th scope="row">Email</th>
                    <td> <input type="text" name="email" value="<?php echo $email; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Ime</th>
                    <td> <input type="text" name="forename" value="<?php echo $forename; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Prezime</th>
                    <td> <input type="text" name="surname" value="<?php echo $surname; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Adresa</th>
                    <td> <input type="text" name="address" value="<?php echo $address; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Telefon</th>
                    <td> <input type="text" name="phone" value="<?php echo $phone; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Plata</th>
                    <td> <input type="text" name="salary" value="<?php echo $salary; ?>"></td>
                </tr>
            </table>
            <div class="text-right">
                <input type="submit" value="Unesi izmene" class="btn btn-primary">
            </div>
</form>
        </div>



    </div>


</div>


    </div>


</div>
