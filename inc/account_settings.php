
<?php
    // If it is update section of the form below operation will be fullfil
    if(isset($_POST['updateAccount'])) {
      if(
        !empty($_POST['fullName']) &&
        !empty($_POST['email']) &&
        !empty($_POST['mobile']) &&
        !empty($_POST['permenatAddress']) &&
        !empty($_POST['currentAddress'])){
          $fullName = $database->escape_value(trim($_POST['fullName']));
          $email = $database->escape_value(trim($_POST['email']));
          $mobile = $database->escape_value(trim($_POST['mobile']));
          $permenatAddress = $database->escape_value(trim($_POST['permenatAddress']));
          $currentAddress = $database->escape_value(trim($_POST['currentAddress']));
          $clientOldEmail = $_SESSION["username"];
            $usedEmail = $database->countOf("client","clientEmail like '%$email'");
            if($clientOldEmail !== $email && $usedEmail > 0){
              $_SESSION['updateMsg'] = "The email '{$email}' is already used. Please use different email!";
              $_SESSION['updateStatus'] = "error";
            }else{
              // Store the data in the database
              $query = "UPDATE client SET clientFullName='{$fullName}',clientEmail='{$email}',clientMobile='{$mobile}',clientPermenantAddress='{$permenatAddress}',clientCurrentAddress='{$currentAddress}' WHERE clientEmail='{$clientOldEmail}' LIMIT 1";
              if($database->query($query)) {
                // Send a success message that the record has been inserted and refresh the page
                $_SESSION['updateStatus'] = 'success';
                $_SESSION['updateMsg'] = 'Client details has been updated successfully. :)';
                $logMsg = "The client {$email} has been updated by client}";
                $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
                VALUES('{$email}','Client','Client update','{$logMsg}')";
                $database->query($sql);
                session_unset();
                session_destroy();
                redirect_to("index.php?msg=Your%account%20has%20been%20changed%20successfully!&type=information");
              } else {
                // Send an error message to the user that record was not able to be save
                $_SESSION['updateMsg'] = 'Sorry! There is an error updating this record! <br /> Please try again later. :(';
                $_SESSION['updateStatus'] = 'error';
                $logMsg = "The client {$email} update by client faileed";
                $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
                VALUES('{$email}','Client','Client update','{$logMsg}')";
                $database->query($sql);
              }
            }
        } else {
          // Send an error message to the user that record was not able to be save
          $_SESSION['updateMsg'] = $fullName. '|'. $email . '|'. $mobile .'|'. $permenatAddress . '|'. $currentAddress;
          $_SESSION['updateStatus'] = 'error';
        }
    }else{
      // It means the user name or password is incorrect
      $_SESSION['updateMsg'] = "";
      $_SESSION['updateStatus'] = "";
    }
    if(isset($_SESSION['updateStatus']) && isset($_SESSION['updateMsg'])){
      if($_SESSION['updateStatus'] === 'success'){
          $_SESSION['updateMsg'] = '<script>bootbox.alert({message: "'.$_SESSION['updateMsg'].'"});</script>';
      }else{
          $_SESSION['updateMsg'] = '<script>bootbox.alert({title:"Account update failed",message: "'.$_SESSION['updateMsg'].'"});</script>';
      }
    }
  ?>
