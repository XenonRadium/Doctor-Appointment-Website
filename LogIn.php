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
$posted = false;
$txtEmail = filter_input(INPUT_POST, 'email');
$txtPassword = filter_input(INPUT_POST, 'password');
$_SESSION['messageAfterLogin'] = '';
$_SESSION["loggedin"] = 0;
$_SESSION['status'] = 0;
$log = '';
$errors = array();

//Select From DB
$sql = "SELECT *  FROM `usertable` WHERE `userEmail` ='$txtEmail' and `userPassword` = '$txtPassword'";

//Set Cookie
//if(!isset($_COOKIE["email"])) {
    //$sql .= " AND password = '" . md5($txtPassword) . "'";
//}
 

if(!empty($_GET['search'])){
    $username = filter_input(INPUT_POST, 'search');//mysqli_real_escape_string($_GET['search']);
    $sqlsearch = "SELECT `userFirstName`  FROM `usertable` WHERE `userFirstName` like '$username%'";
    //$r = mysqli_query($db,$sqlsearch);
    
    
    if(isset($_POST['searchbtn'])){
        $rturn = mysqli_query($db,$sqlsearch);
        $_SESSION['return'] = $rturn;
    }
  
}

$result = mysqli_query($db, $sql);  
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
$count = mysqli_num_rows($result);  

if(!empty($_COOKIE["email"])){
    header("location: MainMenu.php");
}

if(isset($_POST['Submit'])){
    if($count == 1){  

      $id = $rs["userId"];
        
        //Cookie
        if(!empty($_POST["remember"])) {
            setcookie ("email",$txtEmail,time()+ (10 * 365 * 24 * 60 * 60),"/");
        } else {
            if(isset($_COOKIE["email"])) {
                    setcookie ($txtEmail,"");
            }
        }
        
        $posted = true;
        $result = $txtEmail;
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $txtEmail;
        //echo("<script>alert('Login successful.')</script>");
        echo("<script>window.location = 'MainMenu.php';</script>");

    }  
    else{  
      $errors['login'] = "Login failed. Invalid username or password!";

    }   
}



?>

<!--HTML -->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login Page</title>

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
  <link rel="stylesheet" type="text/css" href="Css/NewLogIn.css" />
  <link rel="stylesheet" href="Css/Chat.css">
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  <!-- Bootstrap 5 JS -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>

  <!-- Toast CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

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
            
            <li class = "nav-item"><?php  if (!isset($_SESSION['username'])) : ?><a class ="nav-link"href="SignUp.php">Sign Up</a><?php endif ?></li>
            
            <!-- Logged In -->
            <li class = "nav-item"><?php  if (isset($_SESSION['username'])) : ?><a class ="nav-link"href="EditProfile.php">Settings</a><?php endif ?></li>

        </ul>
    </nav>    

  <!--Login Form-->
  <div class="form">
    <div class="form-toggle"></div>
    <div class="form-panel one">
      <div class="form-header">
        <h1>Account Login</h1>
      </div>
      <div class="form-content">
          <form method = "POST" action = "">
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
          <div class="form-group">
            <label for="username">Email Address</label>
            <input  class="input-box" id="username" type="email" name="email" required="required" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input class="input-box" id="password" type="password" name="password" required="required" />
          </div>
          <div class="form-group">
            <label class="form-remember">
              <input type="checkbox" name = "remember" />Remember Me

            </label><a class="form-recovery" href="ForgetPassword.php"><b>Forgot Password?</b></a>
          </div>
          <div class="form-group">
            <button type="submit" name = "Submit" >Log In</button>
            

          </div>

              <p class="para-2">Haven't Register As A User? <a href="SignUp.php"><b>Register Here</b></a></p>

        </form>
      </div>
    </div>
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



</body>

</html>
