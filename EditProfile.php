<!-- PHP -->
<?php
session_start();

require 'db_inc.php';

//Send Mail function php file
include 'SendMail.php';

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

//Time 
$t=time();

//Vars
$errorsForEdit = array();
unset($_SESSION['infoProfile']);

// Select Database
mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));

//SQL Obtain Query From User Table
$Obtainsql = "SELECT `userId`, `userFirstName`, `userLastName`, `userDobDay`, `userGender`, `userPassword`, `userEmail` FROM `usertable` WHERE `userEmail` = '{$_SESSION["username"]}'";
$result = mysqli_query($db,$Obtainsql);
$rows = mysqli_num_rows($result);

if ($rows==1){
    while($rs = mysqli_fetch_array($result)){ 
         $id = $rs["userId"];
         $email = $rs["userEmail"];
         $firstname =$rs["userFirstName"];
         $lastname=$rs["userLastName"];
         $dob=$rs["userDobDay"];
         $gender = $rs["userGender"];
         $password = $rs["userPassword"];

     }
 }

//Update Database
if(isset($_POST['Submit'])){
    
   //Obtain Variables
   ////Update 
    $txtFirstName = filter_input(INPUT_POST, 'inputFirstName');    
    $txtLastName = filter_input(INPUT_POST, 'inputLastName');
    $txtDay = filter_input(INPUT_POST, 'inputDob');
    $txtGender = filter_input(INPUT_POST, 'inputGender');
    $txtEmail = filter_input(INPUT_POST, 'inputEmailAddress');
    //$txtPassword = filter_input(INPUT_POST, 'inputPassword');
    //$txtConfirmPassword = filter_input(INPUT_POST, 'inputConfirmpassword');
    
    // check password 
    //Connect to db
        //$Updatesql = "UPDATE `usertable` SET `userFirstName`='$txtFirstName',`userLastName`='$txtLastName',`userDobDay`='$txtDay',`userGender`='$txtGender',`userEmail`='$txtEmail' WHERE `userId`='$id'";
        $Updatesql = "UPDATE `usertable` SET `userFirstName`='$txtFirstName',`userLastName`='$txtLastName',`userDobDay`='$txtDay',`userGender`='$txtGender',`userEmail`='$txtEmail' WHERE `userId` = '$id'";
        
        $Updateresult = mysqli_query($db,$Updatesql);   

            //check status
            if($Updateresult){

              //Email
                $to_email = $_SESSION['username'];
                $subject = "Account Details Changed";
                $body = "Hi, ".$firstname. " ".$lastname."\nYour account details have been changed on ".date("l")." ".date("Y-m-d",$t)." at " .date("h:i:sa")."";
                $headers = "From: cheahyeefei@gmail.com";
                
                $info = "Contact Records Updated.";
                $_SESSION['infoProfile'] = $info;
                
               //Send Mail
               mail($to_email,$subject,$body,$headers);

            }else{
                $errors['edit'] = "Error";
                //echo '<script>alert("Error")</script>';
            }

}

//Update Password
if(isset($_POST['updatepassword'])){
    
    $passwordEntered = filter_input(INPUT_POST, 'passwordentered');
    $newpasswordEntered = filter_input(INPUT_POST, 'newpassword'); 
    $newconfirmpasswordEntered = filter_input(INPUT_POST, 'newconfirmpassword'); 
    
    if($passwordEntered == $password){
        
        if($newpasswordEntered == $newconfirmpasswordEntered){
            $Updatesql = "UPDATE `usertable` SET `userPassword`='$newpasswordEntered' WHERE `userId` = '$id'";
            $Updateresult = mysqli_query($db,$Updatesql);
            
            //check status
            if($Updateresult){

                $to_email = $_SESSION['username'];
                $subject = "Account Password Changed";
                $body = "Hi, ".$firstname. " ".$lastname."\nYour account password have been changed on ".date("l")." ".date("Y-m-d",$t)." at " .date("h:i:sa")."";
                $headers = "From: cheahyeefei@gmail.com";
                
                $info = "PasswordUpdated.";
                $_SESSION['infoProfile'] = $info;

                //Send Mail
                mail($to_email,$subject,$body,$headers);
            }else{
              $errors['password'] = "Error";
                //echo '<script>alert("Error")</script>';
            }
            
        }else{
            $errors['password'] = "Password And Confirm Password Do Not Match!";
            //echo '<script>alert("Password And Confirm Password Do Not Match")</script>';
        }
        
    }else{
        $errors['password'] = "Old Do Not Match!";
        //echo '<script>alert("Old Do Not Match")</script>';
    }
            
    
}

