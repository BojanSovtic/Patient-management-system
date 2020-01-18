<?php
    if(!isset($_SESSION['patient'])) {
        $_SESSION['message'] = "Molimo odaberite pacijenta!";
        header("Location: ./index.php?modul=home");
      };

      try {
        require 'core/db.php';
    
        $db = new db();

        $patient_id = $_SESSION['patient']['patient_id'];
    
        $sql = $db->query("SELECT patients.`name` AS \"ime\", patients.surname, appointments.start_time, 
        diagnoses.code, diagnoses.description AS \"opis\", 
        therapies.description, medicines.`name`
        FROM patients
        INNER JOIN appointments ON patients.patient_id = appointments.patient_id
        INNER JOIN invoices ON invoices.appointment_id = appointments.appointment_id
        INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
        INNER JOIN treatments ON invoices.invoice_id = treatments.invoice_id
        LEFT JOIN therapies ON treatments.therapy_id = therapies.therapy_id
        LEFT JOIN medicines ON treatments.medicine_id = medicines.medicine_id
        WHERE patients.patient_id = ?
        ORDER BY start_time DESC", $patient_id)->fetchAll();


        $termin = [
            'start_time' => '',
            'code' => '',
            'opis' => '',
            'descripiton' => array(),
            'name' => array()
        ];
        

        $dijagnoze = [];
        foreach ($sql as $row) {
            $dijagnoze[] = $row['code'] . " " . $row['opis'];           
        }

        $dijagnoze = array_unique($dijagnoze);
        
        $db->close();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }



?>
<div class="container">

<div class="row row-my">
<?php
        if ($_SESSION['role'] == 5) {
            echo '<div class="col-lg-3">
        
                     <h1 class="my-4">Izaberite opciju</h1>
                     <div class="list-group">
        
                     <a class="nav-link" href="./index.php?modul=doctorSchedule"><button type="button" class= "btn-primary btn-sm">Termini</button></a><br>
                     <a class="nav-link" href="./index.php?modul=patientHistory"><button type="button" class= "btn-primary btn-sm">Istorija pacijenata</button></a><br>
                     </div>';

                    
                     echo "<h2>Prethodne dijagnoze</h2>";
                     echo "<table class='table'>";
                     foreach($dijagnoze AS $dijagnoza) {
                         echo "<tr><td>" . $dijagnoza . "</td></tr>";
                     }
                 
                 echo '</table></div>';
        
                 
        }
        ;
?>

<div class="col-lg-9">
            <?php   
                   
            ?>

            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Kod</th>
                        <th>Dijagnoza</th>
                        <th>Terapija</th>
                        <th>Lek</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    $prevTime = '';
foreach ($sql as $row) {


        if ($prevTime == $row['start_time']) {
            echo ' <tr >';
            echo '<td></td><td></td><td></td>
            <td>' . $row['description'] . '</td>' .
            '<td>' . $row['name'] . '</td>';
        } else {
            echo ' <tr class="rowUpBor">';
            echo '<td>' . date('d.m.Y', strtotime($row['start_time'])) . '</td>' .
            '<td>' . $row['code'] . '</td>' .
            '<td>' . $row['opis'] . '</td>' .
            '<td>' . $row['description'] . '</td>' .
            '<td>' . $row['name'] . '</td>';
        }
        '</tr>';
    $prevTime = $row['start_time'];
}
;

?>
                </tbody>
            </table>


            </div>

</div>