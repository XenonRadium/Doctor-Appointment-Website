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

if(isset($_POST['johorlocation'])){
  $_SESSION['locationCheck'] = "Johor";
}

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Main Menu</title>

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
          


  <!-- Slideshow Start-->
  <br>
  <div class="container-fluid  w-75 p-1" style = "z-index: 0" >
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel" style ="z-index: 0">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">
        <!-- First SlideShow -->
        <div class="carousel-item active">
          <img src="Images/slideshow1.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption">
            <h5 class="animated fadeInDown" style="animation-delay: 1s">Comfortable Rooms</h5>
            <p class="animated fadeInDown d-none d-md-block" style="animation-delay: 2s">
              Private rooms for you to recover in peace.</p>
          </div>
        </div>
        <!-- Second Slide Show -->
        <div class="carousel-item" >
          <img src="Images/slideshow4.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption">
            <h5 class="animated fadeInDown" style="animation-delay: 1s">Professional Medical Services</h5>
            <p class="animated fadeInDown d-none d-md-block" style="animation-delay: 2s">
              Professional medical practitioners at the tip of your fingers.</p>
          </div>
        </div>
        <!-- Third Slide Show -->
        <div class="carousel-item">
          <img src="Images/slideshow3.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption">
            <h5 class="animated fadeInDown" style="animation-delay: 1s">Constant Treatment</h5>
            <p class="animated fadeInDown d-none d-md-block" style="animation-delay: 2s">
              Constant care and service during your treatment.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
      <div class="container-bg"></div>
  </div>
  
  <!-- Slideshow -->
  <hr style = "width: 80%">

  <h1><center><u>Doctors</u></center></h1>

  <div class="container-fluid  w-75 p-3" style ="z-index: 0">
    <div id="carouselDoctors" class="carousel slide carousel-fade" data-bs-interval="false" style ="z-index: 0" >
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselDoctors" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselDoctors" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <!-- <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <!-- Cards -->
          <div class="container-fluid">
            <div class="row">
                
                <!-- Obtain 1 to 3 -->
                <?php
                    $sql="SELECT * FROM doctor WHERE id >0 && id <4";
                    $result=$db->query($sql);
                    while($row=$result->fetch_assoc()){
                  ?>
                <div class="col-4 d-flex justify-content-center">
                  <div class="card" style="width: 18em;">

                    <img src="<?= $row['doctor_image']; ?>" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?= $row['doctor_name']; ?></h5>
                      <p class="card-text"><?= $row['expertise']; ?></p>
                      <a href="TestDoctorPage.php?doctorname=<?= $row['doctor_name']; ?>" class="btn btn-primary btn-sm mt-auto" style="background-color: red; border: red;">Profile</a>

                      <!--Not Logged In -->                   
                      <?php  if (isset($_SESSION['username'])) : ?>
                        <a href="Appointment.php?doctorname=<?= $row['doctor_name']; ?>" class="btn btn-primary btn-sm mt-3">Book Appointment</a>
                      <?php endif ?>

                    </div>

                    <div class="container-bg" style="height:px; width:auto;"></div>
                  </div>
                </div>
                <?php } ?>
    
            </div>
          </div>
          <!-- Cards -->
        </div>
        <div class="carousel-item">
          <!-- Cards -->
          <div class="container-fluid">
            <div class="row">
              
                <!-- Obtain 4 to 6 -->
                <?php
                  $sql="SELECT * FROM doctor WHERE id >3 && id <7";
                  $result=$db->query($sql);
                  while($row=$result->fetch_assoc()){
                ?>
                <div class="col-4 d-flex justify-content-center">
                  <div class="card" style="width: 18em;">

                    <img src="<?= $row['doctor_image']; ?>" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?= $row['doctor_name']; ?></h5>
                      <p class="card-text"><?= $row['expertise']; ?></p>
                      <a href="TestDoctorPage.php?doctorname=<?= $row['doctor_name']; ?>" class="btn btn-primary btn-sm mt-auto" style="background-color: red; border: red;">Profile</a>
                      
                      <!--Not Logged In -->                   
                      <?php  if (isset($_SESSION['username'])) : ?>
                        <a href="Appointment.php?doctorname=<?= $row['doctor_name']; ?>" class="btn btn-primary btn-sm mt-3">Book Appointment</a>
                      <?php endif ?>
                    </div>

                    <div class="container-bg" style="height:px; width:auto;"></div>
                  </div>
                </div>
                <?php } ?>
            </div>
          </div>
          <!-- Cards -->
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselDoctors" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselDoctors" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <br>
  <a href="FindDoctor.php" style="font-size:20px;"><center>
    See more highly-recommended doctors
  </center></a>

<hr style = "width: 80%">

<!-- Most Common visit Start-->

<h1><center><u>Top-Searched Specialties</u></center></h1>

