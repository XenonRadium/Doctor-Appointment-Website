<?php
//Calling Session
session_start();

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

// Database linking
require 'db_inc.php';

// Select Database
mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>List Of Speciality</title>

  <!-- Bootstrap 5 CSS -->
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
  <!-- Google Fonts -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap'>
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Additional CSS  -->
  <link rel="stylesheet" href="Css/Chat.css">
  <link rel="stylesheet" href="Css/MainMenuStyle.css">


  <!--JavaScript-->
  <script type="text/javascript" src="JS/LoginScript.js"></script>

  <!-- jQuery library -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

  <!-- Bootstrap 5 JS -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>

</head>

<body>
  <!-- Navigation-->
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
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">List Of Speciality</a>
              <ul class="dropdown-menu shadow">

                <li><a class="dropdown-item" href="#">Dermatology</a></li>
                <li>
                  <hr class="dropdown-divider" style ="width: 100%;">
                </li>
                <li><a class="dropdown-item" href="#">Cardiology</a></li>
                <li>
                  <hr class="dropdown-divider" style ="width: 100%;">
                </li>
                <li><a class="dropdown-item" href="#">Obstetrics</a></li>
                <li>
                  <hr class="dropdown-divider" style ="width: 100%;">
                </li>
                <li class="dropstart">
                  <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown">Internal Medicine</a>
                  <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="">Prevention</a></li>
                    <li><a class="dropdown-item" href="">Diagnosis</a></li>
                    <li><a class="dropdown-item" href="">Treatment</a></li>
                  </ul>
                </li>
              </ul>
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

  <!--- filter --->
  <div class="container-fluid">
    <div class="row" >
      <div class="col-lg-2" style="margin: 20px 0 0 20px;">
        <h5 style="color: black; ">Filter Product</h5>
        <br>
        <h6 class="text" style="color: black; font-size: 20px;">Expertise</h6>
        <ul class="list-group">
          <?php
            $sql="SELECT DISTINCT expertise FROM doctor ORDER BY expertise";
            $result=$db->query($sql);
            while($row=$result->fetch_assoc()){
          ?>
          <li class="list-group-item">
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input doctor_check" value="<?= $row['expertise']; ?>" id="expertise"><?= $row['expertise']; ?>
              </label>
            </div>
          </li>
        <?php } ?>
        </ul>

        <h6 class="text" style="color: black; font-size: 20px; margin-top: 10px;">Working Days</h6>
        <ul class="list-group">
          <?php
            $sql="SELECT DISTINCT working_days FROM working_days ORDER BY order1";
            $result=$db->query($sql);
            while($row=$result->fetch_assoc()){
          ?>
          <li class="list-group-item">
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input doctor_check" value="<?= $row['working_days']; ?>" id="working_days"><?= $row['working_days']; ?>
              </label>
            </div>
          </li>
        <?php } ?>
        </ul>

        <h6 class="text" style="color: black; font-size: 20px; margin-top: 10px;">Location</h6>
        <ul class="list-group" style="margin-bottom: 20px;">
          <?php
            $sql="SELECT DISTINCT location FROM doctor ORDER BY location";
            $result=$db->query($sql);
            while($row=$result->fetch_assoc()){
          ?>
          <li class="list-group-item">
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input doctor_check" value="<?= $row['location']; ?>" id="location"><?= $row['location']; ?>
              </label>
            </div>
          </li>
        <?php } ?>
        </ul>

      </div>
      <div class="col-lg-9" style="margin: 20px 0 0 20px;">
        <h1 class="text-center" id="textChange" style="color: black; ">All Doctors</h1>
        <hr style=" border: 1px solid grey;width: 100%;">
        <div class="row" id="result">
          <?php
            $sql="SELECT * FROM doctor";
            $result=$db->query($sql);
            while($row=$result->fetch_assoc()){
          ?>
          <div class="col-md-3 mb-2">
            <div class="card-deck" style="margin: 0 0 40px 0;">
              <div class="card border-secondary">
                <img src="<?= $row['doctor_image']; ?>" class="card-img-top">
                <div class="card-body">
                  <h4><?= $row['doctor_name']; ?></h4>
                  <h6><?= $row['expertise']; ?></h6>
                  <a href="#" class="btn btn-primary btn-sm mt-auto d-flex flex-column">Profile</a>
                  <a href="#" class="btn btn-primary btn-sm mt-3 d-flex flex-column">Book Appointment</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </div>
  </div>

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

  <br>
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
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="scripts/responses.js"></script>
<script src="scripts/chat.js"></script>
</html>