<?php
    require 'core/db.php';

    $db = new db();

    
    $bolestiKrvi = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'D64%'")->fetchAll();
    foreach ($query as $item) {
        $bolestiKrvi[] = $item['diagnose_id']; 
    }

    // cesto (dijabetes)
    $bolestiMetabolizma = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'E0%' OR code LIKE 'E1%' OR code LIKE  'E7%' OR code LIKE 'E8%'
    ")->fetchAll();
    foreach ($query as $item) {
        $bolestiMetabolizma[] = $item['diagnose_id']; 
    }

    // cesto
    $mentalniPoremecaji = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'F4%' OR code LIKE 'F3%'
    ")->fetchAll();
    foreach ($query as $item) {
        $mentalniPoremecaji[] = $item['diagnose_id']; 
    }

    $bolestiNervnogS = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'G8%' OR code LIKE 'G9%'")->fetchAll();
    foreach ($query as $item) {
        $bolestiNervnogS[] = $item['diagnose_id']; 
    }

    // cesto
    $bolestiKrvotoka = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'G
    I1%' OR code LIKE 'I3%' OR code LIKE 'I4%' OR code LIKE 'I5%'
     ")->fetchAll();
    foreach ($query as $item) {
        $bolestiKrvotoka[] = $item['diagnose_id']; 
    }

    $bolestiDisanje = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'J0%' OR code LIKE 'J2%' OR code LIKE 'J3%' OR code LIKE 'J4%'
    ")->fetchAll();
    foreach ($query as $item) {
        $bolestiDisanje[] = $item['diagnose_id']; 
    }

    $bolestiDigestivneKozne = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'K5%' OR code LIKE 'K6%' OR code LIKE 'K2%' OR code LIKE 'L2%' OR code LIKE 'L0%'")->fetchAll();
    foreach ($query as $item) {
        $bolestiDigestivneKozne[] = $item['diagnose_id']; 
    }

    // cesto
    $bolestiMuskulaturnog = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'M5%' OR code LIKE 'M2%' OR code LIKE 'M7%' 
    ")->fetchAll();
    foreach ($query as $item) {
        $bolestiMuskulaturnog[] = $item['diagnose_id']; 
    }

    $bolestiMokraceLabNalazi = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'N1%' OR code LIKE 'N3%' OR code LIKE 'R4%' OR code LIKE 'R2%' OR code LIKE 'R1%' OR code LIKE 'R0%' OR code LIKE 'R3%' 
    ")->fetchAll();
    foreach ($query as $item) {
        $bolestiMokraceNalazi[] = $item['diagnose_id']; 
    }

    // cesto
    $pregledi = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'Z7%' OR code LIKE 'Z8%' OR code LIKE 'Z9%' OR code LIKE 'Z2%' OR code LIKE 'Z6%' OR code LIKE 'Z7%' OR code LIKE 'Z0%' OR code LIKE 'Z1%'
    ")->fetchAll();
    foreach ($query as $item) {
        $pregledi[] = $item['diagnose_id']; 
    }

    // cesto
    $povrede = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'S%'
    ")->fetchAll();
    foreach ($query as $item) {
        $povrede[] = $item['diagnose_id']; 
    }

    $tumori = [];
    $query = $db->query("SELECT diagnose_id FROM diagnoses WHERE code LIKE 'C%'
    OR code LIKE 'D1%' OR code LIKE 'D2%' OR code LIKE 'D3%' OR code LIKE 'D4%'
    ")->fetchAll();
    foreach ($query as $item) {
        $tumori[] = $item['diagnose_id']; 
    }
    
    $cesteBolesti = array_merge($bolestiMetabolizma, $mentalniPoremecaji, $bolestiKrvotoka,
    $bolestiMuskulaturnog, $pregledi, $pregledi, $pregledi, $povrede, $povrede);

    $ostaleBolesti = array_merge($bolestiKrvi, $bolestiNervnogS, $bolestiDisanje, $bolestiDigestivneKozne, 
    $bolestiMokraceLabNalazi);

    $lekovi = [];
    $query = $db->query("SELECT medicine_id FROM medicines")->fetchAll();
    foreach ($query as $item) {
        $lekovi[] = $item['medicine_id']; 
    }

    $terapije = [];
    $query = $db->query("SELECT therapy_id FROM therapies")->fetchAll();
    foreach ($query as $item) {
        $terapije[] = $item['therapy_id']; 
    }

    $pregledi = [];
    $query = $db->query("SELECT appointment_id FROM appointments WHERE status = 'finished' AND appointment_id > 102364")->fetchAll();
    foreach ($query as $item) {
        $pregledi[] = $item['appointment_id']; 
    }


    // Ubacivanje faktura (invoice) na osnovu pregleda (appointments)
    /*
    foreach($pregledi AS $pregled) {
        $x = rand(0, 100);
        if ($x < 80) {
            $dijagnoza = $cesteBolesti[rand(0, count($cesteBolesti) - 1)];
        } else {
            $dijagnoza = $ostaleBolesti[rand(0, count($ostaleBolesti) - 1)];
        }

        // echo $pregled . "   " . $dijagnoza . "<br>";
        $db->query('INSERT INTO invoices (diagnose_id, appointment_id) 
        VALUES (?, ?)', $dijagnoza, $pregled);
    }
    */

    $fakture = [];
    $query = $db->query("SELECT invoice_id FROM invoices WHERE invoice_id > 99339
    ORDER BY invoice_id")->fetchAll();
    foreach ($query as $item) {
        $fakture[] = $item['invoice_id']; 
    }

    // Ubacivanje stavki faktura (treatments) 
    
    foreach($fakture AS $faktura) {
        $x = rand(0, 100);

        $lek = NULL;
        $terapija = NULL;
        if ($x <= 60) {
            $lek = $lekovi[rand(0, count($lekovi) - 1)];
        } else {
            $terapija = $terapije[rand(0, count($terapije) - 1)];
        }

        // echo $faktura . "   L" . $lek . "   T" . $terapija . "<br>";
        $db->query('INSERT INTO treatments (invoice_id, medicine_id, therapy_id) 
        VALUES (?, ?, ?)', $faktura, $lek, $terapija);

        $x = rand(0, 100);
        if ($x <= 25) {
            $lek = $lekovi[rand(0, count($lekovi) - 1)];
            $db->query('INSERT INTO treatments (invoice_id, medicine_id) 
            VALUES (?, ?)', $faktura, $lek);
        }



        $x = rand(0, 100);
        if ($x <= 10) {
            $lek = $lekovi[rand(0, count($lekovi) - 1)];
            $db->query('INSERT INTO treatments (invoice_id, medicine_id) 
            VALUES (?, ?)', $faktura, $lek);
        }
        


        $x = rand(0, 100);
        if ($x <= 10) {
            $terapija = $terapije[rand(0, count($terapije) - 1)];
            $db->query('INSERT INTO treatments (invoice_id, therapy_id) 
            VALUES (?, ?)', $faktura, $terapija);
        }

        
    }


?>