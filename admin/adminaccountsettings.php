<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- =============================================== -->

<?php
// fetching the logged in admin details
if(isset($_SESSION['adminId'])){
  $id = $_SESSION['adminId'];
  $query = "SELECT * FROM admin WHERE adminId = '{$id}' LIMIT 1";
  $result = $database->query($query);
  $result = mysqli_fetch_array($result);

  $adminFullName = $result['adminFullName'];
  $adminEmail = $result['adminEmail'];
  $adminMobile = $result['adminMobile'];
  $userType = $result['role'];
}
 ?>
 <?php
   // If it is update section of the form below operation will be fullfil
   // website logo and name update
   if(isset($_POST['update'])) {
     // We will validate the form so that all the required fields should have value
     if(
       !empty($_POST['fullName']) &&
       !empty($_POST['email']) &&
       !empty($_POST['mobile'])
     ) {
       // We will store the data from the form in our own variables

       $fullName = $database->escape_value(trim($_POST['fullName']));
       $email = $database->escape_value(trim($_POST['email']));
       $mobile = $database->escape_value(trim($_POST['mobile']));


           // Store the data in the database without updating the image column
           $query = "UPDATE admin SET adminFullName ='{$fullName}', adminEmail='{$email}', adminMobile = '{$mobile}' WHERE adminId = '{$id}' LIMIT 1";
           if($database->query($query)) {
               // Send a success message that the record has been inserted and refresh the page
               $_SESSION['type'] = 'success';
               $_SESSION['msg'] = 'Your details has been updated successfully. :)';
               if($_SESSION['userType'] === "Admin"){
                 $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
                 VALUES('{$email}','Admin','Updating account','The admin {$email} has succesfully update his/her account')";
                 $database->query($sql);
               }else if($_SESSION['userType'] === "Operator"){
                 $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
                 VALUES('{$email}','Operator','Updating account','The operator {$email} has succesfully update his/her account')";
                 $database->query($sql);
               }
               session_unset();
               session_destroy();
               redirect_to("index.php");
           } else {
               // Send an error message to the user that record was not able to be save
               $_SESSION['msg'] = 'Sorry! There is an error updating your details! <br /> Please try again later. :(';
               $_SESSION['type'] = 'error';
           }
       }else{
         // we will send an error message to user that required fields are not filed
         $_SESSION['msg'] = 'Please fill all the required fields';
         $_SESSION['type'] = 'error';
       }

     } else {
      $_SESSION['msg'] = '';
      $_SESSION['type'] = '';
      $logMsg = "";
   }

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Account Settings</title>
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

      <h4>Account Settings </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm">
            <div class="card">
              <div class="card-body">
                  <div class="active tab-pane">
                    <div class="tab-pane">
                      <!-- Profile Image -->
               <div class="card card-primary card-outline offset-sm-2 col-sm-8">
                 <div class="card-body box-profile">
                   <div class="text-center">
                     <img class="profile-user-img img-circle"
                          src="imgs/default/user_login_icon.png"
                          alt="User profile picture" width="50" height="100">
                   </div>

                   <h3 class="profile-username text-center"><?php if(isset($adminFullName)) echo $adminFullName; ?></h3>

                   <p class="text-muted text-center">Asan Safar Admin User</p>

                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                     <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Full name" name="fullName" value="<?php if(isset($adminFullName)) echo $adminFullName; ?>" required="required">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-user"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="email" class="form-control" placeholder="Email" name="email" value="<?php if(isset($adminEmail)) echo $adminEmail; ?>" required="required">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="<?php if(isset($adminMobile)) echo $adminMobile; ?>" required="required">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-mobile"></span>
                         </div>
                       </div>
                     </div>

                     </div>
                     <div class="row">
                       <!-- /.col -->
                       <div class="offset-sm-4 col-sm-4 text-center mb-4">
                         <button type="submit" name="update" id="update" class="btn btn-success btn-block">Update</button>
                       </div>
                       <!-- /.col -->
                     </div>
                   </form>
                 </div>
                 <!-- /.card-body -->
               </div>
               <!-- /.card -->

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
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
