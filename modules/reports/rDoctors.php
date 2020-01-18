<?php
try {
    require 'core/db.php';

    $db = new db();

    $query = $db->query("SELECT
	users.forename,
	users.surname,
	users.salary * 6 AS \"plata\",
	COUNT(appointments.user_id) as \"broj_pregleda\",
	SUM(medicines.price) AS \"troskovi_lekova\",
	SUM(therapies.price) AS \"troskovi_terapija\"
        FROM appointments
        INNER JOIN users ON appointments.user_id = users.user_id
        INNER JOIN invoices ON invoices.appointment_id = appointments.appointment_id
        INNER JOIN treatments ON invoices.invoice_id = treatments.invoice_id
        LEFT JOIN medicines ON treatments.medicine_id = medicines.medicine_id
        LEFT JOIN therapies ON treatments.therapy_id = therapies.therapy_id
        WHERE appointments.start_time > DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY
	appointments.user_id")->fetchAll();

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
        <table id="myTable" class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr style="cursor:pointer">
                        <th onclick="sortTable(0);">Doktor</th>
                        <th onclick="sortTable(1);">Plata</th>
                        <th onclick="sortTable(2);">Broj pregleda</th>
                        <th onclick="sortTable(3);">Troškovi lekova</th>
                        <th onclick="sortTable(4);">Troškovi pregleda</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($query as $row) {
                    echo ' <tr>' .
                        '<td>' . $row['surname'] . ' ' . $row['forename'] . '</td>' .
                        '<td>' . $row['plata'] . '</td>' .
                        '<td>' . $row['broj_pregleda'] . '</td>' .
                        '<td>' . $row['troskovi_lekova'] . '</td>' .
                        '<td>' . $row['troskovi_terapija'] . '</td>' .
                        '</tr>';
                }
                ;

            ?>
                </tbody>
            </table>

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
	// fill the array with values from the table
	for(i = 0; i < rlen; i++)
	{
		cells = rows[i].cells;
		clen = cells.length;
		arr[i] = new Array();
		for(j = 0; j < clen; j++) { arr[i][j] = cells[j].innerHTML; }
	}
	// sort the array by the specified column number (col) and order (asc)
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


</script>