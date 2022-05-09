<?php
//Calling Session
session_start();

//Setting to Malaysia time zone
date_default_timezone_set("Asia/Kuala_Lumpur");

// Database linking
require 'db_inc.php';

// Select Database
mysqli_select_db($db, MYSQL_DB) or die(mysqli_error($db));

$target_dir = "Images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));




// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    
    $dbImageName = $target_dir . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
     
    $Updatesql = "UPDATE `usertable` SET `userImage`= '$dbImageName'  WHERE userEmail = '".$_SESSION['username']."'";
        
        $Updateresult = mysqli_query($db,$Updatesql);                               

            //check status
            if($Updateresult){
              
                $info = "Profile Picture Updated.";
                $_SESSION['infoProfile'] = $info;
                

                // Redirect user to welcome page
                echo("<script>window.location = 'MainMenu.php';</script>");
                //echo "<script>alert('Contact Records Updated');</script>";

            }else{
                echo '<script>alert("Error")</script>';
            }
    
  } else {
    echo("<script>alert('Sorry, there was an error uploading your file.')</script>");
    header('Location: MainMenu.php');

  }
}



?>