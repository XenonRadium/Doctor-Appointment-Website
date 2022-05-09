<?php

//Calling Session
session_start();

// Database linking
require 'db_inc.php';

//Send Mail function php file
include 'SendMail.php';

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

//Time 
$t=time();

//Obtain User ID
//SQL Obtain Query From User Table
$Obtainsql = "SELECT `userId`, `userFirstName`, `userLastName`, `userDobDay`, `userGender`, `userPassword`, `userEmail` FROM `usertable` WHERE `userEmail` = '{$_SESSION["username"]}'";
$result = mysqli_query($db,$Obtainsql);
$rows = mysqli_num_rows($result);

if ($rows==1){
  while($rs = mysqli_fetch_array($result)){ 
        $id = $rs["userId"];
   }
}


//Doctor Details
if(isset($_GET['doctorname'])){
  $dname = $_GET['doctorname'];
  
  //SQL Obtain Query From doctor Table
  $Obtainsql = "SELECT `id`, `doctor_name`, `expertise`, `working_hours`, `location_map`, `location_name`, `doctor_image`, `education`, `credentials`, `language` FROM `doctor` WHERE `doctor_name` = '{$dname}'";
  $result = mysqli_query($db,$Obtainsql);
  //$rows = mysqli_num_rows($result);

  if ($result){
    while($rs = mysqli_fetch_array($result)){
        $drid = $rs["id"];
        $name = $rs["doctor_name"];
        $expertise = $rs["expertise"];
        $hours = $rs["working_hours"];
        $hours_split = explode(",", $hours);
        $location = $rs["location_map"];
        $location_name = $rs["location_name"];
        $image = $rs["doctor_image"];
        $education = $rs["education"];
        $credentials = $rs["credentials"];
        $credentials_split = explode(",", $credentials);
        $language = $rs["language"];
    }
  }
}

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
    $dob=$rs["userDobDay"];
    $gender = $rs["userGender"];
    $password = $rs["userPassword"];

  }
}



//Appointment
if(isset($_POST['Submit'])){

  $txtNote = filter_input(INPUT_POST, 'note');   
  $txtDate = filter_input(INPUT_POST, 'date');   
  $txtTime = filter_input(INPUT_POST, 'time');  
  $txtService = filter_input(INPUT_POST, 'services');  


  //Connect to db
  $Updatesql ="INSERT INTO `appointment`(`id`, `date`, `time`, `location`, `note`, `doctor_id`, `user_id`, `doctor_name` , `services`) VALUES 
  ('','$txtDate','$txtTime','$location_name','$txtNote','$drid','$uid', '$name', '$txtService')";

  //Store Into DB
  $result = mysqli_query($db,$Updatesql);

  if($result == 1){
    $from_name = "Team 2 Medical Centre";        
    $from_address = "cheahyeefei@gmail.com";        
    $to_name = $firstname." ".$lastname;        
    $to_address = $email;        
    $startTime = $txtDate." ".$txtTime;       
    $endTime = $txtDate." ".$txtTime+1; 
    $subject = "Appointment";        
    $description = "Remarks PLEASE reach 30 minutes earlier to ensure smooth process during consultation.\nServices Choosen: ".$txtService."\nNote to Doctor: ".$txtNote;        
    $location = "Team 2 Medical Centre";
    sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);
    
    $info = "Contact Records Updated.";
    $_SESSION['infoProfile'] = $info;
  }

  header("location: AppointmentHistory.php");


}


?>

