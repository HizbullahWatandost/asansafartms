<?php
// registeration
// code to save the client registeration record into database
// first of all we have to check if the form is submited or not
$logMsg = "";
include_once('database.php');
if(isset($_POST['adminRegister'])){
  // we validate the form so that all the required fields should have values
  if(
    !empty($_POST['fullName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['mobile']) &&
    !empty($_POST['password']) &&
    !empty($_POST['passwordConfirm'])){
      // here, we will store the data from the form in our own variables
      $fullName = $database->escape_value(trim($_POST['fullName']));
      $email = $database->escape_value(trim($_POST['email']));
      $mobile = $database->escape_value(trim($_POST['mobile']));
      $password = $database->escape_value(trim($_POST['password']));
      $passwordConfirm = $database->escape_value(trim($_POST['passwordConfirm']));

      // we will check if the password and confirm password matches
      if($password !== $passwordConfirm){
        // echo '<script>alert("password do not match, please try againi");<script>';
        $_SESSION['msg'] = "Password do not match, please try again!";
        $_SESSION['type'] = "error";
        $logMsg = "Registeration failed,  the password does not match!";
      }else{ // If the user use the email which is used or already registered
        $usedEmail = $database->countOf("admin","adminEmail like '%$email'");
        if($usedEmail > 0){
          $_SESSION['msg'] = "The email '{$email}' is already used. Please use a different email!";
          $_SESSION['type'] = "error";
          $logMsg = "The used email have been tried";
        }else{// If the user is not registered with us
          // Encrypt the password in MD5 format for security purpose
          $password = MD5($password);
            if($admin->createAdmin($fullName,$email,$mobile,$password)){
              $_SESSION['type'] = 'success';
              $_SESSION['msg'] = 'The admin have uccessfully added. :)';
              $logMsg = "The admin ".$email." Successfuly registered";
            }else{
              // Send an error to the user that record was not able to be saved into database
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Sorry, the registeration failed, pleased try again. :)(:';
              $logMsg = "Registering admin ".$email." failed, please try again";
            }
          }
        }
      }else{
        // We will send an error to the user that the required fileds are not filled.
        $_SESSION['type'] = 'error';
        $_SESSION['msg'] = 'Please fill the required fileds. :)(:';
      }
  }else{ // if the form is not submitted
    // We will send an error to the user that the required fileds are not filled.
    $_POST['fullName'] = "";
    $_POST['email'] = "";
    $_POST['mobile'] = "";
    $_POST['password'] = "";
    $_POST['passwordConfirm'] = "";
    $_SESSION['type'] = "";
    $_SESSION['msg'] = "";
  }
  if(isset($logMsg) && !empty($logMsg) && !empty($email)){
    $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
    VALUES('{$email}','Admin','Registering an admin','{$logMsg}')";
    $database->query($sql);
  }

?>
