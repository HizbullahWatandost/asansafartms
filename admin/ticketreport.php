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
  <title>Asan Safar  | Ticket Reports</title>
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
            <h4>Tickets Report </h4>
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
                          <th>Source</th>
                          <th>Destination</th>
                          <th>Departure & Arrival Date</th>
                          <th>Vehicle ID</th>
                          <th>Price</th>
                          <th>Booking Date</th>
                          <th>Client ID</th>
                          <th>Ticket Status</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;
                            $getAllTickets = $database->query("SELECT * FROM ticket");
                            while($ticket = $database->fetch_array($getAllTickets)) { ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $ticket['srcPlacce']; ?></td>
                                <td><?php echo $ticket['destPlace']; ?></td>
                                <td><?php echo $ticket['departureDate']." --- ".$ticket['arrivalDate']; ?></td>
                                <td><?php echo $ticket['vehicleId']; ?></td>
                                <td><?php echo $ticket['price']; ?></td>
                                <td><?php echo $ticket['bookingDate']; ?></td>
                                <td><?php echo $ticket['ticketId']; ?></td>
                                <td><?php if($ticket['status'] === "0"){
                                  echo "Unbooked";
                                }else if($ticket['status'] === "1"){
                                  echo "Booked";
                                }else{
                                  echo "Pending";
                                }
                                ?>
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
      <?php
      include ('includes/comnscripts.php');
       ?>
</body>
</html>
