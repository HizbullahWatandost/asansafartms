<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- =============================================== -->
<?php
$logMsg = "";
// registeration
// code to save the client registeration record into database
// first of all we have to check if the form is submited or not
if(isset($_POST['register'])){
  // we validate the form so that all the required fields should have values
  if(
    !empty($_POST['fullName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['mobile']) &&
    !empty($_POST['permenatAddress']) &&
    !empty($_POST['currentAddress']) &&
    !empty($_POST['password']) &&
    !empty($_POST['passwordConfirm'])){
      // here, we will store the data from the form in our own variables
      $fullName = $database->escape_value(trim($_POST['fullName']));
      $email = $database->escape_value(trim($_POST['email']));
      $mobile = $database->escape_value(trim($_POST['mobile']));
      $permenatAddress = $database->escape_value(trim($_POST['permenatAddress']));
      $currentAddress = $database->escape_value(trim($_POST['currentAddress']));
      $password = $database->escape_value(trim($_POST['password']));
      $passwordConfirm = $database->escape_value(trim($_POST['passwordConfirm']));

      // we will check if the password and confirm password matches
      if($password !== $passwordConfirm){
        // echo '<script>alert("password do not match, please try againi");<script>';
        $_SESSION['msg'] = "Password do not match, please try again!";
        $_SESSION['type'] = "error";
      }else{// If the user use the email which is used or already registered
        $usedEmail = $database->countOf("client","clientEmail like '%$email'");
        if($usedEmail > 0){
          $_SESSION['msg'] = "The email '{$email}' is already used. Please use different email!";
          $_SESSION['type'] = "error";
        }else{// If the user is not registered with us
          // Encrypt the password in MD5 format for security purpose
          $password = MD5($password);
          // store the data into database
          $query = "INSERT INTO client(
          clientFullName,
          clientEmail,
          clientMobile,
          ClientPermenantAddress,
          clientCurrentAddress,
          clientPassword)
          VALUES(
            '{$fullName}',
            '{$email}',
            '{$mobile}',
            '{$permenatAddress}',
            '{$currentAddress}',
            '{$password}'
          )";

          if($database->query($query)){
            $_SESSION['type'] = 'success';
            $_SESSION['msg'] = 'The client has been successfully registered. :)';
            $logMsg = "The client {$email} has been successfully registerd by {$_SESSION['adminId']} successfully";
            //logging the activity
            $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
            VALUES('{$_SESSION["adminId"]}','Operator','Client registeration','{$logMsg}')";
            $database->query($sql);
          }else{
            // Send an error to the user that record was not able to be saved into database
            $_SESSION['type'] = 'error';
            $_SESSION['msg'] = 'Sorry, the client registeration failed, pleased try again. :)(:';
            $logMsg = "The client {$email} registeration by {$_SESSION['adminId']} failed";
            $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
            VALUES('{$_SESSION["adminId"]}','Operator','Client registeration','{$logMsg}')";
            $database->query($sql);
          }
        }
    }
  }else{
    // We will send an error to the user that the required fileds are not filled.
    $_SESSION['type'] = 'error';
    $_SESSION['msg'] = 'Please fill the required fileds. :)(:';
  }
}else{ // if the form is not submitted
  $_POST['fullName'] = "";
  $_POST['email'] = "";
  $_POST['mobile'] = "";
  $_POST['permenatAddress'] = "";
  $_POST['currentAddress'] = "";
  $_POST['password'] = "";
  $_POST['passwordConfirm'] = "";
  $_SESSION['type'] = "";
  $_SESSION['msg'] = "";
}

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Register a new client</title>
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

      <h4>Register a new client </h4>
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
                   <p class="text-muted text-center">Asan Safar Client</p>

                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                     <div class="form-group input-group">
                 <span class="frm-validation-err-tooltip" id="fullname_err_msg">Full Name Error</span>
                 <!-- First name -->
             		<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
             		 </div>
                     <input name="fullName" id="full-name" required="required" class="form-control" placeholder="Full name" type="text">
                 </div> <!-- form-group// -->
                 <div class="form-group input-group">
                   <span class="frm-validation-err-tooltip" id="email_err_msg">Email Error</span>
                   <!-- First name -->
                 	<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
             		 </div>
                     <input name="email" id="email" required="required" class="form-control" placeholder="Email address" type="email">
                 </div> <!-- form-group// -->
                 <div class="form-group input-group">
                   <span class="frm-validation-err-tooltip" id="mobile_err_msg">Mobile Error</span>
                 	<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
             		</div>
             		<select class="custom-select" style="max-width: 80px;">
             		    <option selected="">+93</option>
             		</select>
                 	<input name="mobile" id="mobile" required="required" class="form-control" placeholder="Phone number" type="text">
                 </div> <!-- form-group// -->
                 <div class="form-group input-group">
                   <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Permenat Address Error</span>

                 	<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
             		</div>
             		<select class="form-control" name="permenatAddress">
             			<option selected="selected" disabled="disabled"> Selected Permenat Address</option>
             			<option>Kabul</option>
             			<option>Mazar</option>
             			<option>Kunduz</option>
                   <option>Parwan</option>
                   <option>Ghazni</option>
                   <option>Takhar</option>
             		</select>
             	</div> <!-- form-group end.// -->

               <div class="form-group input-group">
                 <span class="frm-validation-err-tooltip" id="current_address_err_msg">Current Address Error</span>
                 <div class="input-group-prepend">
                   <span class="input-group-text"> <i class="fa fa-building"></i> </span>
               </div>
               <select class="form-control" name="currentAddress">
                 <option selected="selected" disabled="disabled"> Selected Current Address</option>
                 <option>Kabul</option>
                 <option>Mazar</option>
                 <option>Kunduz</option>
                 <option>Parwan</option>
                 <option>Ghazni</option>
                 <option>Takhar</option>
               </select>
             </div> <!-- form-group end.// -->

                 <div class="form-group input-group">
                   <span class="frm-validation-err-tooltip" id="pass_err_msg">Pass Error</span>
                 	<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
             		</div>
                     <input name="password" id="password" required="required" class="form-control" placeholder="Create password" type="password">
                 </div> <!-- form-group// -->
                 <div class="form-group input-group">
                   <span class="frm-validation-err-tooltip" id="confirmpass_err_msg">Confirm Pass Error</span>
                 	<div class="input-group-prepend">
             		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
             		</div>
                     <input name="passwordConfirm" id="password-confirm" required="required" class="form-control" placeholder="Repeat password" type="password">
                 </div> <!-- form-group// -->
                     <div class="row">
                       <!-- /.col -->
                       <div class="offset-sm-4 col-sm-4 text-center mb-4">
                         <button type="submit" name="register" id="register" class="btn btn-success btn-block">Register Client</button>
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
