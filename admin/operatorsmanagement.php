<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- =============================================== -->

<?php
    // If it is update section of the form below operation will be fullfil
    if(isset($_POST['update'])) {
      if(
        !empty($_POST['fullName']) &&
        !empty($_POST['email']) &&
        !empty($_POST['mobile']) &&
        !empty($_POST['password']) &&
        !empty($_POST['passwordConfirm']) &&
        !empty($_POST['adminStatus'])){
          // here, we will store the data from the form in our own variables
          $adminId = $database->escape_value(trim($_POST['adminId']));
          $fullName = $database->escape_value(trim($_POST['fullName']));
          $email = $database->escape_value(trim($_POST['email']));
          $mobile = $database->escape_value(trim($_POST['mobile']));
          $password = $database->escape_value(trim($_POST['password']));
          $passwordConfirm = $database->escape_value(trim($_POST['passwordConfirm']));
          $adminStatus = $database->escape_value(trim($_POST['adminStatus']));
          if($adminStatus === 'Lock'){
            $adminStatus = '0';
          }else{
            $adminStatus = '1';
          }

        // We will check if the password fields are empty or not
        if(!empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {

          // We will check if the password and confirm password matches
          if($_POST['password'] !== $_POST['passwordConfirm']) {
            // echo '<script>alert("Passwords do not match, please try again");</script>';
            $_SESSION['msg'] = "Passwords do not match please try again";
            $_SESSION['type'] = 'error';
          } else {

            $q = "SELECT adminPassword,adminEmail FROM admin WHERE adminId = '{$adminId}' LIMIT 1";
            $result = $database->query($q);
            $result = mysqli_fetch_array($result);
            $adminOldPass = $result['adminPassword'];
            $adminOldEmail = $result['adminEmail'];

            if($adminOldPass !== $password){
              $password = md5($_POST['password']);
            }
            $usedEmail = $database->countOf("admin","adminEmail like '%$email'");
            if($adminOldEmail !== $email && $usedEmail > 0){
              $_SESSION['msg'] = "The email '{$email}' is already used. Please use different email!";
              $_SESSION['type'] = "error";
            }else{
              // Store the data in the database
              $query = "UPDATE admin SET adminFullName='{$fullName}',adminEmail='{$email}',adminMobile='{$mobile}',adminPassword = '{$password}', admintStatus = '{$adminStatus}' WHERE adminId={$adminId} LIMIT 1";

              if($database->query($query)) {

                // Send a success message that the record has been inserted and refresh the page
                $_SESSION['type'] = 'success';
                $_SESSION['msg'] = 'Operator details has been updated successfully. :)';
                if(isset($_SESSION['userType'])){
                  $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
                  VALUES('{$_SESSION["adminId"]}','Admin','Updating Operator','The operator with email {$email} succesfully updated by admin {$_SESSION["adminId"]} ')";
                  $database->query($sql);
                }
              } else {

                // Send an error message to the user that record was not able to be save
                $_SESSION['msg'] = 'Sorry! There is an error updating this record! <br /> Please try again later. :(';
                $_SESSION['type'] = 'error';
              }
            }
          }

        } else {
          // Send an error message to the user that record was not able to be save
          $_SESSION['msg'] = 'Please fill the password fields. :(';
          $_SESSION['type'] = 'error';
        }

      } else {
        // we will send an error message to user that required fields are not filed
        $_SESSION['msg'] = 'Please fill all the required fields';
        $_SESSION['type'] = 'error';
      }

      redirect_to("adminmanagement.php");
    }

  ?>
    <?php // Check if the ID is set in the URL and then populate it in the form
      if(isset($_GET['id'])) {
        // Query the database to get the value for the provided ID
        $q = 'SELECT * FROM admin WHERE adminId='.$_GET['id'].' LIMIT 1';
        $r = $database->query($q);
        $admin = $database->fetch_array($r);

        // Store the data retrived from the database into variables
        $adminFullName = $admin['adminFullName'];
        $adminEmail = $admin['adminEmail'];
        $adminMobile = $admin['adminMobile'];
        $adminOldPass = $admin['adminPassword'];
        $oldadminStatus = $admin['admintStatus'];
        if($oldadminStatus === '1'){
          $oldadminStatus = 'Unlocked';
        }else{
          $oldadminStatus = 'locked';
        }
      }
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Admins Management</title>
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
  <div class="content-wrapper">

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

               <h4>Admins Management </h4>
               <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
     <div class="card card-primary card-outline">
       <div class="card-body box-profile">
         <div class="text-center">
           <img class="profile-user-img img-circle"
                src="imgs/default/user_login_icon.png"
                alt="User profile picture" width="50" height="100">
         </div>
         <p class="text-muted text-center">Asan Safar Admin</p>

         <form <?php if(isset($_GET['id'])) { ?> action="<?php echo $_SERVER['PHP_SELF']; ?>?update=true&id=<?php echo $_GET['id']; ?>" <?php } ?>
        action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
           <div class="form-group input-group">
       <span class="frm-validation-err-tooltip" id="fullname_err_msg">Full Name Error</span>
       <!-- First name -->
      <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-user"></i> </span>
       </div>
           <input name="fullName" id="full-name" required="required" class="form-control" placeholder="Full name" type="text" value="<?php if(isset($adminFullName)) echo $adminFullName; ?>">
       </div> <!-- form-group// -->
       <div class="form-group input-group">
         <span class="frm-validation-err-tooltip" id="email_err_msg">Email Error</span>
         <!-- First name -->
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
       </div>
           <input name="email" id="email" required="required" class="form-control" placeholder="Email address" type="email" value="<?php if(isset($adminEmail)) echo $adminEmail; ?>">
       </div> <!-- form-group// -->
       <div class="form-group input-group">
         <span class="frm-validation-err-tooltip" id="mobile_err_msg">Mobile Error</span>
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
      </div>
        <input name="mobile" id="mobile" required="required" class="form-control" placeholder="Phone number" type="text" value="<?php if(isset($adminMobile)) echo $adminMobile; ?>">
       </div> <!-- form-group// -->

      <?php
        if(isset($_GET['update']) && $_GET['update'] === 'true'){
          echo '
          <div class="form-group input-group">
            <span class="frm-validation-err-tooltip" id="pass_err_msg">Pass Error</span>
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
              <input name="password" id="password" required="required" class="form-control passConfirm" placeholder="Create password" type="password" value="'.$adminOldPass.'">
          </div> <!-- form-group// -->
          <div class="form-group input-group">
            <span class="frm-validation-err-tooltip" id="confirmpass_err_msg">Confirm Pass Error</span>
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
              <input name="passwordConfirm" id="password-confirm" required="required" class="form-control password" placeholder="Repeat password" type="password" value="'.$adminOldPass.'">
          </div> <!-- form-group// -->

          <div class="form-group input-group">
            <span class="frm-validation-err-tooltip" id="admin_lock_unlock">admin lock & unlock</span>
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
          <select class="form-control" name="adminStatus">
            <option selected="selected">'.$oldadminStatus.'</option>
            <option>'?><?php
            if($oldadminStatus === "Unlocked"){
              echo 'Lock';
            }else{
              echo 'Unlock';
            }
            echo '</option>
          </select>
        </div> <!-- form-group end.// -->
        <div class="text-center">
          <!-- /.col -->
          <div class="text-center">
            <input name="adminId" type="hidden" value="'.$_GET['id'].'">
            <button type="submit" name="update" id="updateadmin" class="btn btn-success btn-block update">Update admin</button>
          </div>
          <!-- /.col -->
        </div>
    ';
        }
      ?>

         </form>
       </div>
       <!-- /.card-body -->
     </div>
     <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped" style="font-size:.8em;">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                      $getAllUsers = $database->query("SELECT * FROM admin where role = 'operator'");
                      while($admin = $database->fetch_array($getAllUsers)) { ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $admin['adminFullName']; ?></td>
                          <td><?php echo $admin['adminEmail']; ?></td>
                          <td><?php echo $admin['adminMobile']; ?></td>
                          <td><?php if($admin['admintStatus'] === '1') {
                                        echo 'Unlocked';
                                      }else {
                                        echo 'Locked';
                                      } ?></td>
                          <td>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=false&id='.$admin['adminId']; ?>" class="text-primary"><i class="fas fa-eye"></i></a>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=true&id='.$admin['adminId']; ?>" class="text-warning"><i class="fas fa-edit"></i></a>
                            <a href="" id="<?php echo $admin['adminId']; ?>" onClick="deleteRecord(this.id,'inc/admin_delete.php','Deleted')" class="text-danger"><i class="fas fa-trash"></i> </a>
                          </td>
                        </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

</div>
<!-- ./wrapper -->

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
