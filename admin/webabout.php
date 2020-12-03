<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- fetching about website record -->
<?php
  $sqlQuery = "SELECT * FROM websiteabout LIMIT 1";
  $result = $database->query($sqlQuery);
  $result = mysqli_fetch_array($result);
  $aboutWebsite = $result['about'];
 ?>
<!-- =============================================== -->
 <?php
 $logMsg = "";
   // If it is update section of the form below operation will be fullfil
   // website update about
   if(isset($_POST['update'])) {
     // We will validate the form so that all the required fields should have value
     if(!empty($_POST['webAbout'])) {
       // We will store the data from the form in our own variables
       $webAbout = $database->escape_value(trim($_POST['webAbout']));
           // Store the data in the database without updating the image column
           $query = "UPDATE `websiteabout` SET about ='{$webAbout}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['type'] = 'success';
               $_SESSION['msg'] = 'Record has been updated successfully. :)';
               $logMsg = "The website about us has been updated successfully by admin with ID ".$_SESSION['adminId'];
           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['msg'] = 'Sorry! There is an error updating this record! <br /> Please try again later. :(';
               $_SESSION['type'] = 'error';
               $logMsg = "There is an error updating the website about us details-tried by admin with ID ".$_SESSION['adminId'];
           }

     } else {
       // we will send an error message to user that required fields are not filed
       $_SESSION['msg'] = 'Please fill all the required fields';
       $_SESSION['type'] = 'error';
   }
 }else{
   $_SESSION['msg'] = '';
   $_SESSION['type'] = '';
 }

 if(isset($logMsg) && !empty($logMsg) && isset($_SESSION["adminId"])){
   $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
   VALUES('{$_SESSION["adminId"]}','Admin','Website about us details','{$logMsg}')";
   $database->query($sql);
 }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | About</title>
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


      <h4>About </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                  <div class="active tab-pane">
                    <div class="tab-pane">
                      <!-- Main content -->
                      <section class="content">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card card-outline card-info">
                              <div class="card-header">
                                <h3 class="card-title">
                                  Please
                                  <small>do not add image in about section</small>
                                </h3>
                              </div>
                              <!-- /.card-header -->
                              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                              <div class="card-body pad">
                                <div class="mb-3">
                                  <textarea name="webAbout" id="webAbout" class="form-control text-justify align-left" rows="10" placeholder="Write about AsanSafar" required="required">
                                    <?php if(isset($aboutWebsite)) echo $aboutWebsite; ?>
                                  </textarea>
                                </div>
                                <div class="text-center">
                                <input type="submit" name="update" id="update" value="Update" class="btn btn-success text-center" />
                              </div>
                              </div>
                            </form>
                            </div>
                          </div>
                          <!-- /.col-->
                        </div>
                        <!-- ./row -->
                      </section>
                      <!-- /.content -->
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
