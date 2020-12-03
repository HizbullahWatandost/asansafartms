<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Calender</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include ('includes/comnstyles.php'); ?>
  <style>
         /* Set the size of the div element that contains the map */
        #map {
          height: 400px;  /* The height is 400 pixels */
          width: 100%;  /* The width is the width of the web page */
         }

         background-image: url(https://maps.googleapis.com/maps/api/staticmap?center=Albany,+NY&zoom=13&scale=1&size=600x300&maptype=roadmap&format=png&visual_refresh=true);
      </style>
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

      <h4>Google Map </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <!-- Main content -->

                    <!--The div element for the map -->
                    <div id="map"></div>
              <!-- /.content-wrapper -->
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
<script>
// Initialize and add the map
function initMap() {
 // The location of Uluru
 var uluru = {lat: 34.543890, lng: 69.160652};
 // The map, centered at Uluru
 var map = new google.maps.Map(
     document.getElementById('map'), {zoom: 4, center: uluru});
 // The marker, positioned at Uluru
 var marker = new google.maps.Marker({position: uluru, map: map});
}
   </script>
   <!--Load the API from the specified URL
   * The async attribute allows the browser to render the page while the API loads
   * The key parameter will contain your own API key (which is not needed for this tutorial)
   * The callback parameter executes the initMap() function
   -->
   <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVCcjSwXdYOG-YQrBPMmFuJW5UHmb190Y&callback=initMap&language=fa&region=AFG">
</script>

</body>
</html>
