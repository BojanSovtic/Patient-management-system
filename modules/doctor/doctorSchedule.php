<?php
try {
    require 'core/db.php';

    $db = new db();

    $user_id = $_SESSION['id'];
             
    $query = $db->query('SELECT * FROM appointments WHERE user_id = ? and `status` = "pending"', $user_id)->fetchAll();
    $nefakturisani = count($query);

    $db->close();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<div class="container">

    <div class="row row-my">
    <?php

if ($_SESSION['role'] == 5) {
    echo '<div class="col-lg-3">

             <h1 class="my-4">Izaberite opciju</h1>
             <div class="list-group">

             <a class="nav-link" href="./index.php?modul=doctorSchedule"><button type="button" class= "btn-primary btn-sm">Termini</button></a><br>
             <a class="nav-link" href="./index.php?modul=patientHistory"><button type="button" class= "btn-primary btn-sm">Istorija pacijenata</button></a><br>
             </div>';

             

             if (isset($_SESSION['message'])) {
                 echo "<p><strong>" . $_SESSION['message'] . "</strong></p>";

             }
             echo "Broj nefakturisanih pregleda: " . $nefakturisani;
             

        echo '</div>';
}
;


?>

          <div class="col-lg-9">

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
     minTime: '07:00',
     maxTime: '19:00',
     slotDuration: '00:15:00',
     slotLabelInterval: 15,
     events: {
         url: 'modules/doctor/loadAppointments.php',
         type: 'POST',
         data: {
            doctor : doctor
         }
     },
     selectable:true,
     selectHelper:true,
     eventClick:function(event)
     {
      if(confirm("Da li želite da fakturišete?"))
      {
       var id = event.id;
       $.ajax({
        url:"modules/doctor/invoice.php",
        type:"POST",
        data:{id:id},
        success:function()
        {
            location.href = "./index.php?modul=invoice" + "&id=" + id;
        }
       })
      }
     },

    });
   });
   </script>