<?php
  include ('inc/db_connection_session.php');
  if(!isset($_SESSION['adminId'])){
    redirect_to('login.php');
  }
  include ('inc/admin_register.php');
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Register a new admin</title>
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

      <h4>Register a new admin </h4>
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

                   <p class="text-muted text-center">Asan Safar Admin</p>

                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                     <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Full name" name="fullName">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-user"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="email" class="form-control" placeholder="Email" name="email">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="text" class="form-control" placeholder="Mobile" name="mobile">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-mobile"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="password" class="form-control" placeholder="Password" name="password">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                         </div>
                       </div>
                     </div>
                     <div class="input-group mb-3">
                       <input type="password" class="form-control" placeholder="Retype password" name="passwordConfirm">
                       <div class="input-group-append">
                         <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                         </div>
                       </div>
                     </div>
                     <div class="row">
                       <div class="col-8">
                         <div class="icheck-primary">
                           <input type="checkbox" id="agreeTerms" name="terms" value="agree">

                         </div>
                       </div>
                     </div>
                     <div class="text-center">
                       <!-- /.col -->
                       <div class="offset-sm-4 col-sm-4">
                         <button type="submit" name="adminRegister" class="btn btn-primary btn-block">Register</button>
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
<!-- alert the client for successful or failure registeration/login -->
<?php
    if (isset($_SESSION ['msg'])){
      echo $_SESSION ['msg'];
      unset ($_SESSION ['type']);
      unset ($_SESSION ['msg']);
    }
  ?>
</body>
</html>
