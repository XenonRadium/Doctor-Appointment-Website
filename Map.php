<!-- PHP -->
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

<!-- HTML --> 
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Contact Us Page</title>

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
  <!-- Additional CSS  -->
  <link rel="stylesheet" href="Css/Chat.css">
  <!--<link rel="stylesheet" href="Css/Map.css">-->
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  
  <!-- Bootstrap 5 JS -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
  
  <!-- Ajex JS-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="Js/Responses.js"></script>
  <script src="Js/Chat.js"></script>


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
              <input class="form-control mr-2" type="search" placeholder="Search" name ="search" aria-label="Search">
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
          


  <!-- Map Container -->
  <h1><center><u>Our Location</u></center></h1>
  
  <div class="container-bg" style="height: 524px; width: 84%">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.0074054247707!2d101.55756531457598!3d3.092687597747909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4db78a492075%3A0x45d4444f42c422dc!2sUOW%20Malaysia%20KDU%20University%20College%2C%20Utropolis%20Glenmarie!5e0!3m2!1sen!2smy!4v1646719807874!5m2!1sen!2smy"
      width=100%; margin="auto;" height=520px; style="border:0;" allowfullscreen="true" loading="lazy">
    </iframe>
  </div>
 
  <br><br>
  <!-- Description-->
  <section id="about">
    <div class ="container" >
        <div class="row">
            <div class="col-7">
              <h6> <b>TEAM 2 HEALTHCARE</b> </h6>
              <div class="container-bg" style="height:2px; width:auto;"></div>

              <p class="footer-text">
                  Team 2 Healthcare provides quality and affordable healthcare services to the community with 30 specialist consultants including Child Pediatrician, Chiropractor, Dermatology, General Practitioner, Oncologist, Psychiatrist and more well-trained and qualified  Medical Officers, nurses and paramedics.
                  <br>

               <br>
               </p>
            </div>
            <div class ="col-1"></div>
            <!-- Col -->
            <div class="col-3 footer-col">
             <h6 class="footer-text"> <b>CONTACT</b> </h6>
             <div class="container-bg" style="height:2px; width:auto;"></div>
             <p class="footer-text">
               <b>Contact Us: </b>
               <br>0131535@kdu-online.com
               <br>+603 1234 5678
               <br>
               <br>
               <b>For Enquiries: </b>
               <br>0129972@kdu-online.com
               <br>

              </p>
           </div>
           <!-- Col -->
          </div>
    </div>
  </section>

  <hr style = "width: 80%">
  <h1><center><u>Other Branches</u></center></h1>

  <!-- Other Branches Container -->
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card" style="width: auto;">
          <img class="card-img-top" src="images/uow.jpg" alt="Card image cap" height="236px;">
          <div class="card-body">
            <h5 class="card-title">UOW Malaysia KDU</h5>
            <p class="card-text">UOW Malaysia KDU University College, Utropolis Glenmarie</p>
            <hr style = "width: 80%">
            <p class="card-text"><b>Email:</b> enquiry@uowmkdu.edu.my<br>
              <b>Phone:</b> +603 7953 6688<br>
              <b>Local Enquiry:</b> +6012 236 3602<br>
              <b>International Enquiry:</b> international@uowmkdu.edu.my<br>
            </p>
          </div>
        </div>
        <div class="container-bg" ></div>
      </div>

      <div class="col">
        <div class="card" style="width: auto;">
          <img class="card-img-top" src="images/penanguow.jpg" alt="Card image cap" height="236px;">
          <div class="card-body">
            <h5 class="card-title">UOW Malaysia KDU</h5>
            <p class="card-text">UOW Malaysia KDU Penang University College (Batu Kawan)</p>
            <hr style = "width: 80%">
            <p class="card-text"><b>Email:</b> enquiry@uowmkdu.edu.my<br>
              <b>Phone:</b> +604 563 6000<br>
              <b>Local Enquiry:</b> +6018 916 0368<br>
              <b>International Enquiry:</b> international@uowmkdu.edu.my
            </p>
          </div>
        </div>
        <div class="container-bg" ></div>
      </div>

      <div class="col">
        <div class="card" style="width: auto;">
          <img class="card-img-top" src="images/uowpenang.jpg" alt="Card image cap" height="236px;">
          <div class="card-body">
            <h5 class="card-title">UOW Malaysia KDU</h5>
            <p class="card-text">UOW Malaysia KDU Penang University College (George Town)</p>            
            <hr style = "width: 80%"> 
            <p class="card-text"><b>Email:</b> enquiry@uowmkdu.edu.my<br>
              <b>Phone:</b> +604 238 6368<br>
              <b>Local Enquiry:</b> +6018 916 0368<br>
              <b>International Enquiry:</b> international@uowmkdu.edu.my
            </p>
          </div>
        </div>
        <div class="container-bg" ></div>
      </div>
    </div>
    <br>
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

<!-- Chat-->
<div class="chat-bar-collapsible"><?php  if (isset($_SESSION['username'])) : ?>
    <button id="chat-button" type="submit" class="collapsible" name="chatbtn">
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

<!-- JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
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

    }
    
</script>
</body>
</html>
