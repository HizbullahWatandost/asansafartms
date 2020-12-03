
<?php include ('db_connection_session.php'); ?>
<!-- =============================================== -->
<?php
    $id = trim($_POST['id']);
    $sql = "DELETE FROM vehicleowner WHERE ownerId=".$id." LIMIT 1";
    if($database->query($sql)) {
      if(isset($_SESSION['userType'])){
        $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
        VALUES('{$_SESSION["adminId"]}','Operator','Deleting the agency','The agency with ID {$_POST["id"]} succesfully deleted by operator {$_SESSION["adminId"]} ')";
        $database->query($sql);
      }
        echo "1";
    } else {
        echo "0";
    }
?>
