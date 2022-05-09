<?php
//Calling Session
session_start();

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

// Database linking
require 'db_inc.php';

//Obtain Session Info


// Select Database
mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));

//If Location Not On Call
if(isset($_GET['doctorname'])){
  $dname = $_GET['doctorname'];
  //SQL Obtain Query From doctor Table
  $Obtainsql = "SELECT `id`, `doctor_name`, `expertise`, `working_hours`, `location_map`, `location_name`, `doctor_image`, `education`, `credentials`, `language` FROM `doctor` WHERE `doctor_name` = '{$dname}'";
  $result = mysqli_query($db,$Obtainsql);
  $rows = mysqli_num_rows($result);

  if ($rows==1){
      while($rs = mysqli_fetch_array($result)){
          $id = $rs["id"];
          $name = $rs["doctor_name"];
          $expertise = $rs["expertise"];
        // $days = $rs["working_days"];
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

if(isset($_GET['location'])){
  $dlocation = $_GET['location'];
  //SQL Obtain Query From doctor Table
  $Obtainsql = "SELECT `id`, `doctor_name`, `expertise`, `working_hours`, `location_map`, `location_name`, `doctor_image`, `education`, `credentials`, `language` FROM `doctor` WHERE `location` = '$dlocation'";
  $result = mysqli_query($db,$Obtainsql);
  $rows = mysqli_num_rows($result);

  if ($rows==1){
      while($rs = mysqli_fetch_array($result)){
          $id = $rs["id"];
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

//Appointment Button on Click
if(isset($_POST['appointment'])){
  header("Location: Appointment.php?doctorname=$dname");
}



?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Doctor's Info Page</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" integrity="sha512-doJrC/ocU8VGVRx3O9981+2aYUn3fuWVWvqLi1U+tA2MWVzsw+NVKq1PrENF03M+TYBP92PnYUlXFH1ZW0FpLw==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="Css/DoctorPage.css">
  <!--Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/64f2ee7544.js" crossorigin="anonymous"></script>

    <!-- Additional CSS  -->
  <link rel="stylesheet" href="Css/Chat.css">
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  <link rel="stylesheet" href="Css/DoctorPage.css">

  <!-- Ajax -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>

  <!-- Button JS -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>

<body>
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
      </div>
    </div>
</nav>    
    
<div id="content" class="container w-75 p-3">
  <div class="container-fluid">   
    <div class="row">
        <br>
        <!-- Image -->
      <div id="col-left" class="col-xxl-4 col-xl-6 col-lg-6">
        <img src="<?php echo $image; ?>" class="box-img" height="355px" width="auto" alt="">  
      </div>
   
      <!-- Details -->
      <div class="col-xxl-8 col-xl-6 col-lg-6">
        <div class="justify-content-center text-center">       
          <br>
          <h1><b><?php echo $name; ?></b></h1>
          <br>
          <h4><b><?php echo $expertise; ?></b></h4>
          <br>
          <p><b><?php echo $name; ?> is a <?php echo $expertise; ?> currently operating in <?php echo $location_name; ?>.</b></p>

        </div>    
      </div>
    </div>

    <!-- Options -->
    <div class="row">
    <br><br>
        <!-- Button -->
        <ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-appointment-tab" data-bs-toggle="pill" data-bs-target="#pills-appointment" type="button" role="tab" aria-controls="pills-appointment" aria-selected="false">Appointment</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-location-tab" data-bs-toggle="pill" data-bs-target="#pills-location" type="button" role="tab" aria-controls="pills-location" aria-selected="false">Location</button>
        </li>
        </ul>

          <div class="tab-content" id="pills-tabContent" style="margin-left: auto;margin-right: auto;">
            <!--Profile--> 
            <div class="tab-pane fade show active justify-content-left" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <!-- Create Extra Space -->
                    <div class="col-3"></div>
                    <!-- Education Column -->
                    <div class="col-3">                       
                        <h4><b>Education</b></h4>
                        <p>
                        <ul style="list-style-type:square;">
                            <li style="margin-left: auto;margin-right: auto;"><?php echo $education; ?></li>
                        </ul>
                        </p>
                        <br>
                        <h4><b>Credentials</b></h4>
                        <table >
                            <tr>
                            <td >Qualifications</td>
                            <td>: <?php echo $credentials_split[0]; ?></td>
                            </tr>
                            <tr>
                            <td>Medical Registration Number</td>
                            <td>: <?php echo $credentials_split[1]; ?></td>
                            </tr>
                        </table>
                        <br>
                        <h4><b>Language</b></h4>
                        <p><?php echo $language; ?></p>
                    </div>

                    <!-- Services Column -->
                    <div class="col-4">
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
                    <!-- Create Extra Space -->
                    <div class="col-2"></div>
                </div>
            </div>

            <!-- Appointment -->
            <div class="tab-pane fade" id="pills-appointment" role="tabpanel" aria-labelledby="pills-appointment-tab" style="margin-left: auto;margin-right: auto;">
              <div class="row">
                  <!-- Create Extra Space -->
                  <div class="col-3"></div>
                  <!-- Services Hour Column -->
                  <div class="col-3">
                    <h4><b>Hours</b></h4>
                    <table style="width: 100%">
                        <colgroup>
                        <col span="1" style="width: 30%" />
                        <col span="1" style="width: 70%" />
                        </colgroup>
                        <tr>
                        <td><b>Mon</b></td>
                        <td><?php echo $hours_split[0]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Tue</b></td>
                        <td><?php echo $hours_split[1]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Wed</b></td>
                        <td><?php echo $hours_split[2]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Thurs</b></td>
                        <td><?php echo $hours_split[3]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Fri</b></td>
                        <td><?php echo $hours_split[4]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Sat</b></td>
                        <td><?php echo $hours_split[5]; ?></td>
                        </tr>
                        <tr>
                        <td><b>Sun</b></td>
                        <td><?php echo $hours_split[6]; ?></td>
                        </tr>
                        <tr>
                        <td><b>PH</b></td>
                        <td><?php echo $hours_split[7]; ?></td>
                        </tr>
                        <tr>
                        <td><b>*Break Time</b></td>
                        <td><?php echo $hours_split[8]; ?></td>
                        </tr>
                    </table>

                  </div>
                  <!-- Appointment Column -->
                  <div class="col-4">
                    <form action="" method="POST"> 
                      <div class="card-body text-center">

                      <?php
                        $dname = $_GET['doctorname'];
                        $sql="SELECT * FROM doctor WHERE `doctor_name` = '{$dname}'";
                        $result=$db->query($sql);
                        while($row=$result->fetch_assoc()){
                      ?>

                       <!--Not Logged In -->                   
                      <?php  if (isset($_SESSION['username'])) : ?>
                        <h4 style="margin-left: auto;margin-right: auto;"><b>Make An Appointment</b></h4>
                        <button class="btn btn-danger" href = "Appointment.php?doctorname=<?= $row['doctor_name']; ?>" type="submit" name = "appointment"><i class="fa-solid fa-check fa-fw"></i>Make Appointment!</button>    
                      <?php endif ?>

                      <?php } ?>
                      </div>

                   </form>                                                                
                  </div>
                  <!-- Create Extra Space -->
                  <div class="col-2"></div>
              </div>
            </div>


            <!-- Location -->
            <div class="tab-pane fade" id="pills-location" role="tabpanel" aria-labelledby="pills-location-tab">
              <div class="justify-content-center text-center">
                <h4><b>Location</b></h4>
                <p><iframe src="<?php echo $location; ?>" width="440" height="340" style="border:0;" allowfullscreen=""
                    loading="lazy"></iframe></p>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>
    
    
<!-- Chat -->
<div class="chat-bar-collapsible"><?php  if (isset($_SESSION['username'])) : ?>
    <button id="chat-button" type="button" class="collapsible">
      <i class="fa fa-commenting-o comment"></i>
    </button>
    <div class="content" style ="z-index:1;"><?php  if (isset($_POST["chatbtn"])){echo "<div class='collapsible'></div>";} ?>
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


<script type="text/javascript">
  $(document).ready(function(){

    $(".doctor_check").click(function(){
      var action = 'data';
      var expertise = get_filter_text('expertise');
      //var working_days = get_filter_text('working_days');
      var location = get_filter_text('location');

      $.ajax({
        url:'EditDoctorAction.php',
        method:'POST',
        data:{action:action,expertise:expertise:location:location},
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
</body>

</html>

