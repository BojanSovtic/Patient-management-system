<?php
try {
    require 'core/db.php';

    $db = new db();

    if (isset($_POST['year'])) {
        $year = $_POST['year'];
    } else {
        $year = date("Y");
    }

    $query = $db->query("SELECT 
	COUNT(diagnose_id) AS \"broj\"
        FROM
            invoices
        INNER JOIN appointments ON invoices.invoice_id = appointments.appointment_id
        WHERE YEAR(appointments.start_time) = ?
        ", $year)->fetchAll();
    $ukupnoDijagnoza = $query[0]['broj'];
    // print_r($ukupnoDijagnoza);

    $query = $db->query("SELECT COUNT(substr(diagnoses.`code`, 1, 1)) AS \"br_dijagnoza\", substr(diagnoses.`code`, 1, 1) AS \"tip\"
        FROM
            diagnoses
        INNER JOIN invoices ON diagnoses.diagnose_id = invoices.diagnose_id
        INNER JOIN appointments ON invoices.invoice_id = appointments.appointment_id
        INNER JOIN patients ON patients.patient_id = appointments.patient_id
        WHERE YEAR(appointments.start_time) = ?
        GROUP BY
            substr(diagnoses.`code`, 1, 1)
        ORDER BY
            COUNT(substr(diagnoses.`code`, 1, 1))  DESC
        LIMIT 5
            ", $year)->fetchAll();

    $mkb = [
        "A" => "Zarazne i parazitarne bolesti",
        "B" => "Zarazne i parazitarne bolesti",
        "C" => "Tumori",
        "D" => "Bolesti krvi i krvotvornih organa kao i poremećaji imuniteta",
        "E" => "Bolesti žlezda sa unutrašnjim lučenjem, ishrane i metabolizma",
        "F" => "Duševni poremećaji i poremećaji ponašanja",
        "G" => "Bolesti nervnog sistema",
        "H" => "Bolesti oka, pripojaka oka, uva i mastoidnog nastavka",
        "I" => "Bolesti sistema krvotoka",
        "J" => "Bolesti sistema za disanje",
        "K" => "Bolesti sistema za varenje",
        "L" => "Bolesti kože i potkožnog tkiva",
        "M" => "Bolesti mišićno-koštanog sistema i vezivnog tkiva",
        "N" => "Bolesti mokraćno – polnog sistema",
        "O" => "Trudnoća, rađanje i babinje",
        "P" => "Bolesti perinatalnog perioda",
        "Q" => "Urođene malformacije, deformacije i hromozomske nenormalnosti",
        "R" => "Simptomi, znaci i patološki klinički i laboratorijski nalazi, neklasifikovani na drugom mestu",
        "S" => "Povrede, trovanja i ostale posledice spoljašnjih uzroka",
        "V" => "Spoljašnji uzroci obolevanja i umiranja",
        "Z" => "Faktori koji utiču na stanje zdravlja i kontakt sa zdravstvenom službom"
    ];
    
    // print_r($query);
    

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
        <div id="canvas-holder" style="width:100%">
        <canvas id="chart-area"></canvas>
        <p class="text-center">Prikaz za godinu <?php echo $year; ?> </p>
        <form method="POST">
            <label>Izaberite godinu:</label>
            <select class="form-control" name = "year">
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
            </select>
            <button class= "btn-primary btn-sm" type="submit">Prikaži</button>
        </form>
	</div>


        </div>


        <div class="row">


        </div>


    </div>


</div>

<script>
        var podaci = <?php echo json_encode($query); ?>;
        var ukupnoPodaci = <?php echo $ukupnoDijagnoza; ?>;
        var tipovi = <?php echo json_encode($mkb); ?>

        console.log(podaci);
        console.log(ukupnoPodaci);
        console.log(tipovi);

        var procenti = []
        var tip = []
        var suma = 0;
        for (var i  = 0; i < podaci.length; i++) {
            suma += (podaci[i]['br_dijagnoza'] / ukupnoPodaci) * 100;
            procenti.push(((podaci[i]['br_dijagnoza'] / ukupnoPodaci) * 100).toFixed(2));
            tip.push((tipovi[podaci[i]['tip']]));
        }

        var ostale = (100 - suma).toFixed(2);

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						procenti[0],
						procenti[1],
						procenti[2],
						procenti[3],
						procenti[4],
                        ostale
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
                        window.chartColors.black
					],
					label: 'Tip dijagnoza po godini'
				}],
				labels: [
					tip[0],
					tip[1],
					tip[2],
					tip[3],
					tip[4],
                    "ostale"
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

	</script>