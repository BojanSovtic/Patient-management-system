
<div class="container">

<div class="row row-my">
<?php
if($_SESSION['role'] == 7) {
    echo '<div class="col-lg-3">

    <h1 class="my-4">Izaberite opciju</h1>
    <div class="list-group">

    <a class="nav-link" href="./index.php?modul=createUser"><button type="button" class= "btn-primary btn-sm">Kreiraj novog korisnika</button></a><br>
    <a class="nav-link" href="./index.php?modul=showUsers"><button type="button" class= "btn-primary btn-sm">Pogledaj korisnike</button></a><br>
    <a class="nav-link" href="./index.php?modul=deleteUser"><button type="button" class= "btn-primary btn-sm">Obriši korisnika</button></a><br>
    </div>

</div>';
 };
?>


        <div class="col-lg-9">
            <label for="search_text">Unesite email korisnika</label>
            <input type="text" id="search_text" class="form-control" name="search_text"><br>
            <div id="result"></div>
        </div>



        
        <div class="row">


        </div>


    </div>


</div>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
        {
        $.ajax({
        url:"modules/admin/fetch.php",
        method:"POST",
        data:{query:query},
        success:function(data)
        {
            $('#result').html(data);
        }
        });
        }
        $('#search_text').keyup(function(){
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
    $(document).on('click', '.delete', function() {
        var button = this;
        var email = $('#forDelete').html();
        
        $.ajax( {
            url: 'modules/admin/deleteU.php',
            method: 'POST',
            data : {
                email : email
            },
            success: function (response) {
                alert ('Korisnik uspešno obrisan!');
            }, 
            error: function (response) {
                alert(response);
            }
        });
        location.reload();
    });
});
</script>
