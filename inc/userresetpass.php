<?php
$logMsg = "";
// fetching the logged in admin details
if(isset($_SESSION['username'])){
  $userEmail = $_SESSION['username'];
  $query = "SELECT * FROM client WHERE clientEmail = '{$userEmail}' LIMIT 1";
  $result = $database->query($query);
  $result = mysqli_fetch_array($result);
  $currentPassword = $result['clientPassword'];
}
 ?>
 <?php
   // If it is update section of the form below operation will be fullfil
   // website logo and name update
   if(isset($_POST['resetPassword'])) {
     // We will validate the form so that all the required fields should have value
     if(
       !empty($_POST['currentPassword']) &&
       !empty($_POST['newPassword']) &&
       !empty($_POST['newPasswordConfirm'])
     ) {
       // We will store the data from the form in our own variables

       $oldPass = MD5($database->escape_value(trim($_POST['currentPassword'])));
       $newPass = MD5($database->escape_value(trim($_POST['newPassword'])));
       $confirmPass = MD5($database->escape_value(trim($_POST['newPasswordConfirm'])));

       $sql = "SELECT * FROM client WHERE clientEmail ='{$userEmail}' AND clientPassword ='{$oldPass}' LIMIT 1";
       $result = $database->query($sql);
       $rowCount = mysqli_num_rows($result);
       if($rowCount == 1){
         if($newPass === $confirmPass){
           // Store the data in the database without updating the image column
           $query = "UPDATE client SET clientPassword ='{$newPass}' WHERE clientEmail = '{$userEmail}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['resetPassStatus'] = 'success';
               $_SESSION['resetPassMsg'] = 'Your password has been changed successfully. :)';
               $logMsg = "The user ".$userEmail." has reset his/her password";

               $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
               VALUES('{$_SESSION["username"]}','Client','Client Reset password','{$logMsg}')";
               $database->query($sql);
               session_unset();
               session_destroy();
               redirect_to("index.php?msg=Your%20password%20has%20been%20changed%20successfully!&type=information");

           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['resetPassMsg'] = 'Sorry! There is an error changing your password! <br /> Please try again later. :(';
               $_SESSION['resetPassStatus'] = 'error';
               $logMsg = "Changing password for user ".$userEmail." failed, try again";
           }
         }else{
           $_SESSION['resetPassMsg'] = 'Invalid passowrd, password confirmation failed, it does not match. :(';
           $_SESSION['resetPassStatus'] = 'error';
           $logMsg = "Password confirmation for user ".$userEmail." failed, it does not match";
         }

       }else{
         // Send an error message to the user that record was not able to be save
         $_SESSION['resetPassMsg'] = 'Wrong password entered, please enter your valid password. :(';
         $_SESSION['resetPassStatus'] = 'error';
         $logMsg = "Wrong password for user ".$userEmail." entered";
       }

       }else{
         // we will send an error message to user that required fields are not filed
         $_SESSION['resetPassMsg'] = 'Please fill all the required fields';
         $_SESSION['resetPassStatus'] = 'error';
       }

     } else {
      $_SESSION['resetPassMsg'] = '';
      $_SESSION['resetPassStatus'] = '';
   }

   if(isset($_SESSION['resetPassStatus']) && isset($_SESSION['resetPassMsg'])){
     if($_SESSION['resetPassStatus'] === 'success'){
         $_SESSION['resetPassMsg'] = '<script>bootbox.alert({message: "'.$_SESSION['resetPassMsg'].'"});</script>';
     }else{
         $_SESSION['resetPassMsg'] = '<script>bootbox.alert({title:"Password failed",message: "'.$_SESSION['resetPassMsg'].'"});</script>';
     }
   }
 ?>
