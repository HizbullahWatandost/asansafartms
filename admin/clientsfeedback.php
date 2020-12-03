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
  <title>Asan Safar  | Clients' Feedback</title>
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
            <h4> Clients' Feedback </h4>
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
                          <th>Client ID</th>
                          <th>Client Name</th>
                          <th>Suggestion</th>
                          <th>Question 1</th>
                          <th>Question 2</th>
                          <th>Question 3</th>
                          <th>Question 4</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;
                            $getAllFeedbacks = $database->query("SELECT * FROM feedbackcollections");
                            while($feedback = $database->fetch_array($getAllFeedbacks)) { ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $feedback['clientId']; ?></td>
                                <td><?php echo $feedback['customerFullName']; ?></td>
                                <td><?php echo $feedback['suggestion']; ?></td>
                                <td><?php echo $feedback['question1']." | ".$feedback['answer1']; ?></td>
                                <td><?php echo $feedback['question2']." | ".$feedback['answer2']; ?></td>
                                <td><?php echo $feedback['question3']." | ".$feedback['answer3']; ?></td>
                                <td><?php echo $feedback['question4']." | ".$feedback['answer4']; ?></td>
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
