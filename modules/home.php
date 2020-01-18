
<div class="container">

    <div class="row row-my">
    <?php
if ($_SESSION['role'] == 7) {
    include 'admin/showUsers.php';
}
;

if ($_SESSION['role'] == 5) {
    echo '<div class="col-lg-3">

             <h1 class="my-4">Izaberite opciju</h1>
             <div class="list-group">

             <a class="nav-link" href="./index.php?modul=doctorSchedule"><button type="button" class= "btn-primary btn-sm">Termini</button></a><br>
             <a class="nav-link" href="./index.php?modul=patientHistory"><button type="button" class= "btn-primary btn-sm">Istorija pacijenata</button></a><br>
             </div>

         </div>';

         
}
;

if ($_SESSION['role'] == 3) {

    echo '<div class="col-lg-3">

        <h1 class="my-4">Izaberite opciju</h1>
        <div class="list-group">


        <a class="nav-link" href="./index.php?modul=home"><button type="button" class= "btn-primary btn-sm">Pretraga pacijenta</button></a><br>
        <a class="nav-link" href="./index.php?modul=createPatient"><button type="button" class= "btn-primary btn-sm">Kreiraj novi karton</button></a><br>
        <a class="nav-link" href="./index.php?modul=viewPatient"><button type="button" class= "btn-primary btn-sm" >Informacije o pacijentu</button></a><br>
        </div>

    </div>';
}

if ($_SESSION['role'] == 3 || $_SESSION['role'] == 5) {
    echo '

        <div class="col-lg-9">';

    if (!empty($_SESSION['message']) && !isset($_SESSION['patient'])) {
        echo "<div class='error'>" .
            $_SESSION['message'] . "</div>";
    }

    echo '<label for="search_text">Pretraga pacijenta</label>
        <input type="text" id="search_patient" class="form-control" name="search_text"
        placeholder="Unesite jmbg, lbo, ime ili prezime pacijenta"><br>
        <div id="result"></div>
    </div>

        ';
}
;

?>

        <div class="row">
            <?php
?>

        </div>


    </div>


</div>

<script>
    $(document).ready(function(){

 load_data();

 function load_data(query)
        {
        $.ajax({
        url:"modules/searchPatient.php",
        method:"POST",
        data:{query:query},
        success:function(data)
        {
            $('#result').html(data);
        }
        });
        }
        $('#search_patient').keyup(function(){
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

$(document).ready(function() {
    $(document).on('click', '.pickPatient', function() {
        var button = this;
        var id = this.id;

        $.ajax( {
            url: 'modules/pickPatient.php',
            method: 'POST',
            data : {
                id : id
            }
        });
        location.reload();
    });
});
</script>

