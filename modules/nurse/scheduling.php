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

        <h1 class="my-4">Izaberi opciju</h1>
        <div class="list-group">
        

        <select id="doctorSchedule" name="doctorSchedule" class="form-control">';
            
        try {
            require 'core/db.php';

            $db = new db();

            if(isset($_SESSION['doctor'])) {
              $id = $_SESSION['doctor'];
              $query = $db->query('SELECT forename, surname FROM `users` WHERE user_id = ?', $_SESSION['doctor'])->fetchArray();
              $doctorForename = $query['forename'];
              $doctorSurname = $query['surname'];
              echo "<option value=\"$id\">" . $doctorForename . " " . $doctorSurname . "</option>";
            } 

            $query = $db->query('SELECT user_id, forename, surname FROM `users` WHERE role_id = 5')->fetchAll();

            foreach ($query as $item) {
                $id = $item['user_id'];
                $forename = $item['forename'];
                $surname = $item['surname'];
                echo "<option value=\"$id\">" . $forename . " " . $surname . "</option>";
            }
            $db->close();

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        echo '</select>
        <button class= "btn-primary btn-sm" onclick="showSchedule();">Prikaži termine</button>


        <a class="nav-link" href="./index.php?modul=home"><button type="button" class= "btn-primary btn-sm">Pretraga pacijenta</button></a><br>
        <a class="nav-link" href="./index.php?modul=createPatient"><button type="button" class= "btn-primary btn-sm">Kreiraj novi karton</button></a><br>
        <a class="nav-link" href="./index.php?modul=viewPatient"><button type="button" class= "btn-primary btn-sm" >Informacije o pacijentu</button></a><br>
        </div>

    </div>';

    };


    ?>      

          <div class="col-lg-9">
            <?php
                if(isset($_SESSION['doctor'])) { 
                    echo "<p id=\"terminiDoktor\">Termini za doktora:  <strong>" . $doctorForename . '   ' . $doctorSurname . "</strong></p>";
                    } 
            ?>
            <div id='calendar'></div>
          </div>
        <div class="row">
            <?php

            ?>

        </div>


    </div>


</div>



<script>
   
   $(document).ready(function() {
    var doctor = $("#doctorSchedule").find(":selected").val();
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     header:{
      left:'prev,next today',
      center:'title',
      right:'agendaWeek,agendaDay'
     },
     defaultView: 'agendaWeek',
     buttonText: {
         today : 'danas',
         month : 'mesec',
         week : 'nedelja',
         day : 'dan'
     },
     dayNamesShort: ['Ned', 'Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub'],
     slotLabelFormat: "HH:mm",
     allDaySlot: false,
     validRange: function(nowDate) {
         return {
             start : nowDate
         };
     },
     minTime: '07:00',
     maxTime: '19:00',
     slotDuration: '00:15:00',
     slotLabelInterval: 15,
     events: {
         url: 'modules/nurse/loadApp.php',
         type: 'POST',
         data: {
            doctor : doctor
         }
     },
     selectable:true,
     selectHelper:true,
     select: function(start, end)
     {
      var title = '';
      if(confirm("Da li zelite da zakazete?"))
      {
       doctor = $("#doctorSchedule").find(":selected").val();
       var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
       var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
       $.ajax({
        url:"modules/nurse/insertApp.php",
        type:"POST",
        data:{title:title, start:start, end:end, doctor:doctor},
        success:function()
        {
         calendar.fullCalendar('refetchEvents');
         location.reload();
         alert("Pacijent uspešno zakazan");
        }
       })
      }
     },
     editable:true,
 
     eventClick:function(event)
     {
      if(confirm("Da li želite da obrišete?"))
      {
       var id = event.id;
       $.ajax({
        url:"modules/nurse/deleteApp.php",
        type:"POST",
        data:{id:id},
        success:function()
        {
         calendar.fullCalendar('refetchEvents');
         alert("Pregled otkazan");
        }
       })
      }
     },
 
    });
   });

   function showSchedule() {
        var doctor_id = $("#doctorSchedule").find(":selected").val();
        $.ajax({
            url: 'modules/nurse/loadApp.php',
            type: "POST",
            data: { doctor_id : doctor_id },
            succes: function(data){
                alert(data);
            }
        })
        location.reload();
   };
    
   </script>