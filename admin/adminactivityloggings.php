<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- =============================================== -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Admin Activiy Loggings</title>
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
            <h4>Admins Activity Loggings </h4>
            <hr />
            <div class="container-fluid">
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <table id="example" class="table table-bordered table-striped">
                        <thead style="font-size:.8em !important;background-color:gray;color:#fff;">
                        <tr>
                          <th>#</th>
                          <th>User Name</th>
                          <th>User Type</th>
                          <th>Activity Type</th>
                          <th>Log Message</th>
                          <th>Log Date Time</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;
                            $getAdminLog = $database->query("SELECT * FROM logging WHERE userType = 'Admin' OR userType = 'admin'");
                            while($log = $database->fetch_array($getAdminLog)) { ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $log['userName']; ?></td>
                                <td><?php echo $log['userType']; ?></td>
                                <td><?php echo $log['activityType']; ?></td>
                                <td><?php echo $log['logMsg']; ?></td>
                                <td><?php echo $log['logDatetime']; ?></td>
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
      <?php
      include ('includes/comnscripts.php');
       ?>
</body>
</html>
