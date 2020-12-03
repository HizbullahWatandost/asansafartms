<?php
  include ('inc/db_connection_session.php');
  /* This section will clear the session specified int the login script */
  if(isset($_SESSION['adminId']) && !empty($_SESSION['adminId']) && $_SESSION['userType'] === "Admin"){
    $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
    VALUES('{$_SESSION["adminId"]}','Admin','Admin Logout','Admin {$_SESSION["adminId"]} Successfully logged out')";
    $database->query($sql);
  }else if(isset($_SESSION['adminId']) && !empty($_SESSION['adminId']) && $_SESSION['userType'] === "Operator"){
    $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
    VALUES('{$_SESSION["adminId"]}','Operator','Operator Logout','Operator {$_SESSION["adminId"]} Successfully logged out')";
    $database->query($sql);
  }
  // remove all session variables */
  unset($_SESSION['adminId']);
  unset($_SESSION['adminFullName']);
  unset($_SESSION['userType']);

  // After the sessions has been cleared and the user is not available in the cache
  // user will be redirected to the home page
  //redirect_to('index.php');
  header ("location: index.php?msg=You%20have%20been%20successfully%20logged%20out!&type=information");
  exit();
 ?>
