<?php

$greske = [];

if (empty($_POST)) {
    $greske[] = 'Unesite podatke';
} else {



if (isset($_POST['forename'])) {
    $forename = htmlspecialchars(trim($_POST['forename']));
}
if (checkForename($forename) !== '0') {
    $greske[] = checkForename($forename);
}

if (isset($_POST['surname'])) {
    $surname = htmlspecialchars(trim($_POST['surname']));
}
if (checkSurname($surname) !== '0') {
    $greske[] = checkSurname($surname);
}


if (isset($_POST['dateOfBirth'])) {
    $dateOfBirth = htmlspecialchars(trim($_POST['dateOfBirth']));
}
if (checkDateFormat($dateOfBirth) !== '0') {
    $greske[] = "Pogrešno unet datum";
}

if (isset($_POST['gender'])) {
    $gender = htmlspecialchars($_POST['gender']);
}
if (!in_array($gender, array('muški', 'ženski'))) {
    $greske[] = "Pogrešna vrednost za pol.";
}

if (isset($_POST['jmbg'])) {
    $jmbg = htmlspecialchars($_POST['jmbg']);
}
if (!is_numeric($jmbg) || strlen($jmbg) != 13) {
    $greske[] = "Pogrešna vrednost za jmbg.";
}

if(isset($_POST['address'])) {
    $address = htmlspecialchars($_POST['address']);
}

if (isset($_POST['phone'])) {
    $phone = htmlspecialchars($_POST['phone']);
}

if(isset($_POST['insurance_type'])) {
    $insurance_type = htmlspecialchars($_POST['insurance_type']);
}
if(!in_array($insurance_type, array('Nema zdravstveno osiguranje', 'Dobrovoljno zdravstveno osiguranje', 
    'Obavezno osiguranje zdravstvenog fonda RZZO', 'Privatno osiguranje'))) {
        $greske[] = "Pogrešna vrednost za osiguranje.";
}


// email
if (isset($_POST['email'])) {
    $email = htmlspecialchars(trim($_POST['email']));
}
if (checkEmail($email) !== '0') {
    $greske[] = checkEmail($email);
}

if (isset($_POST['LBO'])) {
    $LBO = htmlspecialchars($_POST['LBO']);
}
if (!is_numeric($LBO) || strlen($LBO) != 11) {
    $greske[] = "Pogrešna vrednost za LBO.";
}

if (sizeof($greske) == 0) {
    require 'core/db.php';

    $db = new db();


    $db->query('INSERT INTO patients (name, surname, date_of_birth, gender, jmbg, address, phone, insurance_type, email, LBO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $forename, $surname, $dateOfBirth, $gender, $jmbg, $address, $phone, $insurance_type, $email, $LBO);

    $db->close();
    echo "<div class=\"potvrda\"> 
                <p class=\"uspeh\">Uspesno ste kreirali karton! Odaberite novu opciju.</p>
        </div>";
} 
}
?>
<div class="container">

<div class="row row-my">
<?php
    if($_SESSION['role'] == 3) {

        echo '<div class="col-lg-3">

        <h1 class="my-4">Izaberite opciju</h1>
        <div class="list-group">


        <a class="nav-link" href="./index.php?modul=home"><button type="button" class= "btn-primary btn-sm">Pretraga pacijenta</button></a><br>
        <a class="nav-link" href="./index.php?modul=createPatient"><button type="button" class= "btn-primary btn-sm">Kreiraj novi karton</button></a><br>
        <a class="nav-link" href="./index.php?modul=viewPatient"><button type="button" class= "btn-primary btn-sm" >Informacije o pacijentu</button></a><br>
        </div>

    </div>';

    };
?>


        <div class="col-lg-9">

            <form method="post" id="formCreateUser">
                <div class="form-row">
                    
                    <div class="col">
                        <label for="forename"> Ime: </label>
                        <input type="text" id="forename" name="forename" class="form-control" value="<?php echo $_POST['forename'] ?? '' ?> " required><br>

                        <label for="surname"> Prezime: </label>
                        <input type="surname" id="surname" name="surname" class="form-control" value="<?php echo $_POST['surname'] ?? '' ?> " required><br>

                        <label for="dateOfBirth"> Datum rođenja: </label>
                        <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" value="<?php echo $_POST['dateOfBirth'] ?? '' ?> " required><br>


                        <label for="gender">Pol: </label><br>
                        <input type="radio" id="male" name="gender" class="form-check-input" value="muški" required>Muški<br>
                        <input type="radio" id="female" name="gender" class="form-check-input" value="ženski" required>Ženski<br>

                        <label for="jmbg">JMBG: </label>
                        <input type="number" id="jmbg" name="jmbg" class="form-control"  value="<?php echo $_POST['jmbg'] ?? '' ?> " required>

                       

                    </div>

                    <div class="col">

                    <label for="addres">Address:</label>
                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $_POST['address'] ?? '' ?> "><br>
                        
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?? '' ?> "><br>

                        <label for="insurance_type">Tip osiguranja: </label>
                        <select id="insurance_type" name="insurance_type" class="form-control" value="<?php echo $_POST['insurance_type'] ?? '' ?>" required>
                            <option value="Nema zdravstveno osiguranje">Nema zdravstveno osiguranje</option>
                            <option value="Dobrovoljno zdravstveno osiguranje">Dobrovoljno zdravstveno osiguranje</option>
                            <option value="Obavezno osiguranje zdravstvenog fonda RZZO">Obavezno osiguranje zdravstvenog fonda RZZO</option>
                            <option value="Privatno osiguranje">Privatno osiguranje</option>
                        </select>
                        
                        
                        <label for="email">E-mail: </label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? '' ?> "><br>

                        <label for="jmbg">LBO: </label>
                        <input type="number" id="LBO" name="LBO" class="form-control" value="<?php echo $_POST['LBO'] ?? '' ?> "><br>


                        <div class="text-right">
                            <input type="submit" value="Kreiraj novi karton" class="btn btn-primary">
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