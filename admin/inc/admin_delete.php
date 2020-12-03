
<?php include ('db_connection_session.php'); ?>
<!-- =============================================== -->
<?php
    $id = trim($_POST['id']);
    $sql = "DELETE FROM admin WHERE adminId=".$id." LIMIT 1";
    if($database->query($sql)) {
      if(isset($_SESSION['userType'])){
        $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
        VALUES('{$_SESSION["adminId"]}','Admin','Deleting the user (Admin or operator)','The user with ID {$_POST["id"]} succesfully deleted by admin {$_SESSION["adminId"]} ')";
        $database->query($sql);
      }
        echo "1";
    } else {
        echo "0";
    }
?>
