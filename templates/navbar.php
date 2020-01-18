<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">SZUP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php
if (isset($_SESSION['patient']) && $_SESSION['patient'] != '') {
    echo '<p id="patientInfo">Pacijent:  <strong>' . $_SESSION['patient']['name'] .
        ' ' . $_SESSION['patient']['surname'] .
        '</strong>  JMBG:   <strong>' . $_SESSION['patient']['jmbg'] . '</strong></p>';
}
;
?>
      <div class="collapse navbar-collapse" id="navbarResponsive">
      <?php

if ($_SESSION['role'] != '') {
    echo '<ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="./index.php?modul=home">Početak</a>
        </li>';
    if ($_SESSION['role'] == '3') {
        echo '<li class="nav-item">
            <a class="nav-link" href="./index.php?modul=viewPatient">Karton</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./index.php?modul=scheduling">Zakazivanje</a>
          </li>';
    }
    if ($_SESSION['role'] == '5') {
        echo '<li class="nav-item">
            <a class="nav-link" href="./index.php?modul=doctorSchedule">Fakturisanje</a>
          </li>';
    }
    if ($_SESSION['role'] == '7' || $_SESSION['role'] == '9') {
        echo '<li class="nav-item">
            <a class="nav-link" href="./index.php?modul=reports">Izveštaji</a>
          </li>';
    }
    echo '<li class="nav-item">
            <a class="nav-link" href="./index.php?modul=logout">Kraj rada</a>
          </li>
        </ul>';
}
?>
      </div>

    </div>
  </nav>