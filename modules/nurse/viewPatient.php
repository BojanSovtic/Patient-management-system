<?php
    if(!isset($_SESSION['patient'])) {
        $_SESSION['message'] = "Molimo odaberite pacijenta!";
        header("Location: ./index.php?modul=home");
      };


?>
<div class="container">

<div class="row row-my">
<?php
    if($_SESSION['role'] == 3) {

        echo '<div class="col-lg-3">

        <h1 class="my-4">Izaberite opciju</h1>
        <div class="list-group">


        <a class="nav-link" href="./index.php?modul=home"><button type="button" class= "btn-primary btn-sm">Pretraga pacijenta</button></a><br>
        <a class="nav-link" href="./index.php?modul=createPatient"><button type="button" class= "btn-primary btn-sm">Kreiraj novi karton</button></a><br>
        <a class="nav-link" href="./index.php?modul=viewPatient"><button type="button" class= "btn-primary btn-sm" >Informacije o pacijentu</button></a><br>
        </div>

    </div>';

    };
?>


        <div class="col-lg-9">
            <table class="table table-striped">
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tr>
                    <th scope="row">Ime</th>
                    <td><?php echo  $_SESSION['patient']['name'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Prezime</th>
                    <td><?php echo  $_SESSION['patient']['surname'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Datum rođenja</th>
                    <td><?php echo  $_SESSION['patient']['date_of_birth'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Pol</th>
                    <td><?php echo  $_SESSION['patient']['gender'] ?></td>
                </tr>
                <tr>
                    <th scope="row">JMBG</th>
                    <td><?php echo  $_SESSION['patient']['jmbg'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Adresa</th>
                    <td><?php echo  $_SESSION['patient']['address'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Telefon</th>
                    <td><?php echo  $_SESSION['patient']['phone'] ?></td>
                </tr>
                <tr>
                    <th scope="row">email</th>
                    <td><?php echo  $_SESSION['patient']['email'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Tip osiguranja</th>
                    <td><?php echo  $_SESSION['patient']['insurance_type'] ?></td>
                </tr>
                <tr>
                    <th scope="row">LBO</th>
                    <td><?php echo  $_SESSION['patient']['LBO'] ?></td>
                </tr>
            </table>
        </div>

        
        <div class="row">


        </div>


    </div>


</div>
