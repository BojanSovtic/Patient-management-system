<?php

require 'core/db.php';

$db = new db();

    $imeMusko = ['Aleksa', 'Aleksandar', 'Andrija', 'Bane', 'Bogdan', 'Božidar', 'Bojan', 'Borivoje', 'Branko', 'Veljko', 
'Vladimir', 'Vojislav', 'Vuk', 'Gavrilo', 'Goran', 'David', 'Danilo', 'Darko', 'Dejan', 'Dragan', 'Dragoljub', 'Dušan', 
'Đorđe', 'Željko', 'Zdravko', 'Zoran', 'Ivan', 'Igor', 'Ilija', 'Janko', 'Jovan', 'Kosta', 'Lazar', 'Luka', 'Ljubiša', 'Marinko', 'Marko', 'Mateja',
'Miljan', 'Milovan', 'Miloš', 'Milutin', 'Miroslav', 'Mitar', 'Nebojša', 'Nemanja', 'Nikola', 'Ognjen', 'Pavle', 'Petar', 'Predrag', 
'Radovan', 'Rajko', 'Sava', 'Siniša', 'Srđan', 'Stanko', 'Stevan', 'Tadija', 'Teodor', 'Uroš', 'Filip'];

    $imeZensko = ['Aleksandra', 'Ana', 'Andrijana', 'Biljana', 'Bojana', 'Branka', 'Vera', 'Vesna', 'Goca', 'Danica', 
'Desanka', 'Dragica', 'Dubravka', 'Dunja', 'Đurđa', 'Eva', 'Živka', 'Zorana', 'Ivana', 'Irena', 'Isidora', 'Jagoda', 'Jasmina', 
'Jasna', 'Jelena', 'Jovana', 'Julija', 'Katarina', 'Kristina', 'Lena', 'Ljiljana', 'Marija', 'Milena', 'Milijana', 'Milica', 'Mirjana', 'Nada', 'Nadežda', 
'Natalija', 'Nevena', 'Nina', 'Olga', 'Olivera', 'Petra', 'Radmila', 'Ružica', 'Sandra', 'Sanja', 'Simona', 'Sonja', 'Tamara', 'Teodora', 
'Tijana', 'Helena'];

    $prezimena = ['Jovanović', 'Petrović', 'Nikolić', 'Ilić', 'Đorđević', 'Pavlović', 'Marković', 'Popović', 'Stojanović', 'Živković', 'Janković', 
    'Todorović', 'Stanković', 'Ristić', 'Kostić', 'Milošević', 'Cvetković', 'Kovačević', 'Dimitrijević', 'Tomić', 'Krstić', 'Ivanović', 'Lukić', 
    'Filipović', 'Savić', 'Mitrović', 'Lazić', 'Petković', 'Obradović', 'Aleksić', 'Radovanović', 'Lazarević', 'Vasić', 'Milovanović', 'Jović', 
    'Stevanović', 'Milenković', 'Milosavljević', 'Mladenović', 'Živanović', 'Simić', 'Đurić', 'Nedeljković', 'Novaković', 'Marinković', 'Bogdanović', 
    'Knežević', 'Radosavljević', 'Mihajlović', 'Gajić', 'Mitić', 'Stefanović', 'Blagojević', 'Antić', 'Vasiljević', 'Jevtić', 'Đokić', 'Stojković', 
    'Vuković', 'Rakić', 'Stanojević', 'Pešić', 'Tasić', 'Milić', 'Milanović', 'Zdravković', 'Grujić', 'Babić', 'Vučković', 'Matić', 'Perić', 'Ćirić', 
    'Paunović', 'Marjanović', 'Maksimović', 'Anđelković', 'Jakovljević', 'Gavrilović', 'Veljković', 'Tošić', 'Trajković', 'Ivković', 'Arsić', 'Miletić', 
    'Veličković', 'Radović', 'Miljković', 'Nešić', 'Jeremić', 'Radulović', 'Đurđević', 'Milojević', 'Urošević', 'Bošković', 'Trifunović', 'Božić', 
    'Radivojević', 'Đukić', 'Milutinović', 'Stamenković'];

    
    $adresaNiz = ['Adžine Livade', 'Banjički Put', 'Blagojevićev Prolaz', 'Bogdana Žerajića', 'Bohorska', 'Božidara Stojanovića', 'Braće Marinković',
    'Čelebićka', 'Crnojevića', 'Dimitrija Koturovića', 'Dr Milivoja Petrovića', 'Frana Levstika', 'Gragorčićeva', 'Guslarska', 'Hasanaginice', 'Ivana Mičurina', 
    'Janković Stojana', 'Kakanjska', 'Kanarevo Brdo', 'Koste Živkovića', 'Košutnjačka', 'Kraljice Jelene', 'Marička', 'Matije Gubca', 'Mihaila Stanojevića', 
    'Miladina Popovića', 'Milana Blagojevića Španca', 'Milana Premasunca', 'Mile Dimić', 'Milice Srpkinje', 'Miška Kranjca', 'Mitra Bakića', 'Mome Stanojlovića', 
    'Natoševićeva', 'Nikole Markovića', 'Nova Skojevska', 'Oslobodilaca Rakovice', 'Osme Crnogorske Brigade', 'Partizanska', 'Patrijarha Dimitrija', 'Patrijarha Joanikija', 
    'Pere Velimirovića', 'Pilota M. Petrovića', 'Pilota R. Jovanovića', 'Prve Šumadijske Brigade', 'Reljkovićeva', 'Ribarčeva', 'Roze Luksemburg', 'Rujica', 
    'Serdara Janka Vukotića', 'Skojevska', 'Slavka Rodića', 'Slavoljuba Vuksanovića', 'Snežane Hrepevnik', 'Srpskih Udarnih Brigada', 'Srzentićeva' , 
    'Stanka Paunovića Veljka', 'Starca Milije', 'Stevana Lukovića', 'Stevana Opačića', 'Susedgradska', 'Tavčareva', 'Trepčanska', 'Trstenjakova', 'Vareška', 
    'Velizara Stankovića', 'Viševačka', 'Vodice', 'Vrbnička', 'Vukasovićeva'];

    $tipOsiguranja = ['Nema zdravstveno osiguranje','Dobrovoljno zdravstveno osiguranje','Obavezno osiguranje zdravstvenog fonda RZZO','Privatno osiguranje'];

    $polM = 'muški';
    $polZ = 'ženski';
    
    $n = 0;
    while ($n != 10001) {
    $datum = randomDate('1.1.1920', '1.1.2019');
    // echo $datum . '<br>';
    $datumR = date("Y-m-d", strtotime($datum));
    // echo $datum;

    // echo $datum . '<br>';
    $jmbgM = substr($datum, 0, 2) . substr($datum, 3, 2) . substr($datum, 7) . random_int(10, 100) . random_int(100, 499) . random_int(0, 10);
    $jmbgZ = substr($datum, 0, 2) . substr($datum, 3, 2) . substr($datum, 7) . random_int(10, 100) . random_int(500, 1000) . random_int(0, 10);
    // echo $jmbgM;


    $adresa = $adresaNiz[random_int(0, count($adresaNiz) - 1)] . " " . random_int(1, 40);
    // echo $adresa;

    $telefon = "06" . random_int(0, 10) . random_int(100000, 10000000);
    // echo $telefon;



    $broj = random_int(0, 100);
    if ($broj < 80) {
        $osiguranje = $tipOsiguranja[2];
    } elseif ($broj < 90) {
        $osiguranje = $tipOsiguranja[0];
    } elseif ($broj < 95) {
        $osiguranje = $tipOsiguranja[1];
    } else {
        $osiguranje = $tipOsiguranja[3];
    }
    
    // echo $broj . " " . $osiguranje;

    $ime = $imeMusko[random_int(0, count($imeZensko) - 1)];
    $prezime = $prezimena[random_int(0, count($prezimena) - 1)];

    // echo $ime . " " . $prezime;
    $email = mb_strtolower(substr($ime, 0, 1), 'UTF-8') . mb_strtolower($prezime, 'UTF-8') . '@gmail.com';
    // echo $email;

    $lbo = NULL;
    if ($osiguranje == 'Obavezno osiguranje zdravstvenog fonda RZZO') {
        $lbo = random_int('10000000000', '99999999999');
    }

    $db->query('INSERT INTO patients (name, surname, date_of_birth, gender, jmbg, address, phone, insurance_type, email, LBO) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $ime, $prezime, $datumR, $polM, $jmbgM, $adresa, $telefon, $osiguranje, $email, $lbo);


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