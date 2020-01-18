<?php
try {
    require 'core/db.php';

    $db = new db();

    // Dijabetes
    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'diabetes%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) < 19
	")->fetchArray();
    
    $ispod18 = $query['broj'];

    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'diabetes%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) >= 19 AND 
    TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) <= 65
	")->fetchArray();
    
    $ispod65 = $query['broj'];

    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'diabetes%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) > 65
	")->fetchArray();
    
    $iznad65 = $query['broj'];


    // Depresija
    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'depressio%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) < 19
	")->fetchArray();
    
    $ispod18D = $query['broj'];

    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'depressio%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) >= 19 AND 
    TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) <= 65
	")->fetchArray();
    
    $ispod65D = $query['broj'];

    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'depressio%' AND TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) > 65
	")->fetchArray();
    
    $iznad65D = $query['broj'];


    $db->close();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>

<div class="container">

<div class="row row-my">
<?php
if ($_SESSION['role'] == 7 || $_SESSION['role'] == 9) {
    echo '<div class="row ">

            <h1 class="my-2">Izaberite opciju</h1>
            <div class="list-inline">

            <li class="list-inline-item"><a class="nav-link" href="./index.php?modul=reports"><button type="button" class= "btn-primary btn-sm">Najčešće grupe bolesti</button></a>
            <li class="list-inline-item"><a class="nav-link" href="./index.php?modul=rPopulation"><button type="button" class= "btn-primary btn-sm">Bolesti i lekovi po starosti</button></a>
            <li class="list-inline-item"><a class="nav-link" href="./index.php?modul=rDoctors"><button type="button" class= "btn-primary btn-sm">Doktori</button></a>
            </div>

        </div>';
}
;
?>


        <div class="col-lg-12">
        <div id="container" style="width:100%">
        <canvas id="canvas"></canvas>

	</div>


        </div>


        <div class="row">


        </div>


    </div>


</div>

<script>
    var ispod18 = <?php echo $ispod18; ?>;
    var izmedju = <?php echo $ispod65; ?>;
    var iznad65 = <?php echo $iznad65; ?>;
    var ispod18D = <?php echo $ispod18D; ?>;
    var izmedjuD = <?php echo $ispod65D; ?>;
    var iznad65D = <?php echo $iznad65D; ?>;

		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['Dijabetes', 'Depresija'],
			datasets: [{
				label: 'ispod 18',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: [
                    ispod18,
                    ispod18D
                ]
			}, {
				label: 'između 18 i 65',
				backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
                    izmedju,
                    izmedjuD
                ]
			}, {
				label: 'iznad 65',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
                    iznad65,
                    iznad65D
				]
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Oboleli od dijabetesa'
					}
				}
			});

		};


</script>