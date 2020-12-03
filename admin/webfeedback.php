<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- =============================================== -->
 <?php
 $logMsg = "";
   // If it is update section of the form below operation will be fullfil
   // website logo and name update
   if(isset($_POST['update'])) {
     // We will validate the form so that all the required fields should have value
     if(
       !empty($_POST['id']) &&
       !empty($_POST['feedbackQuestion']) &&
       !empty($_POST['optionA']) &&
       !empty($_POST['optionB']) &&
       !empty($_POST['optionC']) &&
       !empty($_POST['optionD'])
     ) {
       // We will store the data from the form in our own variables
       $id = $database->escape_value(trim($_POST['id']));
       $question = $database->escape_value(trim($_POST['feedbackQuestion']));
       $optionA = $database->escape_value(trim($_POST['optionA']));
       $optionB = $database->escape_value(trim($_POST['optionB']));
       $optionC = $database->escape_value(trim($_POST['optionC']));
       $optionD = $database->escape_value(trim($_POST['optionD']));

           // Store the data in the database without updating the image column
           $query = "UPDATE clientfeedback SET question ='{$question}', optionA='{$optionA}', optionB = '{$optionB}', optionC='{$optionC}',optionD='{$optionD}' WHERE id = '{$id}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['type'] = 'success';
               $_SESSION['msg'] = 'The feedback question has been updated successfully. :)';
               $logMsg = "The feedback has been updated by admin with ID ".$_SESSION['adminId'];
           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['msg'] = 'Sorry! There is an error updating the feedback question! <br /> Please try again later. :(';
               $_SESSION['type'] = 'error';
               $logMsg = "Feedback update failed! - tried by admin with ID ".$_SESSION['adminId'];
           }
       }else{
         // we will send an error message to user that required fields are not filed
         $_SESSION['msg'] = 'Please fill all the required fields';
         $_SESSION['type'] = 'error';
       }

     } else {
      $_SESSION['msg'] = '';
      $_SESSION['type'] = '';
   }

   if(isset($logMsg) && !empty($logMsg) && isset($_SESSION["adminId"])){
     $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
     VALUES('{$_SESSION["adminId"]}','Admin','Updating website feedback','{$logMsg}')";
     $database->query($sql);
   }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Feedback</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include ('includes/comnstyles.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('includes/header.php'); ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include 'includes/webnameandlogo.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >

    <!-- Main content -->
    <section class="content" style="padding-top: 1em;">

      <section class="content">

      <!-- Messages Section -->
      <?php // Check if msg and type session variables are not empty
          if(!empty(@$_SESSION['msg']) && !empty(@$_SESSION['type'])) {

            // Check if type is error then display the error message
            if(@$_SESSION['type'] === 'error') { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo $_SESSION['msg']; ?>
              </div>
           <?php
           $_SESSION['msg'] = $_SESSION['type'] = '';
            } // End of error if condition

            // Check if type is success then display the success message
            if(@$_SESSION['type'] === 'success') { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $_SESSION['msg']; ?>
              </div>
            <?php
            $_SESSION['msg'] = $_SESSION['type'] = '';
            } // End of success if condition

           } // End of msg and type variables check condition
       ?>
     </section>

      <h4>Website Feedback </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                  <div class="active tab-pane">
                    <div class="tab-pane">
                        <?php
                        $query = "SELECT * FROM clientfeedback";
                        $result = $database->query($query);
                        while($question = $database->fetch_array($result)){ ?>
                          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Question <?php if(isset($question['id'])) echo $question['id']; ?>: </label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="question" name="feedbackQuestion" placeholder="Enter the feedback question..." value="<?php if(isset($question['question'])) echo $question['question']; ?>" required="required">
                          </div>
                        </div>
                        <div class="form-group row">
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Option a. </label>
                                  <input type="text" class="form-control" name="optionA" placeholder="Enter option a..." value="<?php if(isset($question['optionA'])) echo $question['optionA']; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Option b.</label>
                                  <input type="text" class="form-control" name="optionB" placeholder="Enter option b..." value="<?php if(isset($question['optionB'])) echo $question['optionB']; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Option c.</label>
                                  <input type="text" class="form-control" name="optionC" placeholder="Enter option c..." value="<?php if(isset($question['optionC'])) echo $question['optionC']; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Option d.</label>
                                  <input type="text" class="form-control" name="optionD" placeholder="Enter option d..." value="<?php if(isset($question['optionD'])) echo $question['optionD']; ?>" required="required">
                                </div>
                              </div>
                        </div>
                        <div class="text-center">
                          <input type="hidden" value="<?php if(isset($question['id'])) echo $question['id']; ?>" name="id" />
                          <button type="submit" name="update" id="update" class="btn btn-success">Update</button>
                        </div>
                        <hr />
                      </form>
                    <?php } ?>
                    </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'includes/footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include ('includes/comnscripts.php'); ?>
<?php
    if (isset($_SESSION ['msg'])){
      echo $_SESSION ['msg'];
      unset ($_SESSION ['type']);
      unset ($_SESSION ['msg']);
    }
  ?>
</body>
</html>
