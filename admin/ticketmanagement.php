<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php
$logMsg = "";
 if(isset($_POST['update'])){

   if(!empty($_POST['srcPlacce']) && !empty($_POST['destPlace']) && !empty($_POST['distance']) && !empty($_POST['departureDate'])
      &&!empty($_POST['arrivalDate']) && !empty($_POST['departureTime']) && !empty($_POST['arrivalTime']) && !empty($_POST['vehicleId'])
      && !empty($_POST['setNo']) && !empty($_POST['ticketPrice']) && !empty($_POST['discount']) && !empty($_POST['ticketStatus'])){// check if the websitet name is not  empty

        $ticketId = $database->escape_value(trim($_POST['ticketId']));
        $srcPlacce = $database->escape_value(trim($_POST['srcPlacce']));
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
        $status = $database->escape_value(trim($_POST['ticketStatus']));
        if($status === "Unbooked"){
          $status = "0";
        }else if($status === "Booked"){
          $status = "1";
        }else{
          $status = "2";
        }

           $query = "UPDATE ticket SET srcPlacce = '{$srcPlacce}', destPlace = '{$destPlace}', distance = '{$distance}', departureDate = '{$departureDate}', arrivalDate = '{$arrivalDate}', departureTime = '{$departureTime}', arrivalTime = '{$arrivalTime}', vehicleId = '{$vehicleId}',setNo='{$setNo}',price= '{$ticketPrice}',discount='{$discount}',status = '{$status}' WHERE ticketId = '{$ticketId}' LIMIT 1";
            if($database->query($query)) {
              $_SESSION['type'] = 'success';
              $_SESSION['msg'] = 'The ticket details have been successfully saved';
              $logMsg = "The ticket {$ticketId} has  been updated by operator {$_SESSION['adminId']}";
            }else{
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Sorry, there was error while updating the agency details!!!';
              $logMsg = "The ticket {$ticketId} update by operator {$_SESSION['adminId']} failed";
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
    VALUES('{$_SESSION["adminId"]}','Operator','Ticket update','{$logMsg}')";
    $database->query($sql);
  }
  ?>
    <?php // Check if the ID is set in the URL and then populate it in the form
      if(isset($_GET['id'])) {
        // Query the database to get the value for the provided ID
        $q = 'SELECT * FROM ticket WHERE ticketId='.$_GET['id'].' LIMIT 1';
        $r = $database->query($q);
        $ticket = $database->fetch_array($r);
        $ticketId=$ticket['ticketId'];
        $srcPlacce=$ticket['srcPlacce'];
        $destPlace=$ticket['destPlace'];
        $distance=$ticket['distance'];
        $departureDate=$ticket['departureDate'];
        $arrivalDate=$ticket['arrivalDate'];
        $departureTime=$ticket['departureTime'];
        $arrivalTime=$ticket['arrivalTime'];
        $vehicleId=$ticket['vehicleId'];
        $setNo=$ticket['setNo'];
        $ticketPrice=$ticket['price'];
        $discount=$ticket['discount'];
        $ticketStatus = $ticket['status'];
        if($ticketStatus === '0'){
          $ticketStatus = "Unbooked";
        }else if($ticketStatus === "1"){
          $ticketStatus = "Booked";
        }else{
          $ticketStatus = "Pending";
        }
        // Store the data retrived from the database into variables
      }
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Ticket Management</title>
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

               <h4>Asan Safar | Ticket Management </h4>
               <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
     <div class="card card-primary card-outline">
       <div class="card-body box-profile">
         <div class="text-center">
           <img class="profile-user-img img-circle"
                src="imgs/default/vehicle-con.png"
                alt="User profile picture" width="50" height="100">
         </div>
         <p class="text-muted text-center">Asan Safar Vehicles</p>

         <form <?php if(isset($_GET['id'])) { ?> action="<?php echo $_SERVER['PHP_SELF']; ?>?update=true&id=<?php echo $_GET['id']; ?>" <?php } ?>
        action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" enctype="multipart/form-data">
        <div class="form-group input-group">
      <!-- /.form-group -->
      <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
       <div class="input-group-prepend">
         <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
       </div>
        <select class="form-control select2bs4" name="srcPlacce">
          <option selected="selected"><?php echo isset($srcPlacce)? $srcPlacce : "Select Source Place"; ?></option>
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
               <option selected="selected"><?php echo isset($destPlace)? $destPlace : "Select Destination Place"; ?></option>
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
           <input name="distance" id="distance" required="required" class="form-control" placeholder="Enter the distance" type="text" value="<?php if(isset($distance)) echo $distance; ?>"/>
         </div> <!-- form-group// -->

         <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fas fa-calendar-alt"></i> </span>
          </div>
          <input name="departureDate" type="date" class="form-control" placeholder="Select the departure time" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php if(isset($departureDate)) echo $departureDate; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fas fa-calendar-alt"></i> </span>
          </div>
          <input name="arrivalDate" type="date" class="form-control" placeholder="Select arrival time" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php if(isset($arrivalDate)) echo $arrivalDate; ?>">
        </div> <!-- form-group// -->
        <div class="form-group input-group">
          <div class="input-group date" id="timepickerDeparture" data-target-input="nearest">
            <div class="input-group-prepend" data-target="#timepickerDeparture" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-clock"></i></div>
            </div>
            <input name="departureTime" placeholder="Select the departure time" type="text" class="form-control datetimepicker-input" data-target="#timepickerDeparture" value="<?php if(isset($departureTime)) echo $departureTime; ?>"/>
        </div>
       </div> <!-- form-group end.// -->

       <div class="form-group input-group">
         <div class="input-group date" id="timepickerArrival" data-target-input="nearest">
           <div class="input-group-prepend" data-target="#timepickerArrival" data-toggle="datetimepicker">
               <div class="input-group-text"><i class="far fa-clock"></i></div>
           </div>
           <input name="arrivalTime" placeholder="Select the arrival time"type="text" class="form-control datetimepicker-input" data-target="#timepickerArrival" value="<?php if(isset($arrivalTime)) echo $arrivalTime; ?>"/>
       </div>
      </div> <!-- form-group end.// -->

      <div class="form-group input-group">
        <!-- /.form-group -->
        <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
         <div class="input-group-prepend">
           <span class="input-group-text"> <i class="fas fa-bus-alt"></i> </span>
         </div>
          <select class="form-control select2bs4" name="vehicleId">
            <option selected="selected"><?php echo isset($vehicleId)? $vehicleId : "Select vehicle ID"; ?></option>
            <?php
              $queryTickets = "SELECT ticketId FROM ticket";
              $ticketIds = $database->query($queryTickets);
              while($ticket = $database->fetch_array($ticketIds)){
             ?>
            <option><?php if(isset($ticket['ticketId'])) echo $ticket['ticketId']; ?></option>
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
                 <option selected="selected"><?php echo isset($setNo)? $setNo : "Select the set number"; ?></option>
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
                 <option selected="selected"><?php echo isset($ticketPrice)? $ticketPrice : "Enter the ticket price"; ?></option>
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
                 <option selected="selected"><?php echo isset($discount)? $discount : "Enter the discount"; ?></option>
                 <?php
                   for($i = 0; $i<=80; $i++){
                     echo '<option>'.$i.' % </option>';
                   }
                  ?>
               </select>
           </div>

           <div class="form-group input-group">
             <span class="frm-validation-err-tooltip" id="ticke_booked_pending_unbooked">Ticket Status</span>
             <div class="input-group-prepend">
               <span class="input-group-text"> <i class="fa fa-hourglass"></i> </span>
           </div>
           <select class="form-control" name="ticketStatus">
             <option selected="selected"><?php echo $ticketStatus; ?></option>
             <option>Unbooked</option>
             <option>Pending</option>
             <option>Booked</option>
           </select>
         </div> <!-- form-group end.// -->

      <?php
        if(isset($_GET['update']) && $_GET['update'] === 'true'){
          echo '
              <div class="text-center">
                <!-- /.col -->
                <div class="text-center">
                  <input name="ticketId" type="hidden" value="'.$_GET['id'].'">
                  <button type="submit" name="update" id="updateAgency" class="btn btn-success btn-block update">Update Ticket</button>
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
                     <th>Departure & Arrival Date</th>
                     <th>Vehicle ID</th>
                     <th>Price</th>
                     <th>Booking Date</th>
                     <th>Client ID</th>
                     <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                      $getAllTicket = $database->query("SELECT * FROM ticket");
                      while($ticket = $database->fetch_array($getAllTicket)) { ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $ticket['departureDate']." --- ".$ticket['arrivalDate']; ?></td>
                          <td><?php echo $ticket['vehicleId']; ?></td>
                          <td><?php echo $ticket['price']; ?></td>
                          <td><?php echo $ticket['bookingDate']; ?></td>
                          <td><?php echo $ticket['ticketId']; ?></td>
                          <td>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=false&id='.$ticket['ticketId']; ?>" class="text-primary"><i class="fas fa-eye"></i></a>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=true&id='.$ticket['ticketId']; ?>" class="text-warning"><i class="fas fa-edit"></i></a>
                            <a href="" id="<?php echo $ticket['ticketId']; ?>" onClick="deleteRecord(this.id,'inc/ticket_delete.php','Deleted')" class="text-danger"><i class="fas fa-trash"></i> </a>
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
