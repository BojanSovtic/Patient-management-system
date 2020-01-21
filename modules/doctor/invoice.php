<div class="container">

<div class="row row-my">
<?php
if ($_SESSION['role'] == 5) {
    echo '<div class="col-lg-3">

             <h1 class="my-4">Izaberite opciju</h1>
             <div class="list-group">

             <a class="nav-link" href="./index.php?modul=doctorSchedule"><button type="button" class= "btn-primary btn-sm">Termini</button></a><br>
             <a class="nav-link" href="#"><button type="button" class= "btn-primary btn-sm">Istorija pacijenata</button></a><br>
             </div>

         </div>';
}
;

try {
    require 'core/db.php';

    $db = new db();

    $id = $_GET['id'];

    $query = $db->query('SELECT patients.patient_id, name, surname, jmbg
             FROM appointments
             INNER JOIN patients ON appointments.patient_id = patients.patient_id
             WHERE appointment_id = ?', $id)->fetchAll();

    $_SESSION['patient'] = $query[0];

    if (!empty($_POST) && ($_POST['medicine'] != '' || $_POST['therapy'] != '')) {

        $diagnoseCode = $_POST['diagnoseCode'];
        $query = $db->query('SELECT diagnose_id FROM diagnoses WHERE code = ?', $diagnoseCode)->fetchArray();
        $diagnose_id = $query['diagnose_id'];
        $note = $_POST['note'];
        $db->query('INSERT INTO invoices (diagnose_id, notes, appointment_id)
                        VALUES (?, ?, ?)', $diagnose_id, $note, $id);

        $query = $db->query('SELECT invoice_id FROM invoices WHERE appointment_id = ?', $id)->fetchArray();
        $invoice_id = $query['invoice_id'];

        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 3) === 'med' && $value != '') {
                $db->query('INSERT INTO treatments (invoice_id, medicine_id)
                        VALUES (?, ?)', $invoice_id, $value);
            } elseif (substr($key, 0, 3) === 'the' && $value != '') {
                $db->query('INSERT INTO treatments (invoice_id, therapy_id)
                        VALUES (?, ?)', $invoice_id, $value);
            }

        }

        $query = $db->query('UPDATE appointments SET status = "finished" WHERE appointment_id = ?', $id);
        $_SESSION['message'] = "Faktura uspešno uneta!";
        header("Location: ./index.php?modul=doctorSchedule");
    } else {
        $message = 'Molimo popunite podatke!';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>

    <div class="col-lg-9">


<form method="post">
                <div class="form-row">
                     <div class="col">
                     <div class="diagnoses">
                        <label for="diagnose">Dijagnoza: </label>
                        <input type="text" id="searchDig" name="diagnoseCode" class="form-control">
                        <div id="resultDig"></div>
                        </div>
                        <div class="notes">
                        <label for="note">Unos beleške: </label><br>
                        <textarea rows="5" cols="50" name="note"></textarea>
                        </div>
                     <div class="invoices">
                        <label for="medicine">Lek: </label>
                        <select name="medicine" class="form-control">
                        <option value="">Izaberite lek</option>
                        <?php
try {
    // $starttime = microtime($time);
    $query = $db->query('SELECT medicine_id, `name`, utilization, manufacturer FROM medicines ORDER BY `name`')->fetchAll();

    foreach ($query as $item) {
        $id = $item['medicine_id'];
        $name = $item['name'];
        $utilization = $item['utilization'];
        $manufacturer = $item['manufacturer'];

        echo "<option value=\"$id\">" . $name . "  " . $utilization . "  " . $manufacturer . "</option>";
    }
    // $endtime = microtime(true);
    // $duration = $endtime - $starttime;
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
                        </select>
                        </div>
                        <button class="add_form_field btn-primary btn-sm">Dodaj lek</button>
                        <br>
                        <div class="therapies">
                            <label for="therapy">Terapija: </label>
                            <select name="therapy" class="therapy form-control">
                            <option value="">Izaberite terapiju</option>
                            <?php
try {
    $queryTh = $db->query('SELECT therapy_id, `description`, price FROM therapies ORDER BY `description`')->fetchAll();

    foreach ($queryTh as $item) {
        $therapy_id = $item['therapy_id'];
        $description = $item['description'];
        $price = $item['price'];

        echo "<option value=\"$therapy_id\">" . $description . "</option>";
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>

                            </select>
                            </div>
                            <button class="add_form_field_therapy btn-primary btn-sm">Dodaj terapiju</button>
                        </div>

                    </div>
                    <div class="text-right">
                            <input type="submit" value="Unesi fakturu" class="btn btn-primary">
                            <button type="button" value="<?php echo $_GET['id']; ?>" class="btn btn-primary cancelInvoice">Otkaži pregled</button>
                        </div>

                        <?php
                        $db->close();

                        
                
echo $message . "    ";
 ?>

                </div>




            </form>
    </div>


        <div class="row">

        </div>


    </div>


</div>

<script>
    $(document).ready(function() {
    var max_fields = 10;
    var wrapper = $(".invoices");
    var wrapper2 = $(".therapies");
    var add_button = $(".add_form_field");
    var add_button2 = $('.add_form_field_therapy')

    var x = 1;
    var data = <?php echo json_encode($query); ?>;
    var data2 = <?php echo json_encode($queryTh); ?>;

    $(add_button).click(function(e) {
        e.preventDefault();

        if (x < max_fields) {
            x++;
            var target = '<br><div><select name="medicine' + x + '" class="medicine form-control"><option value="">Izaberite lek</option>';

            for (var i = 0; i < data.length; i++) {
                target += '<option value =" ' + data[i]['medicine_id'] + '">' + data[i]['name'] + '   ' + data[i]['utilization'] 
                + '   ' + data[i]['manufacturer'] + '</option>';
            }

            target += '</select><a href="#" class="delete">Obriši</a></div>';
            $(wrapper).append(target)
        } else {
            alert('Maksimum je 10 usluga!')
        }
    });


    $(add_button2).click(function(e) {
        e.preventDefault();

        if (x < max_fields) {
            x++;
            var target = '<br><br><div><select name="therapy' + x + '" class="therapy form-control"><option value="">Izaberite terapiju</option>';

            for (var i = 0; i < data2.length; i++) {
                target += '<option value =" ' + data2[i]['therapy_id'] + '">' + data2[i]['description'] + ' Cena:  ' + data2[i]['price'] 
                + '</option>';
            }

            target += '</select><a href="#" class="delete">Delete</a></div>';
            $(wrapper2).append(target)
        } else {
            alert('Maksimum je 10 usluga!')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    $(wrapper2).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    load_data();

function load_data(query)
       {
       $.ajax({
       url:"modules/doctor/searchDiagnose.php",
       method:"POST",
       data:{query:query},
       success:function(data)
       {
           $('#resultDig').html(data);
       }
       });
       }
       $('#searchDig').keyup(function(){
       var search = $(this).val();
       if(search != '')
       {
       load_data(search);
       }
       else
       {
       load_data();
       }
       });

});

$(document).on('click', '.pickDiagnose', function() {
        var button = this;
        var text = this.id;

        $('#searchDig').val(text);
    });

    $(document).on('click', '.cancelInvoice', function() {
        if(confirm("Da li želite da obrišete pregled?")) {
        var button = this;
        var id = $(this).val();

        $.ajax( {
            url: 'modules/doctor/cancelAppointment.php',
            method: 'POST',
            data : {
                id : id
            },
            success:function()
        {
            location.href = "./index.php?modul=doctorSchedule";
        }
    })
}

    });

</script>