//Logout
if(isset($_POST['LogOut'])){
    // Unset all of the session variables
    $_SESSION = array();
    unset($_SESSION['username']);
 
    // Destroy the session.
    session_destroy();
    header("location: LogIn.php");
}

//Delete Account
if(isset($_POST['Delete'])){
    // Delete Appointment SQL
    $deleteApppointment = "DELETE FROM `appointment` WHERE `user_id` = '$id'";
    $Updateresult0 = mysqli_query($db,$deleteApppointment);
    
    // Delete User SQL
    $deletesql = "DELETE FROM `usertable` WHERE `userId` = '$id'";
    $Updateresult = mysqli_query($db,$deletesql);

    // Email
    $to_email = $_SESSION['username'];
    $subject = "Account Deleted";
    $body = "Hi, ".$firstname. " ".$lastname."\nYour account have been deleted on ".date("l").date("Y-m-d",$t)."at " .date("h:i:sa")."\nWe appologise for any inconvinience cause and hope you enjoy every single moment with us.";
    $headers = "From: cheahyeefei@gmail.com";

     if($Updateresult0 && $Updateresult){
               
        echo '<script>alert("Contact Records Deleted")</script>';
        $_SESSION = array();
        unset($_SESSION['username']);

        //Send Mail
        mail($to_email,$subject,$body,$headers);

        // Destroy the session.
        session_destroy();
        header("location: LogIn.php");
        // Redirect user to welcome page
        header("location: Login.php");
        //echo "<script>alert('Contact Records Updated');</script>";

        
        
        
    }else{
        $errors['delete'] = "Error";
        //echo '<script>alert("Error")</script>';
    }
}
?>

