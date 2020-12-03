<?php
  $logMsg = "";
  if(isset($_POST['adminLogin'])){
    $username = trim($_POST['userName']);
    $password = trim($_POST['loginPass']);
      // check the database to see if the username / password exist
      $found_user = Admin::authenticate($username, $password);
      if($found_user){
        // store the user data into a session for later use
        $query = "SELECT * FROM admin WHERE adminEmail = '{$found_user->adminEmail}' LIMIT 1";
        $result = $database->query($query);
        $result = mysqli_fetch_array($result);
        if($result['admintStatus'] === '1' && isset($_POST['userType'])){
          if($_POST['userType'] === "Admin" && $result['role'] === "admin"){
            $_SESSION['adminId'] = $result['adminId'];
            $_SESSION['adminFullName'] = $result['adminFullName'];
            $_SESSION['userType'] = "Admin";
            $_SESSION['loginMsg'] = "You have successfully logged in AsanSafar";
            $logMsg = "The admin ".$_POST['userName']." Successfully logged in";
            $_SESSION['loginStatus'] = 'success';
          }else if($_POST['userType'] === "Operator" && $result['role'] === "operator"){
            $_SESSION['adminId'] = $result['adminId'];
            $_SESSION['adminFullName'] = $result['adminFullName'];
            $_SESSION['userType'] = "Operator";
            $_SESSION['loginMsg'] = "You have successfully logged in AsanSafar";
            $logMsg = "The operator ".$_POST['userName']." Successfully logged in";
            $_SESSION['loginStatus'] = 'success';
          }else{
            $_SESSION['loginStatus'] = 'error';
            $_SESSION['loginMsg'] = "Sorry, are you an admin or operator??? Make sure to select the correct user type";
          }
        }else{
          $_SESSION['loginStatus'] = 'error';
          $_SESSION['loginMsg'] = "Sorry, your account is locked, please contact super admin";
          $logMsg = "Login failed, the account ".$_POST['userName']." is locked";
        }
        // do your staff and conditon here
      }else{
        // It means the user name or password is incorrect
        $_SESSION['loginStatus'] = 'error';
        $_SESSION['loginMsg'] = "Sorry, login to AsanSafar admin portal failed, please try again";
        $logMsg = "Login failed, invalid user name and password";
      }
    }
      else{
    // form has not been submitted
    // clear the form
    $username = "";
    $password = "";
    // It means the user name or password is incorrect
    $_SESSION['loginStatus'] = "";
    $_SESSION['loginMsg'] = "";
  }

  if(isset($_SESSION['loginStatus']) && isset($_SESSION['loginMsg'])){
    if($_SESSION['loginStatus'] === 'success'){
        $_SESSION['loginMsg'] = '<script>bootbox.alert({message: "'.$_SESSION['loginMsg'].'"});</script>';
    }else{
        $_SESSION['loginMsg'] = '<script>bootbox.alert({title:"User login failed",message: "'.$_SESSION['loginMsg'].'"});</script>';
    }

    if(isset($logMsg) && !empty($logMsg) && $_POST['userType'] === "Admin"){
      $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
      VALUES('{$_POST["userName"]}','Admin','Login as an admin','{$logMsg}')";
      $database->query($sql);
    }else if(isset($logMsg) && !empty($logMsg) && $_POST['userType'] === "Operator"){
      $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
      VALUES('{$_POST["userName"]}','Operator','Login as an operator','{$logMsg}')";
      $database->query($sql);
    }
  }
 ?>
