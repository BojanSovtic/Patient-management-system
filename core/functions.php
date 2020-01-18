<?php

function showBreadcrumbs() {
    $breadcrumbs = explode("/", $_SERVER['REQUEST_URI']);
    foreach($breadcrumbs as $crumb) {
        echo ucfirst(str_replace(array(".php", ">"), array("", " "), $crumb) . ' ');
    }
}
/*
function proveriVreme($x, $y) {
    $x = new DateTime($x);
    $y = new DateTime($y);


    $diff = $y->diff($x);

    return $diff->days * 24 * 60 + $diff->h * 60 + $diff->i;
}
*/
function checkUsername($username) {
    if (!preg_match('/^[A-Za-z0-9_]{1,20}$/', $username)) {
        return 'Username mora imati 1 do 20 karaktera ili brojeva.';
    } else {
        return '0';
    }
}

function checkEmail($email) {
    if (!preg_match('/^[A-z0-9._%+-]+@[A-z0-9]+\.[A-z]{2,4}$/', $email)) {
        return 'Email nije u validnom formatu.';
    } else {
        return '0';
    }
}

function checkPassword($password) {
    if (!preg_match('/^(?=.*[A-z])(?=.*[0-9])[A-z0-9]{8,}$/', $password)) {
        return 'Sifra mora imati minimum 8 karaktera i barem jednu cifru.';
    } else {
        return '0';
    }
}

function checkForename($ime) {
    if (!preg_match('/^[A-ZČĆĐŠŽ][a-zčćšđž]{1,19}$/', $ime)) {
        return 'Ime mora poceti velikim slovom i imati 2 do 20 cifre!.';
    } else {
        return '0';
    }
}

function checkSurname($prezime) {
    if (!preg_match('/^[A-ZČĆĐŠŽ][a-zčćšđž]{1,14}( [A-Z][a-z]{1,14})*$/', $prezime)) {
        return 'Prezime mora poceti velikim slovom i imati maksimum 15 cifara (svako).';
    } else {
        return '0';
    }
}

function checkDateFormat($datum) {
    if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $datum)) {
        return 'Pogresno ste uneli datum.';
    } else {
        return '0';
    }
}

function checkDiagnoseCode($dijagnoza) {
    if (!preg_match('/^[A-Z]([0-9]|[1-9][0-9]|[1][0-2][0-5])$/', $dijagnoza)) {
        return 'Pogresna vrednost dijagnoze!';
    } else {
        return '0';
    }
}

/*
function proveriDatumBuducnost($datum) { {
        $datum = new DateTime($datum);
        $sada = new DateTime('+1 day');
        // echo $sada->format("Y-m-d");

        if ($datum >= $sada)
            return '0';
        else
            return "Datum mora biti u buducnosti!";
    }
}    
*/ 
?>