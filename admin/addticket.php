<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php
$logMsg = "";
 $target_path = 'data/vehicleimgs/';
 $fileOK = 1;
 if(isset($_POST['register'])){

   if(!empty($_POST['srcPlace']) && !empty($_POST['destPlace']) && !empty($_POST['distance']) && !empty($_POST['departureDate'])
      &&!empty($_POST['arrivalDate']) && !empty($_POST['departureTime']) && !empty($_POST['arrivalTime']) && !empty($_POST['vehicleId'])
      && !empty($_POST['setNo']) && !empty($_POST['ticketPrice']) && !empty($_POST['discount'])){// check if the websitet name is not  empty
        $srcPlace = $database->escape_value(trim($_POST['srcPlace']));
        $destPlace = $database->escape_value(trim($_POST['destPlace']));
        $distance = $database->escape_value(trim($_POST['distance']));
        $departureDate = $database->escape_value(trim($_POST['departureDate']));
        $arrivalDate = $database->escape_value(trim($_POST['arrivalDate']));
        $departureTime = $database->escape_value(trim($_POST['departureTime']));
        $arrivalTime = $database->escape_value(trim($_POST['arrivalTime']));
        $vehicleId = $database->escape_value(trim($_POST['vehicleId']));
        $setNo = $database->escape_value(trim($_POST['setNo']));
        $ticketPrice = $database->escape_value(trim($_POST['ticketPrice']));
        $discount = $database->escape_value(trim($_POST['discount']));
        // store the data into database
        $sql = "SELECT vehicleType FROM vehicle WHERE vehicleId = '$vehicleId'";
        $result = $database->query($sql);
        $result = mysqli_fetch_array($result);
        $vehicleType = $result['vehicleType'];

        $query = "INSERT INTO ticket(
        srcPlacce,
        destPlace,
        distance,
        departureDate,
        arrivalDate,
        departureTime,
        arrivalTime,
        vehicleId,
        setNo,
        price,
        discount,
        vehicleType)
        VALUES(
          '{$srcPlace}',
          '{$destPlace}',
          '{$distance}',
          '{$departureDate}',
          '{$arrivalDate}',
          '{$departureTime}',
          '{$arrivalTime}',
          '{$vehicleId}',
          '{$setNo}',
          '{$ticketPrice}',
          '{$discount}',
          '{$vehicleType}'
        )";

        if($database->query($query)){
          $_SESSION['type'] = 'success';
          $_SESSION['msg'] = 'The ticket has been successfully added';
          $logMsg = "The ticket has been added by operator {$_SESSION['adminId']}";
        }else{
          $_SESSION['type'] = 'error';
          $_SESSION['msg'] = 'Sorry, adding ticket failed';
          $logMsg = "The ticket registeration by operator {$_SESSION['adminId']} failed";

        }
    }else{
       $_SESSION['type'] = 'error';
       $_SESSION['msg'] = 'Please fill the required fields';
        }
 }else{
   $_SESSION['type'] = '';
   $_SESSION['msg'] = '';
 }

  if(isset($logMsg) && !empty($logMsg)){
    $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
    VALUES('{$_SESSION["adminId"]}','Operator','Ticket registeration','{$logMsg}')";
    $database->query($sql);
  }
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Add Ticket</title>
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

      <h4> Asan Safar | Add Ticket </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <div class="active tab-pane">
                  <div class="tab-pane">
                    <div class="card card-primary card-outline offset-sm-2 col-sm-8">
                      <div class="card-body box-profile">
                        <div class="text-center">
                          <img class="profile-user-img img-circle" src="imgs/default/vehicle-con.png" alt="User profile picture" width="50" height="100">
                        </div>
                        <p class="text-muted text-center">Asan Safar Add Ticket</p>
                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                          <div class="form-group input-group">
                            <!-- /.form-group -->
                            <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                             <div class="input-group-prepend">
                               <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
                             </div>
                              <select class="form-control select2bs4" name="srcPlace">
                                <option selected="selected" disabled = "disabled">Select the source place</option>
                                <option>Kabul</option>
                                <option>Mazar</option>
                                <option>Laghman</option>
                                 <option>Parwan</option>
                                 <option>Takhar</option>
                                 <option>Qandhar</option>
                              </select>
                          </div>

                          <div class="form-group input-group">
                            <!-- /.form-group -->
                            <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                             <div class="input-group-prepend">
                               <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
                             </div>
                              <select class="form-control select2bs4" name="destPlace">
                                <option selected="selected" disabled = "disabled">Select the destination place</option>
                                <option>Kabul</option>
                                <option>Mazar</option>
                                <option>Laghman</option>
                                 <option>Parwan</option>
                                 <option>Takhar</option>
                                 <option>Qandhar</option>
                              </select>
                          </div>

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
                            <!-- First name -->
                        		<div class="input-group-prepend">
                        		    <span class="input-group-text"> <i class="fa fa-road"></i> </span>
                        		</div>
                            <input name="distance" id="distance" required="required" class="form-control" placeholder="Enter the distance" type="text" />
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fas fa-calendar-alt"></i> </span>
                            </div>
                            <input name="departureDate" type="date" class="form-control" placeholder="Select the departure time" aria-label="Recipient's username" aria-describedby="basic-addon2" required="required">
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fas fa-calendar-alt"></i> </span>
                            </div>
                            <input name="arrivalDate" type="date" class="form-control" placeholder="Select arrival time" aria-label="Recipient's username" aria-describedby="basic-addon2" required="required">
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <div class="input-group date" id="timepickerDeparture" data-target-input="nearest">
                              <div class="input-group-prepend" data-target="#timepickerDeparture" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div>
                              <input name="departureTime" placeholder="Select the departure time" type="text" class="form-control datetimepicker-input" data-target="#timepickerDeparture" required="required"/>
                          </div>
                         </div> <!-- form-group end.// -->

                         <div class="form-group input-group">
                           <div class="input-group date" id="timepickerArrival" data-target-input="nearest">
                             <div class="input-group-prepend" data-target="#timepickerArrival" data-toggle="datetimepicker">
                                 <div class="input-group-text"><i class="far fa-clock"></i></div>
                             </div>
                             <input name="arrivalTime" placeholder="Select the arrival time"type="text" class="form-control datetimepicker-input" data-target="#timepickerArrival" required="required"/>
                         </div>
                        </div> <!-- form-group end.// -->

                        <div class="form-group input-group">
                          <!-- /.form-group -->
                          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                           <div class="input-group-prepend">
                             <span class="input-group-text"> <i class="fas fa-bus-alt"></i> </span>
                           </div>
                            <select class="form-control select2bs4" name="vehicleId">
                              <option selected="selected" disabled = "disabled">Enter the vehicle owner ID</option>
                              <?php
                                $queryVehicle = "SELECT vehicleId FROM vehicle";
                                $vehicleIds = $database->query($queryVehicle);
                                while($vehicle = $database->fetch_array($vehicleIds)){
                               ?>
                              <option><?php if(isset($vehicle['vehicleId'])) echo $vehicle['vehicleId']; ?></option>
                            <?php } ?>
                            </select>
                        </div>

                        <div class="form-group input-group">
                          <!-- /.form-group -->
                          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                           <div class="input-group-prepend">
                             <span class="input-group-text"> <i class="fas fa-chair"></i> </span>
                           </div>
                            <select class="form-control select2bs4" name="setNo">
                              <option selected="selected" disabled = "disabled">Select set number</option>
                              <?php
                                for($i = 1; $i<=100; $i++){
                                  echo '<option>'.$i.'</option>';
                                }
                               ?>
                            </select>
                        </div>

                        <div class="form-group input-group">
                          <!-- /.form-group -->
                          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                           <div class="input-group-prepend">
                             <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
                           </div>
                            <select class="form-control select2bs4" name="ticketPrice">
                              <option selected="selected" disabled = "disabled">Enter ticket price</option>
                              <?php
                                for($i = 50; $i<=2000; $i = $i+10){
                                  echo '<option>'.$i.' AFN </option>';
                                }
                               ?>
                            </select>
                        </div>

                        <div class="form-group input-group">
                          <!-- /.form-group -->
                          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                           <div class="input-group-prepend">
                             <span class="input-group-text"> <i class="fa fa-percent"></i> </span>
                           </div>
                            <select class="form-control select2bs4" name="discount">
                              <option selected="selected" disabled = "disabled">Enter the discount</option>
                              <?php
                                for($i = 0; $i<=80; $i++){
                                  echo '<option>'.$i.' % </option>';
                                }
                               ?>
                            </select>
                        </div>

                          <div class="row">
                            <!-- /.col -->
                            <div class="offset-sm-4 col-sm-4 text-center mb-4">
                              <input type="submit" name="register" class="btn btn-block btn-success" />
                            </div>
                            <!-- /.col -->
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
                  <!-- /.tab-pane -->
              </div>
                <!-- /.tab-content -->
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
<?php
    if (isset($_SESSION ['msg'])){
      echo $_SESSION ['msg'];
      unset ($_SESSION ['type']);
      unset ($_SESSION ['msg']);
    }
  ?>
<script>
  // time picker
  $(function () {
    //Timepicker
    $('#timepickerDeparture').datetimepicker({
      format: 'LT'
    })
    $('#timepickerArrival').datetimepicker({
      format: 'LT'
    })
  })
  </script>
</body>
</html>
