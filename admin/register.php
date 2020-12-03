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
  <title>Asan Safar Admin Panel | Registration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php include 'includes/comnstyles.php'; ?>
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
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new admin</p>

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

      <div class="social-auth-links text-center">
        <p>- OR -</p>
      <a href="login.php" class="text-center">I already have a membership</a>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<?php include 'includes/comnscripts.php'; ?>

<!-- alert the client for successful or failure registeration/login -->
<?php
    if (isset($_SESSION ['adminRegisterMsg'] )) {
      echo $_SESSION ['adminRegisterMsg'];
      /*
       * After first time log in the message session($_SESSION['msg']) should be unset.
       * If it is not unset, the client will get log in message at very time he/she refreshes the page.
       */
      unset ($_SESSION ['adminRegisterStatus']);
      unset ($_SESSION ['adminRegisterMsg']);
    }
    if (isset($_SESSION ['loginMsg'] )) {
      echo $_SESSION ['loginMsg'];
      unset ($_SESSION ['loginStatus']);
      unset ($_SESSION ['loginMsg']);
    }
    ?>
</body>
</html>
