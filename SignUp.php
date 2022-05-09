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

//Get Vars
$txtFirstName = filter_input(INPUT_POST, 'firstname');    
$txtLastName = filter_input(INPUT_POST, 'lastname');
$txtDay = filter_input(INPUT_POST, 'day');
$txtGender = filter_input(INPUT_POST, 'gender');
$txtEmail = filter_input(INPUT_POST, 'email');
$txtPassword = filter_input(INPUT_POST, 'password');
$txtConfirmPassword = filter_input(INPUT_POST, 'confirmpassword');
$errors = array();

// check database for the email entered
$Select = "SELECT `userEmail` FROM `usertable` WHERE `userEmail` = ? Limit 1";

// check statment
$stmt = $db -> prepare($Select);
$stmt -> bind_param("s", $txtEmail);
$stmt -> execute();
$stmt -> bind_result($txtEmail);
$stmt -> store_result();
$rnum = $stmt -> num_rows;

// database insert SQL code
$sql = "INSERT INTO `usertable`(`userId`, `userFirstName`, `userLastName`, `userDobDay`, `userGender`, `userPassword`, `userEmail`, `userImage`,`userVerificationCode`)
VALUES ('','$txtFirstName','$txtLastName','$txtDay','$txtGender','$txtPassword','$txtEmail', 'Images/user.jpg', 0)";

if(isset($_POST['Submit'])){
  // check password 
   
    if($txtPassword == $txtConfirmPassword){ 
       
        //chechk email
        if($rnum == 0){
            //insert into db           
            $rs = mysqli_query($db, $sql);
            
            $t=time();

            $to_email = $txtEmail;
            $subject = "Account Created";
            $body = "Hi, ".$txtFirstName. " ".$txtLastName."\nYour account have been created on ".date("l")." ".date("Y-m-d",$t)." at " .date("h:i:sa")."\nYou can now proceed to login.";
            $headers = "From: cheahyeefei@gmail.com";

            if (mail($to_email, $subject, $body, $headers))

            {
                echo "Email successfully sent to $to_email...";
            }

            else

            {
                echo "Email sending failed!";
            }
            
            //check success
         
            if($rs){
                $_SESSION['message'] = '<script>alert("Contact Records Inserted")</script>';
                echo '<script>alert("Contact Records Inserted")</script>';
//              // Redirect user to welcome page
                    header("location: LogIn.php");
            }else{
              $errors['register'] = "Error!";
                //echo '<script>alert("Error")</script>';
            }
   
       }else{
        $errors['register'] = "Email Already Registered!";
            //echo '<script>alert("Email Already Registered")</script>';
//            echo"Email Already Registered";
        }
     
    }else {
      $errors['register'] = "Password Do Not Match!";
        //echo '<script>alert("Password Do Not Match")</script>';
    }

    
}
 ?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Sign Up Page</title>

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
  <!-- Additional CSS (Optional) -->
  <link rel="stylesheet" type="text/css" href="Css/NewSignUp.css" />
  <link rel="stylesheet" type="text/css" href="Css/Chat.css" />
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  <!-- JavaScript-->
  <script type="text/javascript" src="https://www.gstatic.com/firebasejs/9.6.8/firebase-app.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/firebasejs/9.6.8/firebase-auth.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/firebasejs/9.6.8/firebase-database.js"></script>
  <!-- Bootstrap 5 JS -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>

</head>

<body>

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
              <a class="nav-link active active" aria-current="page" href="MainMenu.php">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link active" href="FindDoctor.php">Doctors Details</a>
            </li>
            

            <li class="nav-item">
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
              <button class="btn btn-danger border-0" type="submit" name ="searchbtn" >Search</button>
            </div>
          </form>

        </div>
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
            <!-- Not Logged In --> 
            <li class = "nav-item"><?php  if (!isset($_SESSION['username'])) : ?><a class ="nav-link" href="LogIn.php">Login</a><?php endif ?></li>
            
            <!-- Logged In -->
            <li class = "nav-item"><?php  if (isset($_SESSION['username'])) : ?><a class ="nav-link" href="EditProfile.php">Settings</a><?php endif ?></li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Pop Up Alert -->
  <div id="myOverlay" class="overlay">
    <div class="overlay-content">
      <img src="check.jpg" alt="check">
      <p>Your account has been created</p>
      <a href="LogIn.php" class="button">Login</a>
    </div>
  </div>

  <!-- Sign Up Form -->
  <div class="sign-up-form">
    <h1>CREATE AN ACCOUNT</h1>
    <form action="" method="POST">
      <div class="form-group">
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
        <!-- Name -->
        <label for="name">NAME</label> 
        <input type="text" id="first_name" class="input-box" placeholder="First" name="firstname" required="required"  style="text-transform:uppercase" />
        <input type="text" id="Last_name" class="input-box" placeholder="Last" name="lastname" required="required"  style="text-transform:uppercase"/>
        <!-- DOB -->
        <label for="DoB">DATE OF BIRTH</label>
        <input type="date"  class="input-box" id="dob_day" placeholder="Day" name="day" required="required" />
        <!-- Gender -->
        <label for="Gender">GENDER</label>
        <select id="usergender" class="input-box" name="gender" style="background: rgba(0, 0, 0, 0.1); margin: 0 0 10px; font-weight: 400;  padding: 12px 10px; ">
          <option disabled selected>~SELECT YOUR GENDER~</option>
          <option value="MALE">MALE</option>
          <option value="FEMALE">FEMALE</option>
        </select>
        <!-- Email -->
        <label for="Email">EMAIL</label>
        <input type="email" class="input-box" id="email" placeholder="Email" name="email" required="required" />
        <!-- Password -->
        <label for="password">PASSWORD</label>
        <input type="password"  class="input-box" id="password" placeholder="Password" name="password" required="required" />
        <label for="Confirm_Password">CONFIRM PASSWORD</label>
        <input type="password" class="input-box" id="confirm_password" placeholder="Password" name="confirmpassword" required="required" />
        <p class="message" id="message">demo text</p>
        <p style="font-size:12px; text-align:center; margin-top:-10px;"> By continuing, You have read and accept the terms & conditions and privacy policy.</p>
        <input id="button" type="submit" name ="Submit" value="Submit" />
        <p class="para-2">Already Aave An Account? <a href="LogIn.php"><b>Login Here</b></a></p>
      </div>
    </form>
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


</body>

</html>
