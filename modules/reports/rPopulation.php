<?php
try {
    require 'core/db.php';

    $db = new db();

    // Dijabetes
    $query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\",
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) AS \"godine\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'diabetes%'
GROUP BY
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE())
ORDER BY
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE())
	")->fetchAll();

	
	$ispod18 = 0;
	$izmedju18i45 = 0;
	$izmedju45i65 = 0;
	$iznad65 = 0;
	foreach ($query AS $row) {
		if ($row['godine'] <= 18) {
			$ispod18 += $row['broj'];
		} else if ($row['godine'] <= 45) {
			$izmedju18i45 += $row['broj'];
		} else if ($row['godine'] <= 65) {
			$izmedju45i65 += $row['broj'];
		} else {
			$iznad65 += $row['broj'];
		}
	}

	$dijabetes = [
		'ispod18' => $ispod18,
		'izmedju18i45' =>  $izmedju18i45,
		'izmedju45i65' => $izmedju45i65,
		'iznad65' => $iznad65
	];

	$bolesti['dijabetes'] = $dijabetes;

	// Depresija
	$query = $db->query("SELECT 
	count(DISTINCT(appointments.patient_id)) AS \"broj\",
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE()) AS \"godine\"
FROM
	patients
	INNER JOIN appointments ON patients.patient_id = appointments.patient_id
	INNER JOIN invoices ON appointments.appointment_id = invoices.appointment_id
	INNER JOIN diagnoses ON invoices.diagnose_id = diagnoses.diagnose_id
WHERE
	diagnoses.`latin` LIKE 'depressio%'
GROUP BY
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE())
ORDER BY
	TIMESTAMPDIFF(YEAR, patients.date_of_birth, CURDATE())
	")->fetchAll();
	
	$ispod18Dep = 0;
	$izmedju18i45Dep = 0;
	$izmedju45i65Dep = 0;
	$iznad65Dep = 0;
	foreach ($query AS $row) {
		if ($row['godine'] <= 18) {
			$ispod18Dep += $row['broj'];
		} else if ($row['godine'] <= 45) {
			$izmedju18i45Dep += $row['broj'];
		} else if ($row['godine'] <= 65) {
			$izmedju45i65Dep += $row['broj'];
		} else {
			$iznad65Dep += $row['broj'];
		}
	}

		
	$depresija = [
		'ispod18' => $ispod18Dep,
		'izmedju18i45' =>  $izmedju18i45Dep,
		'izmedju45i65' => $izmedju45i65Dep,
		'iznad65' => $iznad65Dep
	];

	$bolesti['depresija'] = $depresija;
	$_SESSION['reportP'] = $bolesti;
	print_r($_SESSION['reportP']);

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
		<a href="./index.php?modul=printXMLGeneric"><button class= "btn-primary btn-sm" value="Sačuvaj">Sačuvaj</button></a>
	</div>


        </div>


        <div class="row">


        </div>


    </div>


</div>

<script>
    var ispod18 = <?php echo $ispod18; ?>;
	var izmedju18 = <?php echo $izmedju18i45; ?>;
	var izmedju45 = <?php echo $izmedju45i65; ?>;
    var iznad65 = <?php echo $iznad65; ?>;
    var ispod18Dep = <?php echo $ispod18Dep; ?>;
	var izmedju18Dep = <?php echo $izmedju18i45Dep; ?>;
	var izmedju45Dep = <?php echo $izmedju45i65Dep; ?>;
    var iznad65Dep = <?php echo $iznad65Dep; ?>;

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
                    ispod18Dep
                ]
			}, {
				label: 'između 18 i 45',
				backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
                    izmedju18,
                    izmedju18Dep
                ]
			}, {
				label: 'između 45 i 65',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
                    izmedju45,
                    izmedju45Dep
				]
			}, {
				label: 'iznad 65',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
                    iznad65,
                    iznad65Dep
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
						text: 'Oboleli po godinama'
					}
				}
			});

		};


</script>