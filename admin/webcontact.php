<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- fetching about us details-->
<?php
  $sqlQuery = "SELECT * FROM contactus LIMIT 1";
  $result = $database->query($sqlQuery);
  $result = mysqli_fetch_array($result);
  $address = $result['address'];
  $email = $result['email'];
  $contactNo1 = $result['contactNoOne'];
  $contactNo2 = $result['contactNoTwo'];
  $websiteShortDesc = $result['webShortDesc'];
  $domainName = $result['domainName'];
 ?>
<!-- =============================================== -->
 <?php
  $logMsg = "";
   // If it is update section of the form below operation will be fullfil
   // website logo and name update
   if(isset($_POST['update'])) {
     // We will validate the form so that all the required fields should have value
     if(
       !empty($_POST['address']) &&
       !empty($_POST['email']) &&
       !empty($_POST['contactNo1']) &&
       !empty($_POST['contactNo2']) &&
       !empty($_POST['websiteShortDesc']) &&
       !empty($_POST['domainName'])
     ) {
       // We will store the data from the form in our own variables
       $address = $database->escape_value(trim($_POST['address']));
       $email = $database->escape_value(trim($_POST['email']));
       $contactNo1 = $database->escape_value(trim($_POST['contactNo1']));
       $contactNo2 = $database->escape_value(trim($_POST['contactNo2']));
       $websiteShortDesc = $database->escape_value(trim($_POST['websiteShortDesc']));
       $domainName = $database->escape_value(trim($_POST['domainName']));

           // Store the data in the database without updating the image column
           $query = "UPDATE contactus SET address ='{$address}', email='{$email}', contactNoOne = '{$contactNo1}', contactNoTwo='{$contactNo2}',webShortDesc='{$websiteShortDesc}',domainName = '{$domainName}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['type'] = 'success';
               $_SESSION['msg'] = 'The website contac us details has been updated successfully. :)';
               $logMsg = "The website contact us details has been changed by admin with ID ".$_SESSION['adminId'];
           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['msg'] = 'Sorry! There is an error updating the contact us details! <br /> Please try again later. :(';
               $_SESSION['type'] = 'error';
               $logMsg = "Updating website contact us details, failed - tried by admin with ID ".$_SESSION['adminId'];
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
     VALUES('{$_SESSION["adminId"]}','Admin','Updating website contact us details','{$logMsg}')";
     $database->query($sql);
   }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Contact</title>
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

      <h4>Website Contact </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                  <div class="active tab-pane">
                    <div class="tab-pane">
                      <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Contact Us </label>
                          <div class="col-sm-10">
                            <hr />
                          </div>
                        </div>
                        <div class="form-group row">
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Address </label>
                                  <input type="text" class="form-control" placeholder="Enter office address..." name="address" value="<?php if(isset($address)) echo $address; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Email </label>
                                  <input type="text" class="form-control" placeholder="Enter email addrerss..." name="email" value="<?php if(isset($email)) echo $email; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Contact Number 1</label>
                                  <input type="text" class="form-control" placeholder="Enter contact number 1..." name="contactNo1" value="<?php if(isset($contactNo1)) echo $contactNo1; ?>" required="required">
                                </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>Contact Number 2</label>
                                  <input type="text" class="form-control" placeholder="Enter contact number 2..." name="contactNo2" value="<?php if(isset($contactNo2)) echo $contactNo2; ?>" required="required">
                                </div>
                              </div>
                        </div>
                        <hr />

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-4 col-form-label">Webite short desciption (Footer) </label>
                          <div class="col-sm-8">
                            <textarea class="form-control" rows="3" placeholder="Write here ..." name="websiteShortDesc" required="required"><?php if(isset($websiteShortDesc)) echo $websiteShortDesc; ?></textarea>
                          </div>
                        </div>
                        <hr />

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-4 col-form-label">Footer (Website page end) </label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" value="Copyright @<?php echo date('Y'); ?>" disabled>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="Enter website domain" name="domainName" value="<?php if(isset($domainName)) echo $domainName; ?>" required="required">
                          </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="update" id="update" class="btn btn-success" value="Update" />
                        </div>
                      </form>
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