<!-- Html -->

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Edit Profile Page</title>

  <!-- Bootstrap 5 CSS -->
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
  <!-- Google Fonts -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap'>
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/cdfb47ba63.js" crossorigin="anonymous"></script>

  <!-- Additional CSS  -->
  <!--<link rel="stylesheet" href="Css/DeleteAccount.css">-->
  <link rel="stylesheet" href="Css/Chat.css">
  <link rel="stylesheet" href="Css/MainMenuStyle.css">
  <link rel="stylesheet" href="Css/NewLogIn.css">
  <!-- Bootstrap 5 JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  
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
          <ul class="navbar-nav mr-auto mb-lg-0">
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
              <input class="form-control mr-2" type="search" placeholder="Search"name ="search"  aria-label="Search">
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

  

    <!-- Container -->
  <div class="container-xl px-4 mt-4">
      <div class="row">
          <!-- Profile Pic Container-->
          <div class="col-xl-4 ">
              <form method = "POST" action="UploadProfilePic.php" enctype="multipart/form-data">
                  <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                <div class="card-header">CHANGE PROFILE PICTURE</div>
                <div class="card-body text-center">
                    <?php
                        $sql= "SELECT * FROM usertable where userEmail = '".$_SESSION['username']."'";
                        $result=$db->query($sql);
                        while($row=$result->fetch_assoc()){
                    ?>
                      <!-- Profile picture image-->
                      <div class = "img-container">
                          <img class="img-account-profile rounded-circle mb-2" src="<?= $row['userImage']; ?>" style="height:230px; max-height: 270px; max-width:270px; width: 230px;" alt="">
                      </div>      
                      <!-- Profile picture help block-->                  
                      <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                      <!-- Profile picture upload button-->  
                      <div class="card-body text-center">
                          <input type="file" name="fileToUpload" id="fileToUpload" style="margin-left: auto;margin-right: auto;">
                      </div>  
                      
                      <button class="btn btn-danger" type="submit" name = "updatepicture" ><i class="fa-solid fa-file-image fa-fw"></i>Update Profile Picture</button>
                      
                      <br>
                  </div>
                <?php } ?>
              </div>
              <div class="container-bg" ></div>
              </form>
          </div>
          <!-- Account Details-->
          <div class="col-xl-8">
              <!-- Account details card-->
              <div class="card mb-4">
                  <div class="card-header">ACCOUNT DETAILS</div>
                  <div class="card-body">
                      <form method = "POST" action ="" >

                          <!-- Form Row-->
                          <div class="row gx-3 mb-3">
                              <!-- Form Group (first name)-->
                              <div class="col-md-6">
                                  <label class="small mb-1" for="inputFirstName">FIRST NAME</label>
                                  <input class="form-control" id="inputFirstName" name="inputFirstName" type="text" placeholder="Enter your first name" required="required" style="text-transform:uppercase" value="<?php echo $firstname; ?>">
                              </div>
                              <!-- Form Group (last name)-->
                              <div class="col-md-6">
                                  <label class="small mb-1" for="inputLastName">LAST NAME</label>
                                  <input class="form-control" id="inputLastName" name="inputLastName" type="text" placeholder="Enter your last name" required="required"  style="text-transform:uppercase"value="<?php echo $lastname; ?>">
                              </div>
                          </div>
                          
                          <!-- Form Row        -->
                          <div class="row gx-3 mb-3">
                              <!-- Form Group (DoB)-->
                              <div class="col-md-6">
                                  <label class="small mb-1" for="inputDob">DATE OF BIRTH (DOB)</label>
                                  <input class="form-control" id="inputDob" name="inputDob" type="date" placeholder="Enter your DOB" required="required" value="<?php echo $dob; ?>">
                              </div>

                              <!-- Form Group (gender)-->
                              <div class="col-md-6">
                                  <label class="small mb-1" for="inputGender">GENDER</label>
                                  
                                  <select class="form-control" id="usergender" name="inputGender">
                                    <option disabled selected><?php echo $gender; ?></option>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                  </select>
                                  
                              </div>

                          </div>
                          <!-- Form Group (email address)-->
                          <div class="mb-3">
                              <label class="small mb-1" for="inputEmailAddress">EMAIL ADDRESS</label>
                              <input class="form-control" id="inputEmailAddress" name="inputEmailAddress" type="email" placeholder="Enter your email address" required="required" value="<?php echo $email; ?>">
                          </div>

                          
                          <!-- Save changes button-->
                          <div class="card-body text-center">
                              <button class="btn btn-danger" type="submit" href ="EditProfile.php?Submit=true" name = "Submit"><i class="fa-solid fa-floppy-disk fa-fw"></i>Save changes</button>
                          </div>                        
                      </form>                                         
                </div>                                   
              </div>
              

              <!-- Error/ Success Message -->
              <?php 
                if(isset($_SESSION['infoProfile'])){
                    ?>
                    <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
                        <?php echo $_SESSION['infoProfile']; ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if(count($errorsForEdit) > 0){
                    ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        foreach($errorsForEdit as $showerror){
                            echo $showerrorForEdit;
                        }
                        ?>
                    </div>
                <?php
            }
        ?>
          </div>        
      </div>  
      <br>
      
      <div class ="row">          
          <div class="col-xl-4">              
              <div class="card mb-4 mb-xl-0">
                <!-- Delete Account Container-->
                <div class="card-header">DELETE ACCOUNT</div>
                <div class="card-body text-center">                
                <!-- Delete Account Pop Up button-->
                <button type="button"  style=" outline:none; border-style: none; box-shadow: none;"class="btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash-can fa-fw"></i>Delete Account<div class="container-bg" style="height:2px; width:auto;"></div></button>
                <!-- Delete Account Pop Up-->
                                 
              </div>
            </div>
            <div class="container-bg" ></div>
            <!-- Logout Container -->
            <form method = "POST" action="">
              <!-- Logout Container-->
              <div class="card mb-4 mb-xl-0">
              <div class="card-header">LOGOUT</div>
              <div class="card-body text-center">                
              <!-- Logout button-->
              <div class="card-body text-center">
                  <button class="btn btn-danger" type="submit" name = "LogOut"><i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i>Logout</button>
              </div>                
            </form> 
          </div>              
        </div>
      <div class="container-bg"></div>
    <br>
            
      </div>
          <!-- ChangePassword-->
          <div class="col-xl-8">
              <!-- Account details card-->
              <div class="card mb-4">
                  <div class="card-header">CHANGE PASSWORD</div>
                  <div class="card-body">
                      <form method = "POST" action ="" >
                           <div class="mb-3">
                            <label class="small mb-1" for="inputPassword">OLD PASSWORD</label>
                            <input class="form-control" id="password" type="password" name="passwordentered">
                        </div>
                      <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputPassword">NEW PASSWORD</label>
                            <input class="form-control" id="password" type="password" name="newpassword">
                        </div>

                        <!-- Form Group (confirm password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputPassword2">NEW CONFIRM PASSWORD</label>
                            <input class="form-control" id="password2" type="password" name="newconfirmpassword">
                        </div>
                      <!-- Profile picture upload button-->  
                      <div class="card-body text-center">
                              <button class="btn btn-danger" type="submit" name = "updatepassword" ><i class="fa-solid fa-floppy-disk fa-fw"></i>Update Password</button>
                          </div>                                              
                      </form>
                  </div>                 
              </div>
          </div>    
      </div>
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



<!-- JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        
        function confirmDelete(self) {

            $("#myModal").modal("show");
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

    }
    
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  data-backdrop="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Account?</h4>                                
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this user ?</p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
            <form method="POST" action="" id="form-delete-user">
                <button type="submit" class="btn btn-danger" name = "Delete">Confirm Delete</button>
            </form>
        </div>
      </div>
    </div>
</div>
</body>

</html>