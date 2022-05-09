<?php

//Calling Session
session_start();

// Database linking
require 'db_inc.php';

//Send Mail function php file
include 'SendMail.php';

// PDF
require "tcpdf_min/tcpdf.php";
require "PDFGenerator.php";

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

//Time 
$t=time();

// Vars
$errors = array();

//SQL Obtain Query From User Table
$Obtainsql = "SELECT `userId`, `userFirstName`, `userLastName`, `userDobDay`, `userGender`, `userPassword`, `userEmail` FROM `usertable` WHERE `userEmail` = '{$_SESSION["username"]}'";
$result = mysqli_query($db,$Obtainsql);
$rows = mysqli_num_rows($result);

if ($rows == 1){
  while($rs = mysqli_fetch_array($result)){ 
    $uid = $rs["userId"];
    $email = $rs["userEmail"];
    $firstname =$rs["userFirstName"];
    $lastname=$rs["userLastName"];
  }
}


if(isset($_POST['Submit'])){

  $pdf = new PDFGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  $pdf->setFontSubsetting(true);
  
  //Time 
  $t=time();

  // start a new page
  $pdf->AddPage();
  
  // date and invoice no
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>DATE:</b>".date("Y-m-d",$t));
  $pdf->writeHTML("<b>HISTORY</b>");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  
  // address
  $pdf->writeHTML("Jalan Kontraktor U1/14,");
  $pdf->writeHTML("Seksyen U1, Glenpark U1,");
  $pdf->writeHTML("40150 Shah Alam,");
  $pdf->writeHTML("Selangor,");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  
  // bill to
  $pdf->writeHTML("<b>BILL TO:</b>", true, false, false, false, 'R');
  $pdf->writeHTML($_SESSION["username"], true, false, false, false, 'R');

  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  
  // invoice table starts here

  $header = array('NO','DATE', 'TIME', 'LOCATION', 'SERVICES', 'DOCTOR NAME');

  $sql="SELECT * FROM appointment WHERE `user_id` = '$uid'";
  $result=$db->query($sql);
  $increment = 0;

  // loop all data and display
  while($row=$result->fetch_assoc()){

      $data = array(
      array($increment+=1,$row['date'], $row['time'], $row['location'], $row['services'], $row['doctor_name']),
      );
      $pdf->printTable($header, $data);
      $pdf->Ln();
  }

  // comments
  $pdf->SetFont('', '', 12);
  $pdf->Write(0, "\n\n\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("If you have any questions about this invoice, please contact:", true, false, false, false, 'C');
  $pdf->writeHTML("Team 2 Medical Centre at 0131535@kdu-online.com +603 1234 5678", true, false, false, false, 'C');
  
  // save pdf file
  $pdf->Output(__DIR__ . '/'.$_SESSION["username"].'.pdf', 'F');

  // Toast MSG
  $info = "PDF Downlaoded.";
  $_SESSION['pdf'] = $info;
 
}



?>

<!--HTML -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Appointment History Page</title>

  <!-- Bootstrap 5 CSS -->
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
  <!-- Google Fonts -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap'>
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/cdfb47ba63.js" crossorigin="anonymous"></script>
  <!-- Additional CSS (Optional) -->
  <link rel="stylesheet" href="Css/NewLogIn.css">
  <link rel="stylesheet" href="Css/NewSignUp.css">
  <link rel="stylesheet" href="Css/Chat.css">
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  
  <!-- Bootstrap 5 JS -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>

  <!-- Bootstrap 4 JS -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

  <!-- Toast CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

  <!-- Ajex JS-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="Js/Responses.js"></script>
  <script src="Js/Chat.js"></script>


  <!-- Bootstrap CSS -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
  <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/datepicker.css">
  <link rel="stylesheet" href="assets/css/style.css"> -->

</head>

<!-- Java Script -->
<script>
function changeVisibility() {
  document.getElementById("imgbox2").style.visibility = "hidden";
}

function resetElement() {
  document.getElementById("imgbox2").style.visibility = "visible";
}
</script>


<body >
  <!-- Navigation -->
  <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light navbar-light shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="MainMenu.php"><b>IWD Assignment BY Team 2</b></a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
        <div class="hamburger-toggle">
          <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <div class="collapse navbar-collapse" id="navbar-content">
          <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="MainMenu.php">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link active" href="FindDoctor.php">Doctors Details</a>
            </li>
      
            <li class="nav-item active">
              <a class="nav-link active" href="Map.php">Location</a>
            </li>

            <!-- Logged In -->
            <li class="nav-item active">
                <?php  if (isset($_SESSION['username'])) : ?>
                    <a class ="nav-link active"href="AppointmentHistory.php">History</a>
                <?php endif ?>
            </li>

          </ul>
            <form class="d-flex ms-auto">
            <div class="input-group">
              <input class="form-control mr-2" type="search" name ="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-danger border-0" type="submit" name ="searchbtn">Search</button>
            </div>
          </form>
          
        </div>
          

        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
            <!-- Not Logged In -->
            <li class = "nav-item"><?php  if (!isset($_SESSION['username'])) : ?><a class ="nav-link" href="LogIn.php">Login</a><?php endif ?></li>
            <li class = "nav-item"><?php  if (!isset($_SESSION['username'])) : ?><a class ="nav-link"href="SignUp.php">Sign Up</a><?php endif ?></li>
            
            <!-- Logged In -->
            <li class = "nav-item"><?php  if (isset($_SESSION['username'])) : ?><a class ="nav-link"href="EditProfile.php">Settings</a><?php endif ?></li>

        </ul>
    </nav>    

    

    <!-- Booking -->
    <div class="sign-up-form" style="width:90%; z-index = -1;">
        <div class="form-toggle" style=" z-index = -1;"></div>
        <h1><center>History</center></h1>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Location</th>
                <th scope="col">Services</th>
                <th scope="col">Note</th>
                <th scope="col">Doctor ID</th>
                <th scope="col">Doctor Name</th>
              </tr>
            </thead>
          
            <tbody>
              <?php
                $increment = 0;
                $sql="SELECT * FROM appointment WHERE `user_id` = '$uid'";
                $result=$db->query($sql);
                while($row=$result->fetch_assoc()){
                  
              ?>
                <tr>
                  <th scope="row"><?= $increment+=1;; ?></th>
                  <td><?= $row['date']; ?></td>
                  <td><?= $row['time']; ?></td>
                  <td><?= $row['location']; ?></td>
                  <td><?= $row['services']; ?></td>
                  <td><?= $row['note']; ?></td>
                  <td><?= $row['doctor_id']; ?></td>
                  <td><?= $row['doctor_name']; ?></td>
                
                </tr>

                
              <?php } ?>          
            </tbody>
          </table>

          <!-- Submit Button -->
          <form method = "POST" action ="" >
           <!-- Save changes button-->
            <div class="card-body text-center">
                <button class="btn btn-danger" type="submit" href ="EditProfile.php?Submit=true" name = "Submit"><i class="fa fa-file-pdf-o fa-fw"></i>View In PDF</button>
            </div> 
          </form>  

          <!-- Successful Toast -->
          <?php 
            if(isset($_SESSION['pdf'])){
                ?>
                <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                    <?php echo $_SESSION['pdf']; ?>
                </div>
                <?php
            }
          ?>

          <!-- Error Toast -->
          <?php
            if(count($errors) > 0){
                ?>
                <div class="alert alert-danger text-center">
                    <?php 
                        foreach($errors as $error){
                            echo $error;
                        }
                    ?>
                </div>
                <?php
            }
          ?>
        </div>
    </div>

      <!-- Chat -->
  <div class="chat-bar-collapsible" style ="z-index:2;" ><?php  if (isset($_SESSION['username'])) : ?>
    <button id="chat-button" type="button" class="collapsible">
      <i class="fa fa-commenting-o comment"></i>
    </button>
    <div class="content" style ="z-index:2;"><?php  if (isset($_POST["chatbtn"])){echo "<div class='collapsible'></div>";} ?>
      <div class="header">
        <h6>Let's Chat - Online</h6>
      </div>
      <div class="full-chat-block">
        <!-- Message Container -->
        <div class="outer-container">
          <div class="chat-container">
            <div id="chatbox">
              <h5 id="chat-timestamp"></h5>
              <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
            </div>

            <div class="chat-bar-input-block">
              <div id="userInput">
                <input id="textInput" class="input-box" type="text" name="msg" placeholder="Tap 'Enter' to send a message">
                <p></p>
              </div>

              <div class="chat-bar-icons">
                <i id="chat-icon" style="color: #333;" class="fa fa-fw fa-send" onclick="sendButton()"></i>
              </div>

            </div>

            <div id="chat-bar-bottom">
              <p></p>
            </div>

          </div>
        </div>
      </div>
    </div>
      <?php endif ?>
  </div>
  
  <br><br>
<!-- Footer -->
<div class="container-fluid">
  <footer id="Footer" class="row row-cols-5 px-5 py-5 ">
    <div class="col">
      <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#" />
        </svg>
      </a>
      <p class="text-muted">&copy; 2021</p>
    </div>

    <div class="col">

    </div>
    
    <!-- Section -->
    <div class="col">
      <h5><b>Section</b></h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="MainMenu.php" class="nav-link p-0 text-muted">Home</a></li>
        <li class="nav-item mb-2"><a href="Map.php" class="nav-link p-0 text-muted">FAQs</a></li>
        <li class="nav-item mb-2"><a href="Map.php" class="nav-link p-0 text-muted">About</a></li>
      </ul>
    </div>

    <!-- Location -->
    <div class="col">
      <h5><b>States</b></h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="TestDoctorPage.php?location=Johor" class="nav-link p-0 text-muted">Johor</a></li>
        <li class="nav-item mb-2"><a href="TestDoctorPage.php?location=Melaka" class="nav-link p-0 text-muted">Melaka</a></li>
        <li class="nav-item mb-2"><a href="TestDoctorPage.php?location=Penang" class="nav-link p-0 text-muted">Penang</a></li>
        <li class="nav-item mb-2"><a href="TestDoctorPage.php?location=Perak" class="nav-link p-0 text-muted">Perak</a></li>
        <li class="nav-item mb-2"><a href="TestDoctorPage.php?location=Selangor" class="nav-link p-0 text-muted">Selangor</a></li>
      </ul>
    </div>

    <!-- About Us -->
    <div class="col">
      <h5><b>About Us</b></h5>
      <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="Map.php#about" class="nav-link p-0 text-muted">Our Information</a></li>
      </ul>
    </div>
  </footer>
    
</div>

<!-- Optional JavaScript -->

<script type="text/javascript">
  $(document).ready(function(){

    // Appointment Date Limit
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#date').attr('min',today);

    //Time Dropdown
    $('.select2').select2();
    
    $(".doctor_check").click(function(){
      var action = 'data';
      var expertise = get_filter_text('expertise');
      var working_days = get_filter_text('working_days');
      var location = get_filter_text('location');

      $.ajax({
        url:'EditDoctorAction.php',
        method:'POST',
        data:{action:action,expertise:expertise,working_days:working_days,location:location},
        success:function(response){
          $("#result").html(response);
          $("#textChange").text("Filtered Selections");
        }
      });
    });

    function get_filter_text(text_id){
      var filterData = [];
      $('#'+text_id+':checked').each(function(){
        filterData.push($(this).val());
      });
      return filterData;
    }
    
    var coll = document.getElementsByClassName("collapsible");

    for (let i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");

            var content = this.nextElementSibling;

            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }

        });
    }

    function getTime() {
        let today = new Date();
        hours = today.getHours();
        minutes = today.getMinutes();

        if (hours < 10) {
            hours = "0" + hours;
        }

        if (minutes < 10) {
            minutes = "0" + minutes;
        }

        let time = hours + ":" + minutes;
        return time;
    }

    // Gets the first message
    function firstBotMessage() {
        let firstMessage = "Hi, how can I help you? <br> <br> 1. View appointment <br> 2. View doctor details <br> 3. Find nearest doctor"
        document.getElementById("botStarterMessage").innerHTML = '<p class="botText"><span>' + firstMessage + '</span></p>';

        let time = getTime();

        $("#chat-timestamp").append(time);
        document.getElementById("userInput").scrollIntoView(false);
    }

    firstBotMessage();

    // Retrieves the response
    function getHardResponse(userText) {
        let botResponse = getBotResponse(userText);
        let botHtml = '<p class="botText"><span>' + botResponse + '</span></p>';
        $("#chatbox").append(botHtml);

        document.getElementById("chat-bar-bottom").scrollIntoView(true);
    }

    //Gets the text text from the input box and processes it
    function getResponse() {
        let userText = $("#textInput").val();

        if (userText == "") {
            userText = "";
        }

        let userHtml = '<p class="userText"><span>' + userText + '</span></p>';

        $("#textInput").val("");
        $("#chatbox").append(userHtml);
        document.getElementById("chat-bar-bottom").scrollIntoView(true);

        setTimeout(() => {
            getHardResponse(userText);
        }, 1000)
    }

    function sendButton() {
        getResponse();
    }

    // Press enter to send a message
    $("#textInput").keypress(function (e) {
        if (e.which == 13) {
            getResponse();
        }
    });
    
    
    function getBotResponse(input) {
    //Simple responses
      switch (input){
        case "hello": case "hi": case "sup": case "HI": case "Hi":
          return "Hello there!";
          break;
        case "bye": case "goodbye": case "bye bye": case "ciao":
          return "Talk to you later!";
          break; 
        case "doctor": case "Help": case "help": case "see doctor": case "details":
          var link = str.link("FindDoctor.php");
          return "Click here to view doctor details! > "+link;
          break;     
        case '1':
          var str = "Appointment";
          var link = str.link("AppointmentHistory.php");
          return "Click here to view appointment! > "+link;
          break;
        case '2':
          var str = "Doctor Information";
          var link = str.link("FindDoctor.php");
          return "Click here to view doctor details! > "+link;
          break;
        case '3':
          var str = "Map";
          var link = str.link("Map.php");
          return "Click here to find the doctor nearest to you! > "+link;
          break;
        default:
          return "Try asking something else!";
      }

    }

  });
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="scripts/responses.js"></script>
<script src="scripts/chat.js"></script>


</body>

</html>