<!--HTML -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Appointment Page</title>

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
            <div class="row">
                <!-- Put Picture -->
                <div class="col-sm-6">
                  <div class = row>
                    <div class="col">
                      <!-- Image -->
                      <div id="col-left" class="col-xxl-4 col-xl-6 col-lg-6">
                          <img src="<?php echo $image; ?>" class="box-img" height="345px" width="auto" alt="">  
                      </div>
                    </div>
                    <div class="col-7">
                      <!-- Details -->
                      <div class="justify-content-center text-center">       
                          
                        <h1><?php echo $name; ?></h1>
                        <br>
                        <h3 style><b><?php echo $expertise; ?></b></h3>
                        <br>
                        <h6><b><?php echo $name; ?> is a <?php echo $expertise; ?> currently operating in <?php echo $location_name; ?>.</b></h6>

                        </div>    
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <!-- Details -->
                    <div class="col-left">       
                    <h4><b>Services</b></h4>
                    <p>
                    <ul style="list-style-type:square;">
                      <li>Minor Procedures</li>
                      <li>Pregnancy Test</li>
                      <li>Ultrasound</li>
                      <li>Resting ECG</li>
                      <li>Health Screening/Check Up</li>
                      <li>General Illness</li>
                      <li>Consultation</li>
                    </ul>
                    </p>
                    </div>
                    </div>
                    <div class="col">
                    <h4><b>Location</b></h4>
                      <p><iframe src="<?php echo $location; ?>" width="330" height="300" style="border:0;" allowfullscreen=""
                      loading="lazy"></iframe></p>

                    </div>
                  </div>

                </div>

                <!-- Empty Space -->
                <!-- <div class="col-sm-1"></div> -->

                <!-- Appointment  -->
                <div class="col-sm-6">
                <h1><center>BOOK APPOINTMENT</center></h1>
                    <div class="form-content">
                        <form method = "POST" action = "">
                            <div class="form-panel one">
                            
                            
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6" Style = "">
                                    <label class="username" for="inputFirstName">FIRST NAME</label>
                                    <input class="form-control" id="inputFirstName" name="inputFirstName" type="text" value="<?php echo $firstname; ?>">
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="username" for="inputLastName">LAST NAME</label>
                                    <input class="form-control" id="inputLastName" name="inputLastName" type="text" value="<?php echo $lastname; ?>">
                                </div>                              
                            </div>
                          
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (DoB)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">DATE OF BIRTH</label>
                                    <input class="form-control" id="inputFirstName" name="dob" type="text" value="<?php echo $dob; ?>">
                                </div>
                                <!-- Gender -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">GENDER</label>
                                    <input class="form-control" id="inputFirstName" name="gender" type="text" value="<?php echo $gender; ?>">
                                </div>
                            </div>

                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">EMAIL ADDRESS</label>
                                <input class="form-control" id="inputEmailAddress" name="inputEmailAddress" type="email" value="<?php echo $email; ?>">
                            </div>

                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (DoB)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">DATE</label>
                                    <input class="form-control" id="date" name="date" type="date" required="required" value="">
                                </div>

                                <!-- Form Group (Time) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">TIME</label>
                                    
                                    <select class="form-control select2" name="time">
                                      <option disabled selected>~SELECT SERVICE TIME~</option>
                                      <option>10:00 AM</option>
                                      <option>11:00 AM</option>
                                      <option>1:00 PM</option> 
                                      <option>2:00 PM</option> 
                                      <option>3:00 PM</option> 
                                      <option>4:00 PM</option> 
                                    </select>
                                     
                                </div>
                            </div>

                            <!-- Choose Option -->
                            <div class="mb-3">
                              <label class="small mb-1" for="inputFirstName">CHOOSE SERVICES</label>
                                    
                              <select class="form-control select2" name="services">
                                <option disabled selected>~SELECT SERVICE NEEDED~</option>
                                <option>MINOR PROCEDURES</option>
                                <option>PREGNANCY TEST</option>
                                <option>ULTRASOUND</option> 
                                <option>RESTING ECG</option> 
                                <option>HEALTH SCREENING/CHECK UP</option> 
                                <option>GENERAL ILLNESS</option> 
                                <option>CONSULTATION</option> 
                              </select>                            
                            </div>

                            <!-- Note -->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">NOTE TO DOCTOR</label>
                                <textarea class="form-control" type="text" placeholder="Note.." name="note"></textarea>                                
                            </div>
                                              
                            <br>
                            <p4><b>Please Check All Your Details Before Confirming</b></p4><br>
                            <p6 style="color:grey;">If your details is incorrect, please proceed to setting and update your details</p6>
                    
                            <!-- Submit Button -->
                            <div class="card-body text-center">
                            <button class="btn btn-danger" type="submit" name = "Submit" ><i class="fa-solid fa-check fa-fw"></i>Make Appointment</button>    
                            </div>  
  
                            </div>
                        </form>
                    </div>
                </div>           
            </div>    
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
        case "hello": case "hi": case "sup": case "HI":
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


