<?php
  include ('inc/db_connection_session.php');
  include ('inc/admin_login.php');
?>
<?php
if(isset($_SESSION['adminId'])){
  redirect_to('index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar Admin Panel | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php include 'includes/comnstyles.php'; ?>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="userName" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="loginPass" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="social-auth-links text-center mb-3">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id = "admin" class="custom-control-input" name="userType" checked = "checked" value="Admin">
            <label class="custom-control-label" for="admin">Admin</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio"  id = "operator" class="custom-control-input" name="userType" value="Operator">
            <label class="custom-control-label" for="operator">Operator</label>
          </div>
      </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button name = "adminLogin" type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->
<!--
      <p class="social-auth-links text-center mb-3">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="social-auth-links text-center mb-3">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php include 'includes/comnscripts.php'; ?>
<!-- alert the client for successful or failure registeration/login -->
<?php
    if (isset($_SESSION ['loginMsg'])){
      echo $_SESSION ['loginMsg'];
      unset ($_SESSION ['loginStatus']);
      unset ($_SESSION ['loginMsg']);
    }
  ?>
</body>
</html>