<div id="Specialties" class="container-fluid w-75 p-3">
  <div class="row row-fluid">
    <?php
      $sql="SELECT * FROM `doctor` ORDER by expertise";
      $result=$db->query($sql);
      while($row=$result->fetch_assoc()){
    ?>
      <a class="col border-end border-start border-danger link-danger" >
        <i class="fa-solid fa-1 fa-2x d-flex justify-content-center mt-2"></i>
        <p class="text-center mt-2">
          <?= $row['expertise']; ?>
        </p>
      </a>
    <?php } ?> 
  </div>
</div>

<!-- Most Common visit -->

<hr style = "width: 80%">

<!-- Location Start-->
<h1><center><u>Find Medical Care By Location</u></center></h1>

<div id="location" class="container-fluid w-50 p-3">
  <div class="row row-fluid">
    <!-- Icons -->
    <div class="col-8">
      <div class="row row-fluid mt-5">
        <div class="col-6">
          <i class="bi bi-geo-alt-fill" style="font-size: 3rem;"></i>
        </div>
        <div class="col-6">
          <i class="bi bi-map-fill" style="font-size: 3rem;"></i>
        </div>
      </div>
      <div class="row row-fluid mt-5">
        <div class="col-6">
          <i class="bi bi-pin-map-fill" style="font-size: 3rem;"></i>
        </div>
        <div class="col-6">
          <i class="fa-solid fa-location-arrow" style="font-size: 3rem;"></i>
        </div>
      </div>
    </div>
    <!-- Location -->
    <div class="col-4">
      <br><br>  
      <ul class="list-group list-group-flush">
        <a class="list-group-item link-danger" href="TestDoctorPage.php?location=Johor" class="nav-link p-0 text-muted">Johor</a>
        <a class="list-group-item link-danger" href="TestDoctorPage.php?location=Melaka" class="nav-link p-0 text-muted">Melaka</a>
        <a class="list-group-item link-danger" href="TestDoctorPage.php?location=Penang" class="nav-link p-0 text-muted">Penang</a>
        <a class="list-group-item link-danger" href="TestDoctorPage.php?location=Perak" class="nav-link p-0 text-muted">Perak</a>
        <a class="list-group-item link-danger" href="TestDoctorPage.php?location=Selangor" class="nav-link p-0 text-muted">Selangor</a>
      </ul>
    </div>
  </div>
</div>

<!-- Location -->

<hr style = "width: 80%">

<!-- Common Visit Reasons -->
<h1><center><u>Common Visit Reasons</u></center></h1>

<div class="container-fluid w-75 p-3">
  <ul class="list-group list-group-flush">
    <a class="list-group-item link-danger dropdown-toggle" data-bs-toggle="collapse" href="#medicalCollapse"
    aria-expanded="false" aria-controls="medicalCollapse">Medical</a>

    <!-- DropDown -->
    <div class="collapse p-1" id="medicalCollapse">
      <ul class="list-group list-group-flush">
        <a class="list-group-item link-secondary" href="#">Nexplanon removal</a>
        <a class="list-group-item link-secondary" href="#">Ob-GYN emergency</a>
        <a class="list-group-item link-secondary" href="#">IUD removal</a>
        <a class="list-group-item link-secondary" href="#">IUD insertion</a>
        <a class="list-group-item link-secondary" href="#">Annual physical</a>
      </ul>
    </div>

    <a class="list-group-item link-danger dropdown-toggle" data-bs-toggle="collapse" href="#dentalCollapse"
    aria-expanded="false" aria-controls="dentalCollapse">Dental</a>

    <!-- DropDown -->
    <div class="collapse p-1" id="dentalCollapse">
      <ul class="list-group list-group-flush">
        <a class="list-group-item link-secondary" href="#">Dental leaning</a>
        <a class="list-group-item link-secondary" href="#">Teeth bonding</a>
        <a class="list-group-item link-secondary" href="#">Dental implants</a>
      </ul>
    </div>

    <a class="list-group-item link-danger dropdown-toggle" data-bs-toggle="collapse" href="#mentalHealthCollapse"
    aria-expanded="false" aria-controls="mentalHealthCollapse">Mental Health</a>

    <!-- DropDown -->
    <div class="collapse p-1" id="mentalHealthCollapse">
      <ul class="list-group list-group-flush">
        <a class="list-group-item link-secondary" href="#">Anxiety</a>
        <a class="list-group-item link-secondary" href="#">Hyperactive disorder (ADD/ADHD)</a>
        <a class="list-group-item link-secondary" href="#">Online therapy</a>
      </ul>
    </div>

    <a class="list-group-item link-danger dropdown-toggle" data-bs-toggle="collapse" href="#visionCollapse"
    aria-expanded="false" aria-controls="visionCollapse">Vision</a>

    <!-- DropDown -->
    <div class="collapse p-1" id="visionCollapse">
      <ul class="list-group list-group-flush">
        <a class="list-group-item link-secondary" href="#">Annual eye exam</a>
        <a class="list-group-item link-secondary" href="#">Eye exam</a>
      </ul>
    </div>

  </ul>
</div>

<!-- Chat Box -->
<!-- Nog Logged In -->
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

<!-- Ajex JS-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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


