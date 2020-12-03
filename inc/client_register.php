<!-- =============================================== -->
<?php
$logMsg = "";
// registeration
// code to save the client registeration record into database
// first of all we have to check if the form is submited or not
if(isset($_POST['clientRegister'])){
  // we validate the form so that all the required fields should have values
  if(
    !empty($_POST['fullName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['mobile']) &&
    !empty($_POST['permenatAddress']) &&
    !empty($_POST['currentAddress']) &&
    !empty($_POST['password']) &&
    !empty($_POST['passwordConfirm'])){
      // here, we will store the data from the form in our own variables
      $fullName = $database->escape_value(trim($_POST['fullName']));
      $email = $database->escape_value(trim($_POST['email']));
      $mobile = $database->escape_value(trim($_POST['mobile']));
      $permenatAddress = $database->escape_value(trim($_POST['permenatAddress']));
      $currentAddress = $database->escape_value(trim($_POST['currentAddress']));
      $password = $database->escape_value(trim($_POST['password']));
      $passwordConfirm = $database->escape_value(trim($_POST['passwordConfirm']));

      // we will check if the password and confirm password matches
      if($password !== $passwordConfirm){
        // echo '<script>alert("password do not match, please try againi");<script>';
        $_SESSION['msg'] = "Password do not match, please try again!";
        $_SESSION['type'] = "error";
      }else{// If the user use the email which is used or already registered
        $usedEmail = $database->countOf("client","clientEmail like '%$email'");
        if($usedEmail > 0){
          $_SESSION['msg'] = "The email '{$email}' has successfully registered!";
          $_SESSION['type'] = "success";
        }else{// If the user is not registered with us
          // Encrypt the password in MD5 format for security purpose
          $password = MD5($password);
          // store the data into database
          $query = "INSERT INTO client(
          clientFullName,
          clientEmail,
          clientMobile,
          ClientPermenantAddress,
          clientCurrentAddress,
          clientPassword)
          VALUES(
            '{$fullName}',
            '{$email}',
            '{$mobile}',
            '{$permenatAddress}',
            '{$currentAddress}',
            '{$password}'
          )";

          if($database->query($query) === true){
            $_SESSION['type'] = 'success';
            $_SESSION['msg'] = 'The client has been successfully registered. :)';
            $logMsg = "The client {$email} has been successfully registerd";
            //logging the activity
            $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
            VALUES('{$email}','Client','Client registeration','{$logMsg}')";
            $database->query($sql);
          }else{
            // Send an error to the user that record was not able to be saved into database
            $_SESSION['type'] = 'error';
            $_SESSION['msg'] = 'Sorry, the client registeration failed, pleased try again. :)(:';
            $logMsg = "The client {$email} registeration by {$_SESSION['adminId']} failed";
            $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
            VALUES('{$email}','Client','Client registeration','{$logMsg}')";
            $database->query($sql);
          }
        }
    }
  }else{
    // We will send an error to the user that the required fileds are not filled.
    $_SESSION['type'] = 'error';
    $_SESSION['msg'] = 'Please fill the required fileds. :)(:';
  }
}else{ // if the form is not submitted
  $_SESSION['type'] = "";
  $_SESSION['msg'] = "";
}

if(isset($_SESSION['type']) && isset($_SESSION['msg'])){
  if($_SESSION['type'] === 'success'){
      $_SESSION['msg'] = '<script>bootbox.alert({message: "'.$_SESSION['msg'].'"});</script>';
  }else{
      $_SESSION['msg'] = '<script>bootbox.alert({title:"Invalid username and password",message: "'.$_SESSION['msg'].'"});</script>';
  }
}
 ?>
