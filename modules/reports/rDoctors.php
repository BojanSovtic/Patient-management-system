<?php
try {
    require 'core/db.php';

    $db = new db();

    $prikaz = "";
    if (isset($_POST['langOpt'])) {
        $niz = $_POST['langOpt'];
        $prikaz = "AND users.user_id in (";
        
        for ($i = 0; $i < count($niz); $i++) {
            if ($i == (count($niz) - 1)) {
                $prikaz .= $niz[$i] . ")";
            } else {
                $prikaz .= $niz[$i] . ", ";
            }
        }
    }

    $start = date('Y-m-d', strtotime('-6 month', time())) . ' 00:00:00';
    if (isset($_POST['start'])) {
        $date = explode('/', $_POST['start']);
        $start = $date[2] . '-' . $date[0] . '-' . $date[1] . ' 00:00:00';
    } 

    $end = date('Y-m-d') . ' 23:59:59';
    if (isset($_POST['end'])) {
        $date = explode('/', $_POST['end']);
        $end = $date[2] . '-' . $date[0] . '-' . $date[1] . ' 23:59:59';
    }

    // print_r($start);
    // print_r($end);

    $query = $db->query("SELECT
    users.user_id,
	users.forename,
	users.surname,
	users.salary  AS \"plata\",
	COUNT(appointments.user_id) AS \"broj_pregleda\",
	COUNT(treatments.medicine_id) AS \"broj_lekova\",
	SUM(case when treatments.medicine_id > 2595 AND treatments.medicine_id < 2795 then 1 else 0 end) AS \"broj_antibiotika\",
	SUM(medicines.price) AS \"troskovi_lekova\",
	SUM(therapies.price) AS \"troskovi_terapija\"
FROM appointments
INNER JOIN users ON appointments.user_id = users.user_id
INNER JOIN invoices ON invoices.appointment_id = appointments.appointment_id
INNER JOIN treatments ON invoices.invoice_id = treatments.invoice_id
LEFT JOIN medicines ON treatments.medicine_id = medicines.medicine_id
LEFT JOIN therapies ON treatments.therapy_id = therapies.therapy_id
WHERE appointments.start_time >= '$start' AND appointments.start_time <= '$end'
$prikaz
GROUP BY
    appointments.user_id")->fetchAll();
    
    // print_r($query);
    // print_r($_POST['doktori']);

    $_SESSION['report'] = $query;
    

  
    
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
        <form method="POST">
        <h2>Izaberite doktora:</h2>
        <select name="langOpt[]" multiple id="langOpt">
            <?php
                $doktori = $db->query("SELECT user_id,
                surname,
                forename
            FROM
                users
            WHERE
                role_id = 5
            ORDER BY
                surname")->fetchAll();

                foreach($doktori AS $doktor) {
                    $doktor_id = $doktor['user_id'];
                    $ime = $doktor['forename'];
                    $prezime = $doktor['surname'];
                    echo "<option value=\"$doktor_id\">" . $prezime . "   " . $ime . "</option>";
                }
            ?>
        </select>
        <h2>Izaberite vreme:</h2>
        <input type="text" class="datepicker" name="start"> do
        <input type="text" class="datepicker" name="end">

            <button class= "btn-primary btn-sm" type="submit">Prikaži</button>
        </form> <br>
        <h2><?php echo "Izveštaj za vreme od " . date('d.m.Y', strtotime($start)) . " do " . date('d.m.Y', strtotime($end)); ?></h2>
        <table id="myTable" class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr style="cursor:pointer">
                        <th onclick="sortTable(0);">Doktor</th>
                        <th onclick="sortTable(1);">Plata</th>
                        <th onclick="sortTable(2);">Broj pregleda</th>
                        <th onclick="sortTable(3);">Broj lekova</th>
                        <th onclick="sortTable(4);">Broj antibiotika</th>
                        <th onclick="sortTable(5);">Troškovi lekova</th>
                        <th onclick="sortTable(6);">Troškovi pregleda</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (count($query) != 0) {
                    foreach ($query as $row) {
                    echo ' <tr>' .
                        '<td>' . $row['surname'] . ' ' . $row['forename'] . '</td>' .
                        '<td>' . $row['plata'] . '</td>' .
                        '<td>' . $row['broj_pregleda'] . '</td>' .
                        '<td>' . $row['broj_lekova'] . '</td>' .
                        '<td>' . $row['broj_antibiotika'] . '</td>' .
                        '<td>' . $row['troskovi_lekova'] . '</td>' .
                        '<td>' . $row['troskovi_terapija'] . '</td>' .
                        '</tr>';
                }
            } else {
                echo "<h2>Nema podataka za odabrani period.</h2>";
            }
                ;

            ?>
                </tbody>
            </table>
                <a href="./index.php?modul=printXML"><button class= "btn-primary btn-sm" value="Sačuvaj">Sačuvaj</button></a>
	</div>


        </div>


        <div class="row">


        </div>


    </div>


</div>

<script>
    var asc = 0;
function sort_table(table, col)
{
	$('.sortorder').remove();
	if (asc == 2) {asc = -1;} else {asc = 2;}
	var rows = table.tBodies[0].rows;
	var rlen = rows.length-1;
	var arr = new Array();
	var i, j, cells, clen;
	
	for(i = 0; i < rlen; i++)
	{
		cells = rows[i].cells;
		clen = cells.length;
		arr[i] = new Array();
		for(j = 0; j < clen; j++) { arr[i][j] = cells[j].innerHTML; }
	}
	
	arr.sort(function(a, b)
	{
		var retval=0;
		var col1 = a[col].toLowerCase().replace(',', '').replace('$', '').replace(' usd', '')
		var col2 = b[col].toLowerCase().replace(',', '').replace('$', '').replace(' usd', '')
		var fA=parseFloat(col1);
		var fB=parseFloat(col2);
		if(col1 != col2)
		{
			if((fA==col1) && (fB==col2) ){ retval=( fA > fB ) ? asc : -1*asc; } //numerical
			else { retval=(col1 > col2) ? asc : -1*asc;}
		}
		return retval;      
	});
	for(var rowidx=0;rowidx<rlen;rowidx++)
	{
		for(var colidx=0;colidx<arr[rowidx].length;colidx++){ table.tBodies[0].rows[rowidx].cells[colidx].innerHTML=arr[rowidx][colidx]; }
	}
	
	hdr = table.rows[0].cells[col];
	if (asc == -1) {
		$(hdr).html($(hdr).html() + '<span class="sortorder">▲</span>');
		} else {
		$(hdr).html($(hdr).html() + '<span class="sortorder">▼</span>');
	}
}


function sortTable(n) {
	sort_table(document.getElementById("myTable"), n);
}

$("select[multiple]").multiselect({
    columns: 1,
    placeholder: "Izaberite doktora",
    search: true,
    selectAll: true
});

$(function() {
    $(".datepicker").datepicker();
})

</script>