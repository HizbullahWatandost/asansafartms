<?php include ('inc/db_connection_session.php'); ?>

 <?php
 $logMsg = "";
   // If it is update section of the form below operation will be fullfil
   // website logo and name update
   if(isset($_POST['resetPassword'])) {
     // We will validate the form so that all the required fields should have value
     if(!empty($_POST['newPassword']) && !empty($_POST['newPasswordConfirm'])) {
       // We will store the data from the form in our own variables

       $newPass = MD5($database->escape_value(trim($_POST['newPassword'])));
       $confirmPass = MD5($database->escape_value(trim($_POST['newPasswordConfirm'])));
         if($newPass === $confirmPass){
           // Store the data in the database without updating the image column
           $query = "UPDATE client SET clientPassword ='{$newPass}' WHERE clientId = '{$_GET["uid"]}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['clientResetPasswordStatus'] = 'success';
               $_SESSION['clientResetPasswordMsg'] = 'Your password has been changed successfully. :)';
               $logMsg = "The user ".$_GET["uid"]." has reset his/her password";
               // logging the client activity
               $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
               VALUES('{$_GET["uid"]}','Client','Client Reset password','{$logMsg}')";
               $database->query($sql);
               // updating the passwordResetCode to empty after client succcessfully change his/her password to expire the resetpassword code
               $query = "UPDATE client SET passwordResetCode ='' WHERE clientId = '{$_GET["uid"]}' LIMIT 1";
               $database->query($query);
               redirect_to("index.php?msg=Your%20password%20has%20been%20changed%20successfully!&type=information");

           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['clientResetPasswordMsg'] = 'Sorry! There is an error changing your password! <br /> Please try again later. :(';
               $_SESSION['clientResetPasswordStatus'] = 'error';
               $logMsg = "Changing password for user ".$_GET["uid"]." failed, try again";

         }
       }else{
           $_SESSION['clientResetPasswordMsg'] = 'Invalid passowrd, password confirmation failed, it does not match. :(';
           $_SESSION['clientResetPasswordStatus'] = 'error';
           $logMsg = "Password confirmation for user ".$_GET["uid"]." failed, it does not match";
         }
       }else{
         // we will send an error message to user that required fields are not filed
         $_SESSION['clientResetPasswordMsg'] = 'Please fill all the required fields';
         $_SESSION['clientResetPasswordStatus'] = 'error';
       }

     } else {
      $_SESSION['clientResetPasswordMsg'] = '';
      $_SESSION['clientResetPasswordStatus'] = '';
   }

   if(isset($_SESSION['clientResetPasswordStatus']) && isset($_SESSION['clientResetPasswordMsg'])){
     if($_SESSION['clientResetPasswordStatus'] === 'success'){
         $_SESSION['clientResetPasswordMsg'] = '<script>bootbox.alert({message: "'.$_SESSION['clientResetPasswordMsg'].'"});</script>';
     }else{
         $_SESSION['clientResetPasswordMsg'] = '<script>bootbox.alert({title:"Password failed",message: "'.$_SESSION['clientResetPasswordMsg'].'"});</script>';
     }
   }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- style -->
  <?php include ('include/pagecomn_head.php'); ?>
  <!-- jquery scipt for auto search index -- product search -->
  <title>Transportation Management System (TMS)</title>
</head>

<body>
    <main>
      <div class="menus-containert" style="max-width: 400px;margin:auto;">
        <div class="container">
          <div class="page-header menus-container">
            <h3 class="text-center text-white text-uppercase">Reset Password</h3>
                <?php
                    //checking the url path to get the reset unique code and user id to check
                    if(!isset($_GET["passResetCode"]) || !isset($_GET["uid"]) || $_GET["passResetCode"] == "" || $_GET["uid"] =="" || empty($_GET["passResetCode"]) || empty($_GET["uid"]) || $_GET["passResetCode"] == null || $_GET["uid"] == null){
                        echo("<script>location.href = 'http://localhost/tms/index.php';</script>");
                    }
                    else if($_GET["passResetCode"] != "" && $_GET["uid"] !="" && !empty($_GET["passResetCode"]) && !empty($_GET["uid"])){
                        $sql = "SELECT * FROM client WHERE clientId='{$_GET["uid"]}' AND passwordResetCode='{$_GET["passResetCode"]}'";
                        $result = $database->query($sql);
                        $cnt = mysqli_num_rows($result);
                        if($cnt == 1){
                            $row=mysqli_fetch_assoc($result);
                            if($_GET["passResetCode"] == $row['passwordResetCode'] && $_GET["uid"] == $row['clientId']){
                                echo '
                                <hr class="stylish-hr-2" />
                                  <form action="#" enctype="multipart/form-data" method="post">
                                  <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="New password" name="newPassword" required="required">
                                    <div class="input-group-append">
                                      <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="Confirm new password" name="newPasswordConfirm" required="required">
                                    <div class="input-group-append">
                                      <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="container text-center">
                                    <button class="btn ticket-search-btn text-center" name="resetPassword" id = "resetPassword" type="submit">Reset Password</button>
                                  </div>
                              </form>
                              <hr class="stylish-hr-2" />';
                            }else{
                              echo '<script>bootbox.alert({message: "Failed to reset the password"});</script>';
                              echo("<script>location.href = 'http://localhost/tms/index.php';</script>");
                                }
                        }else{
                          echo '<script>bootbox.alert({message: "The link is invalid or it is used or expired!"});</script>';
                          echo("<script>location.href = 'http://localhost/tms/index.php';</script>");
                            }

                    }else{
                      echo '<script>bootbox.alert({message: "Invalid Reset Password Link"});</script>';
                      echo("<script>location.href = 'http://localhost/tms/index.php';</script>");
                        }

                    ?>
            </div>
          </div>
        </div>


  </main>
    <!-- scripts -->
    <?php include 'include/pagecomn_scripts.php'; ?>
    <!-- ticket search -->
    <script src="plugins/select2dropdown/js/select2.min.js"></script>
    <script src="plugins/select2dropdown/js/select2-custom.js"></script>
    <!-- quick ticket book slider -->
    <script src="plugins/owlcarousel/js/owl.carousel.js"></script>
    <script src="assets/js/quick-book-slider.js"></script>
    <script src="assets/js/script.js"></script>
    <?php
        if(isset($_SESSION['clientResetPasswordStatus'])){
          echo $_SESSION['clientResetPasswordMsg'];
          unset($_SESSION['clientResetPasswordMsg']);
          unset($_SESSION['clientResetPasswordStatus']);
        }
      ?>
</body>
</html>
