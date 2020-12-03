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

 if(isset($_POST['update'])){

   if(!empty($_POST['vehiclePlanteNo']) && !empty($_POST['vehicleType']) && !empty($_POST['numberOfSets']) && !empty($_POST['comnSrcPlace'])
      &&!empty($_POST['comnDestPlace']) && !empty($_POST['travelAgencyDetails']) && !empty($_POST['driverDetails']) && !empty($_POST['cleanerDetails'])){

       $vehicleId = $database->escape_value(trim($_POST['vehicleId']));
       $vehiclePlanteNo = $database->escape_value(trim($_POST['vehiclePlanteNo']));
       $vehicleType = $database->escape_value(trim($_POST['vehicleType']));
       $numberOfSets = $database->escape_value(trim($_POST['numberOfSets']));
       $comnSrcPlace = $database->escape_value(trim($_POST['comnSrcPlace']));
       $comnDestPlace = $database->escape_value(trim($_POST['comnDestPlace']));
       $travelAgencyDetails = $database->escape_value(trim($_POST['travelAgencyDetails']));
       $driverDetails = $database->escape_value(trim($_POST['driverDetails']));
       $cleanerDetails = $database->escape_value(trim($_POST['cleanerDetails']));
       $ownerId = $database->escape_value(trim($_POST['ownerId']));

     $q = "SELECT vehiclePlanteNo FROM vehicle WHERE vehicleId = '{$vehicleId}' LIMIT 1";
     $result = $database->query($q);
     $result = mysqli_fetch_array($result);
     $vehicleOldPlateNo = $result['vehiclePlanteNo'];

     $registeredPlateNumber = $database->countOf("vehicle","vehiclePlanteNo like '%$vehiclePlanteNo'");

     if($vehicleOldPlateNo !== $vehiclePlanteNo && $registeredPlateNumber > 0 ){
       $fileOK = 0;
       $_SESSION['msg'] = "The plate number '{$vehiclePlanteNo}' is already registered. Please use different plate number!";
       $_SESSION['type'] = "error";
       // get the original name of the file on client machine
      }else{
        // check if the input field is not empty
         if(!empty($_FILES['vehicleImg']['name'])){// check if the logo image is not empty

           $vehicleImg = $_FILES['vehicleImg']['name'];
           // Allow certain file formats
           $allowTypes = array('jpg','png','jpeg','gif');

           // get the file name from the full path
           $vehicleImgName = basename($vehicleImg);

           // the file target path to store
           $vehicleImgFilePath = $target_path.$vehicleImgName;

           // get the file extension
           $file1Type = strtolower(pathinfo($vehicleImgFilePath,PATHINFO_EXTENSION));

           // check for valid extension
           if(in_array($file1Type,$allowTypes)){

               // get the size of the file
               $fileSize1 = $_FILES["vehicleImg"]["size"];
               // check size of the file
               if($fileSize1 < 5248880){

                     $fileOK = 1;
                     // get the temporary filename of th file in which the uploaded file was stored on the server
                     $temp_path1 = $_FILES["vehicleImg"]["tmp_name"];

                     if(move_uploaded_file($temp_path1, $vehicleImgFilePath)){
                       $query = "UPDATE vehicle SET vehiclePlanteNo = '{$vehiclePlanteNo}', vehicleType = '{$vehicleType}', numberOfSets = '{$numberOfSets}',comnSrcPlace='{$comnSrcPlace}', comnDestPlace = '{$comnDestPlace}',vehicleImg = '{$vehicleImg}',travelAgencyDetails = '{$travelAgencyDetails}',driverDetails = '{$driverDetails}',cleanerDetails='{$cleanerDetails}', ownerId = '{$ownerId}' WHERE vehicleId = '{$vehicleId}' LIMIT 1";
                       // success, store name and logo in database
                         if($database->query($query)){// if query was successfull then, delete the previous logo
                           // delete old image if exist
                           // TODo: in future
                           $_SESSION['type'] = 'success';
                           $_SESSION['msg'] = 'The vehicle details have been successfully saved';
                           $logMsg = "The vehicle {$vehicleId} details has been updated by operator {$_SESSION['adminId']}";

                         }else{
                           $_SESSION['type'] = 'error';
                           $_SESSION['msg'] = 'Sorry, there is error saving the vehicle details. <br />Please try again.';
                           $logMsg = "The vehicle {$vehicleId} details update by operator {$_SESSION['adminId']} failed";
                         }
                     }else{
                       $fileOK = 0;
                       $_SESSION['type'] = 'error';
                       $_SESSION['msg'] = 'Sorry, the file couldn\'t be saved in sepcefied directory. <br />Please check the file path. ';
                       $logMsg = "The vehicle {$vehicleId}  update by operator {$_SESSION['adminId']} failed due to invalid path or directory";
                       }
                   }else{
                     $_SESSION['type'] = 'error';
                     $_SESSION['msg'] = 'The vehilce image is too large!!!';
                     $fileOK = 0;
                     $logMsg = "The vehicle {$vehicleId} update by operator {$_SESSION['adminId']} failed due to large vehicle image";
                   }
             }else{
               $_SESSION['type'] = 'error';
               $_SESSION['msg'] = 'Unsupported file type. <br /> Only png, jpeg, jpg and gif iamge types are supported!!!';
               $fileOK = 0;
               $logMsg = "The vehicle {$vehicleId} update by operator {$_SESSION['adminId']} failed due to invalid vehicle image type";
             }
         }else{
           $query = "UPDATE vehicle SET vehiclePlanteNo = '{$vehiclePlanteNo}', vehicleType = '{$vehicleType}', numberOfSets = '{$numberOfSets}', comnSrcPlace = '{$comnSrcPlace}', comnDestPlace = '{$comnDestPlace}', travelAgencyDetails = '{$travelAgencyDetails}', driverDetails = '{$driverDetails}', cleanerDetails = '{$cleanerDetails}',ownerId='{$ownerId}' WHERE vehicleId = '{$vehicleId}' LIMIT 1";
            if($database->query($query)) {
              $_SESSION['type'] = 'success';
              $_SESSION['msg'] = 'The vehicle details have been successfully saved';
            }else{
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Sorry, there was error while updating the vehicle details!!!';
              $fileOK = 0;
            }
           }
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
   VALUES('{$_SESSION["adminId"]}','Operator','Vehicle update','{$logMsg}')";
   $database->query($sql);
 }
  ?>
    <?php // Check if the ID is set in the URL and then populate it in the form
      if(isset($_GET['id'])) {
        // Query the database to get the value for the provided ID
        $q = 'SELECT * FROM vehicle WHERE vehicleId='.$_GET['id'].' LIMIT 1';
        $r = $database->query($q);
        $vehicle = $database->fetch_array($r);

        // Store the data retrived from the database into variables
        $vehiclePlanteNo = $vehicle['vehiclePlanteNo'];
        $vehicleType = $vehicle['vehicleType'];
        $numberOfSets = $vehicle['numberOfSets'];
        $comnSrcPlace = $vehicle['comnSrcPlace'];
        $comnDestPlace = $vehicle['comnDestPlace'];
        $vehicleImg = $vehicle['vehicleImg'];
        $travelAgencyDetails = $vehicle['travelAgencyDetails'];
        $driverDetails = $vehicle['driverDetails'];
        $cleanerDetails = $vehicle['cleanerDetails'];
        $ownerId = $vehicle['ownerId'];
      }
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Agency Management</title>
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

               <h4>Vehicle Management </h4>
               <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

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
          <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-car"></i> </span>
          </div>
          <input name="vehiclePlanteNo" id="vehiclePlanteNo" required="required" class="form-control" placeholder="Vehicle plater number" type="text" value="<?php if(isset($vehiclePlanteNo)) echo $vehiclePlanteNo; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- /.form-group -->
          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fas fa-user-alt"></i> </span>
           </div>
            <select class="form-control select2bs4" name="ownerId">
              <option selected="selected"><?php echo isset($ownerId)? $ownerId : "Owner Id and Name"; ?></option>
              <?php
                $agencyOrOwners = "SELECT ownerId, ownerFullName FROM vehicleowner";
                $agencyOrOwnersResult = $database->query($agencyOrOwners);
                while($owner = $database->fetch_array($agencyOrOwnersResult)){
               ?>
              <option><?php if(isset($owner['ownerId']) && isset($owner['ownerFullName'])) echo $owner['ownerId'].' | '.$owner['ownerFullName']; ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="form-group input-group">
            <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Vehicle Type</span> -->
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fas fa-bus-alt"></i> </span>
           </div>
           <select class="form-control" name="vehicleType">
             <option selected="selected"><?php echo isset($vehicleType)? $vehicleType : "Vehicle Type"; ?></option>
             <option>Corola</option>
             <option>Saraycha</option>
             <option>Tunnes</option>
              <option>Bus 480</option>
              <option>Bus 404</option>
              <option>Bus 303</option>
           </select>
       </div> <!-- form-group end.// -->

       <div class="form-group input-group">
           <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Number of sets</span> -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-chair"></i> </span>
          </div>
          <select class="form-control" name="numberOfSets">
            <option selected="selected"><?php echo isset($numberOfSets)? $numberOfSets : "Number of sets"; ?></option>
            <option>5</option>
            <option>10</option>
            <option>16</option>
             <option>50</option>
             <option>64</option>
             <option>80</option>
          </select>
      </div> <!-- form-group end.// -->

      <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Commmon Source Place</span> -->
         <div class="input-group-prepend">
           <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
         </div>
         <select class="form-control" name="comnSrcPlace">
          <option selected="selected"><?php echo isset($comnSrcPlace)? $comnSrcPlace : "Common source place"; ?></option>
           <option>Kabul</option>
           <option>Mazar</option>
           <option>Laghman</option>
            <option>Parwan</option>
            <option>Takhar</option>
            <option>Qandhar</option>
         </select>
     </div> <!-- form-group end.// -->

     <div class="form-group input-group">
         <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Commmon Destination Place</span> -->
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fas fa-location-arrow"></i> </span>
        </div>
        <select class="form-control" name="comnDestPlace">
          <option selected="selected"><?php echo isset($comnDestPlace)? $comnDestPlace : "Common destination place"; ?></option>
          <option>Kabul</option>
          <option>Mazar</option>
          <option>Laghman</option>
           <option>Parwan</option>
           <option>Takhar</option>
           <option>Qandhar</option>
        </select>
    </div> <!-- form-group end.// -->

    <div class="form-group input-group">
      <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Owner tazkira Error</span> -->
      <div class="card" style="background-color:#ccc;">
        <div class="card-body text-center">
          <img id="vehicleImg" src="data/vehicleimgs/<?php if(isset($vehicleImg)) echo $vehicleImg; ?>" width="250" height="180"/>
          <div class="custom-file">
            <input name="vehicleImg" id="vehicleImg" type="file" class="custom-file-input" id="customFile" onchange="readURL(this);">
            <label class="custom-file-label" for="customFile"><?php if(isset($vehicleImg)) echo $vehicleImg; ?></label>
          </div>
        </div>
      </div>
    </div>

      <div class="form-group input-group">
        <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Travel Agency Details Error</span> -->
        <!-- First name -->
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-building"></i> </span>
       </div>
        <input name="travelAgencyDetails" id="travelAgencyDetails" required="required" class="form-control" placeholder="Travel Agency Details" type="text" value="<?php if(isset($travelAgencyDetails)) echo $travelAgencyDetails; ?>">
      </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="mobile_err_msg">Driver Details Error</span> -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user-circle"></i> </span>
          </div>
          <input name="driverDetails" id="driverDetails" required="required" class="form-control" placeholder="Drive Details" type="text" value="<?php if(isset($driverDetails)) echo $driverDetails; ?>">
        </div> <!-- form-group// -->


        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user-circle"></i> </span>
          </div>
          <input name="cleanerDetails" id="cleanerDetails" required="required" class="form-control" placeholder="Cleaner Details" type="text" value="<?php if(isset($cleanerDetails)) echo $cleanerDetails; ?>">
        </div> <!-- form-group// -->


      <?php
        if(isset($_GET['update']) && $_GET['update'] === 'true'){
          echo '
              <div class="text-center">
                <!-- /.col -->
                <div class="text-center">
                  <input name="vehicleId" type="hidden" value="'.$_GET['id'].'">
                  <button type="submit" name="update" id="updateAgency" class="btn btn-success btn-block update">Update Agency</button>
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
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped" style="font-size:.8em;">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Vehicle Plate Number</th>
                    <th>Vehicle Type</th>
                    <th>Vehicle Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                      $getAllVehicles = $database->query("SELECT * FROM vehicle");
                      while($vehicle = $database->fetch_array($getAllVehicles)) { ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $vehicle['vehiclePlanteNo']; ?></td>
                          <td><?php echo $vehicle['vehicleType']; ?></td>
                          <td class="text-center"><img src="data/vehicleimgs/<?php if(isset($vehicle['vehicleImg'])) echo $vehicle['vehicleImg']; ?>" alt="Vehicle Image" width="120" height="80" /></td>

                          <td>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=false&id='.$vehicle['vehicleId']; ?>" class="text-primary"><i class="fas fa-eye"></i></a>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=true&id='.$vehicle['vehicleId']; ?>" class="text-warning"><i class="fas fa-edit"></i></a>
                            <a href="" id="<?php echo $vehicle['vehicleId']; ?>" onClick="deleteRecord(this.id,'inc/vehicle_delete.php','Deleted')" class="text-danger"><i class="fas fa-trash"></i> </a>
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
// live display image after input
  function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#vehicleImg')
                      .attr('src', e.target.result)
                      .width(250)
                      .height(180);
              };

              reader.readAsDataURL(input.files[0]);
          }
      }
  </script>
</body>
</html>
