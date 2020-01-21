<?php

    $dom = new DOMDocument('1.0', 'utf-8');
    $root = $dom->createElement('doktori');
    $query = $_SESSION['report'];
    foreach($query AS $item) {
        $doktorID = $item['user_id'];
        $ime = $item['forename'];
        $prezime = $item['surname'];
        $plata = $item['plata'];
        $brojPregleda = $item['broj_pregleda'];
        $brojLekova = $item['broj_lekova'];
        $brojAntibiotika = $item['broj_antibiotika'];
        $troskoviLekova = $item['troskovi_lekova'];
        $troskoviTerapija = $item['troskovi_terapija'];

        $doktor = $dom->createElement('doktor');
        $doktor->setAttribute('id', $doktorID);

        $doktorIme = $dom->createElement('ime', $ime);
        $doktor->appendChild($doktorIme);

        $doktorPrezime = $dom->createElement('prezime', $prezime);
        $doktor->appendChild($doktorPrezime);

        $doktorPlata = $dom->createElement('plata', $plata);
        $doktor->appendChild($doktorPlata);

        $doktorBrojPregleda = $dom->createElement('broj_pregleda', $brojPregleda);
        $doktor->appendChild($doktorBrojPregleda);

        $doktorBrojLekova = $dom->createElement('broj_lekova', $brojLekova);
        $doktor->appendChild($doktorBrojLekova);

        $doktorBrojAntibiotika = $dom->createElement('broj_antibiotika', $brojAntibiotika);
        $doktor->appendChild($doktorBrojAntibiotika);

        $doktorTroskoviLekova = $dom->createElement('troskovi_lekova', $troskoviLekova);
        $doktor->appendChild($doktorTroskoviLekova);

        $doktorTroskoviTerapija = $dom->createElement('troskovi_terapija', $troskoviTerapija);
        $doktor->appendChild($doktorTroskoviTerapija);

        $root->appendChild($doktor);

    }
    $dom->appendChild($root);

    $file_name = "report.xml";
    header('Content-Disposition: attachment;filename=' . $file_name);
    header('Content-Type: text/xml');

    ob_clean();
    flush();
    echo $dom->saveXML();
    exit;

?>