<?php

if (empty($_POST)) {
    $greske[] = 'Unesite podatke';
} else {

$greske = [];

// Username
if (isset($_POST['username'])) {
    $username = htmlspecialchars(trim($_POST['username']));
}
if (checkUsername($username) !== '0') {
    $greske[] = checkUsername($username);
}

// Password
if (isset($_POST['password'])) {
    $password = htmlspecialchars(trim($_POST['password']));
}
if (checkPassword($password) !== '0') {
    $greske[] = checkPassword($password);
} else {
    $password = password_hash($password, PASSWORD_DEFAULT);
}
if (isset($_POST['passwordConf'])) {
    $passwordConf = htmlspecialchars($_POST['passwordConf']);
}

// email
if (isset($_POST['email'])) {
    $email = htmlspecialchars(trim($_POST['email']));
}
if (checkEmail($email) !== '0') {
    $greske[] = checkEmail($email);
}
if (isset($_POST['emailConf'])) {
    $emailConf = htmlspecialchars(trim($_POST['emailConf']));
}
if ($email !== $emailConf) {
    $greske[] = "Potvrdite email ponovo!";
}


if (isset($_POST['forename'])) {
    $forename = htmlspecialchars(trim($_POST['forename']));
}

if (isset($_POST['surname'])) {
    $surname = htmlspecialchars(trim($_POST['surname']));
}

if (isset($_POST['address'])) {
    $address = htmlspecialchars(trim($_POST['address']));
}

if (isset($_POST['phone'])) {
    $phone = htmlspecialchars(trim($_POST['phone']));
}

if (isset($_POST['salary'])) {
    $salary = htmlspecialchars(trim($_POST['salary']));
}

if (isset($_POST['role'])) {
    $role = htmlspecialchars(trim($_POST['role']));
}

switch ($role) {
    case 'admin':
        $role_id = 7;
        break;
    case 'doktor':
        $role_id = 5;
        break;
    case 'sestra':
        $role_id = 3;
        break;
    case 'računovodstvo':
        $role_id = 10;
        break;
    default:
        $role_id = '';
        break; 
}

if (sizeof($greske) == 0) {
    require 'core/db.php';

    $db = new db();


    $db->query('INSERT INTO users (username, password, email, forename, surname, address, phone, salary, role_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', $username, $password, $email, $forename, $surname, $address, $phone, $salary, $role_id);

    $db->close();
    echo "<div class=\"potvrda\"> 
                <p class=\"uspeh\">Uspesno ste kreirali korisnika! Odaberite novu opciju.</p>
        </div>";
} 
}
?>
<div class="container">

<div class="row row-my">
<?php
if($_SESSION['role'] == 7) {
    echo '<div class="col-lg-3">

            <h1 class="my-4">Izaberite opciju</h1>
            <div class="list-group">

            <a class="nav-link" href="./index.php?modul=createUser"><button type="button" class= "btn-primary btn-sm">Kreiraj novog korisnika</button></a><br>
            <a class="nav-link" href="./index.php?modul=showUsers"><button type="button" class= "btn-primary btn-sm">Pogledaj korisnike</button></a><br>
            <a class="nav-link" href="./index.php?modul=deleteUser"><button type="button" class= "btn-primary btn-sm">Obriši korisnika</button></a><br>
            </div>

        </div>';
 };
?>


        <div class="col-lg-9">

            <form method="post" id="formCreateUser">
                <div class="form-row">
                    
                    <div class="col">
                        <label for="username"> Username: </label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $_POST['username'] ?? '' ?> " required><br>

                        <label for="password"> Password: </label>
                        <input type="password" id="password" name="password" class="form-control" required><br>

                        <label for="passwordConf"> Confirm password: </label>
                        <input type="password" id="passwordConf" name="passwordConf" class="form-control" required><br>


                        <label for="forename">Ime: </label>
                        <input type="text" id="forename" name="forename" class="form-control" value="<?php echo $_POST['forename'] ?? '' ?> " required><br>

                        <label for="surname">Prezime: </label>
                        <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $_POST['surname'] ?? '' ?> "required><br>


                    </div>

                    <div class="col">
                        <label for="addres">Adresa:</label>
                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $_POST['address'] ?? '' ?> " required><br>

                        <label for="phone">Telefon:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?? '' ?> " required><br>

                        
                        <label for="email">E-mail: </label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? '' ?> "required><br>

                        <label for="emailConf">Confirm E-mail: </label>
                        <input type="email" id="emailConf" name="emailConf" class="form-control" value="<?php echo $_POST['emailConf'] ?? '' ?> "required><br>

                        <label for="salary">Plata: </label>
                        <input type="number" id="salary" name="salary" class="form-control" value="<?php echo $_POST['salary'] ?? '' ?> " required>

                        <label for="role">Pozicija: </label>
                        <select id="role" name="role" class="form-control" value="<?php echo $_POST['role'] ?? '' ?> " required>
                        <?php
                        try {
                            require ('core/db.php');

                            $db = new db();

                            $query = $db->query('SELECT name FROM roles')->fetchAll();

                            foreach($query as $item) {
                                $name = $item['name'];
                                echo "<option value=\"$name\">" . $name . "</option>";
                            }

                            $db->close();
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
 
                        ?>
                        </select><br>


                        <div class="text-right">
                            <input type="submit" value="Kreiraj novog korisnika" class="btn btn-primary">
                        </div>
                    </div>


                </div>

                                                
                <?php 
                    foreach ($greske as $greska) {
                        echo "<p class=\"error\">" . $greska . "</p>";
                    };
                ?>
                
            </form>
        </div>

        
        <div class="row">


        </div>


    </div>


</div>
<script>
    $("#showUsers").click(function() {
        $('#formCreateUser').toggle();
    });


</script>