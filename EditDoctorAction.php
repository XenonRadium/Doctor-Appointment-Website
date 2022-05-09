<?php
    //Calling Session
    session_start();

    //Setting to Malaysia time zone
    date_default_timezone_set("Asia/Kuala_Lumpur");

    // Database linking
    require 'db_inc.php';

    // Select Database
    mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));

    if(isset($_POST['action'])){
      $sql = "SELECT * FROM doctor WHERE expertise != ''";

      if(isset($_POST['expertise'])){
        $expertise = implode("','", $_POST['expertise']);
        $sql .="AND expertise IN('".$expertise."')";
      }
      if(isset($_POST['working_days'])){
        $sql = "SELECT * FROM doctor INNER JOIN working_days ON doctor.id = working_days.doctorID ";
        $working_days = implode("','", $_POST['working_days']);
        $sql .="AND working_days IN ('".$working_days."') GROUP BY doctor_name;";
      }
      if(isset($_POST['location'])){
        $location = implode("','", $_POST['location']);
        $sql .="AND location IN('".$location."')";
      }

      $result = $db->query($sql);
      $output='';

      
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $output .='
          <div class="col-md-3 mb-2">
            <div class="card-deck" style="margin: 0 0 40px 0;">
              <div class="card border-secondary">
                <img src="'.$row['doctor_image'].'" class="card-img-top">
                <div class="card-body">
                  <h4 style="height:60px;">'.$row['doctor_name'].'</h4>
                  <h6>'.$row['expertise'].'</h6>
                  <a href="DoctorPage.php?doctorname='.$row['doctor_name'].'" class="btn btn-primary btn-sm mt-auto d-flex flex-column">Profile</a>          
                  <a href="Appointment.php?doctorname='.$row['doctor_name'].'" class="btn btn-primary btn-sm mt-3 d-flex flex-column">Book Appointment</a>
                </div>
              </div>
            </div>
          </div>';
          
        }
      }
      else{
        $output = "<h3>No doctors found</h3>";
      }
      echo $output;
    }
?>