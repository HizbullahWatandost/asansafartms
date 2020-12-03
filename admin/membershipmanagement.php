<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php

if(isset($_POST['contractForm'])){

  if(!empty($_POST['agentId']) && !empty($_POST['agentFullName']) && !empty($_POST['address'])
     && !empty($_POST['noOfVehicles']) && !empty($_POST['vehicleDescription']) && !empty($_POST['membershipFee']) && !empty($_POST['paidAmount'])
     && !empty($_POST['remainingAmount'])){
       $agentId = $database->escape_value(trim($_POST['agentId']));
       $agentFullName = $database->escape_value(trim($_POST['agentFullName']));
       $address = $database->escape_value(trim($_POST['address']));
       $noOfVehicles = $database->escape_value(trim($_POST['noOfVehicles']));
       $vehicleDescription = $database->escape_value(trim($_POST['vehicleDescription']));
       $membershipFee = $database->escape_value(trim($_POST['membershipFee']));
       $paidAmount = $database->escape_value(trim($_POST['paidAmount']));
       $remainingAmount = $database->escape_value(trim($_POST['remainingAmount']));

       $_SESSION['agentId'] = $agentId;
       $_SESSION['agentFullName'] = $agentFullName;
       $_SESSION['address'] = $address;
       $_SESSION['membershipDate'] = date("Y/m/d");
       $_SESSION['noOfVehicles'] = $noOfVehicles;
       $_SESSION['vehicleDescription'] = $vehicleDescription;
       $_SESSION['membershipFee'] = $membershipFee;
       $_SESSION['paidAmount'] = $paidAmount;
       $_SESSION['remainingAmount'] = $remainingAmount;
       header("Location: membership_contract_form.php");

     }else{
       $_SESSION['msg'] = "Please fill the required filleds";
       $_SESSION['type'] = "error";
     }
}

$target_path = 'data/contract_forms/';
$fileOK = 1;
$logMsg = "";
 if(isset($_POST['update'])){

   $membershipId = $database->escape_value(trim($_POST['membershipId']));
   $agentId = $database->escape_value(trim($_POST['agentId']));
   $agentFullName = $database->escape_value(trim($_POST['agentFullName']));
   $address = $database->escape_value(trim($_POST['address']));
   $noOfVehicles = $database->escape_value(trim($_POST['noOfVehicles']));
   $vehicleDescription = $database->escape_value(trim($_POST['vehicleDescription']));
   $membershipFee = $database->escape_value(trim($_POST['membershipFee']));
   $paidAmount = $database->escape_value(trim($_POST['paidAmount']));
   $remainingAmount = $database->escape_value(trim($_POST['remainingAmount']));

   if(!empty($agentId) && !empty($agentFullName) && !empty($address)
      && !empty($noOfVehicles) && !empty($vehicleDescription) && !empty($membershipFee) && !empty($paidAmount)
      && !empty($remainingAmount)){

     $q = "SELECT agencyId FROM membership WHERE agencyId = '{$agentId}' LIMIT 1";
     $result = $database->query($q);
     $result = mysqli_fetch_array($result);
     $agencyOldId = $result['agencyId'];

     $usedAgencyId = $database->countOf("membership","agencyId like '%$agentId'");
     if($agencyOldId !== $agentId && $usedAgencyId > 0 ){
       $fileOK = 0;
       $_SESSION['msg'] = "The Agency Id '{$agentId}' is already used. Please use different email!";
       $_SESSION['type'] = "error";
       // get the original name of the file on client machine
      }else{
        // check if the input field is not empty
         if(!empty($_FILES['contractFormUpload']['name'])){// check if the logo image is not empty

           $contractFileName = $_FILES['contractFormUpload']['name'];
           // Allow certain file formats
           $allowTypes = array('jpg','png','jpeg','doc','docx','pdf');

           // get the file name from the full path
           $contractFileNameName = basename($contractFileName);

           // the file target path to store
           $contractFileNameFilePath = $target_path.$contractFileNameName;

           // get the file extension
           $file1Type = strtolower(pathinfo($contractFileNameFilePath,PATHINFO_EXTENSION));
           // check for valid extension
           if(in_array($file1Type,$allowTypes)){

               // get the size of the file
               $fileSize1 = $_FILES["contractFormUpload"]["size"];

               // check size of the file
               if($fileSize1 < 5248880){

                     $fileOK = 1;
                     // get the temporary filename of th file in which the uploaded file was stored on the server
                     $temp_path1 = $_FILES["contractFormUpload"]["tmp_name"];


                     if(move_uploaded_file($temp_path1, $contractFileNameFilePath)){
                       // success, store name and logo in database

                       $query = "UPDATE membership SET agencyId = '{$agentId}', agentFullName = '{$agentFullName}',agencyAddress='{$address}',totalNoOfVehicles = '{$noOfVehicles}', vehiclesDescription = '{$vehicleDescription}',membershipFee = '{$membershipFee}',paidAmount='{$paidAmount}',remainingAmount='{$remainingAmount}',contractFileName ='{$contractFileName}' WHERE membershipId = '{$membershipId}' LIMIT 1";
                         // $query = "UPDATE websitenamelogo SET websiteName = '{$name}', websiteLogo ='{$imgName}' LIMIT 1";
                         if($database->query($query)){// if query was successfull then, delete the previous logo
                           // delete old image if exist
                           // TODo: in future
                           $_SESSION['type'] = 'success';
                           $_SESSION['msg'] = 'The membership details have been successfully saved';
                           $logMsg = "The membership details {$membershipId} has been updated by the operator {$_SESSION['adminId']}";

                         }else{
                           $_SESSION['type'] = 'error';
                           $_SESSION['msg'] = 'Sorry, there is error saving the agency details. <br />Please try again.';
                           $logMsg = "The membership details {$membershipId} updated by the operator {$_SESSION['adminId']} failed";

                         }
                     }else{
                       $fileOK = 0;
                       $_SESSION['type'] = 'error';
                       $_SESSION['msg'] = 'Sorry, the file couldn\'t be saved in sepcefied directory. <br />Please check the file path. ';
                       $logMsg = "The membership details {$membershipId} updated by the operator {$_SESSION['adminId']} failed due to invalid path";

                       }
                   }else{
                     $_SESSION['type'] = 'error';
                     $_SESSION['msg'] = 'The file is too large!!!';
                     $fileOK = 0;
                     $logMsg = "The membership details {$membershipId} updated by the operator {$_SESSION['adminId']} failed due large size of contract form";

                   }
             }else{
               $_SESSION['type'] = 'error';
               $_SESSION['msg'] = 'Unsupported file type. <br /> Only png, jpeg, jpg, pdf, doc, docx and pdo file types are supported!!!';
               $fileOK = 0;
               $logMsg = "The membership details {$membershipId} updated by the operator {$_SESSION['adminId']} failed due to invalid contract form format";

             }
         }else{

           $query = "UPDATE membership SET agencyId = '{$agentId}', agentFullName = '{$agentFullName}',agencyAddress='{$address}',totalNoOfVehicles = '{$noOfVehicles}', vehiclesDescription = '{$vehicleDescription}',membershipFee = '{$membershipFee}',paidAmount='{$paidAmount}',remainingAmount='{$remainingAmount}' WHERE membershipId = '{$membershipId}' LIMIT 1";

            if($database->query($query)) {
              $_SESSION['type'] = 'success';
              $_SESSION['msg'] = 'The agency details have been successfully saved';
            }else{
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Sorry, there was error while updating the agency details!!!';
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
   VALUES('{$_SESSION["adminId"]}','Operator','Membership update','{$logMsg}')";
   $database->query($sql);
 }
  ?>
    <?php // Check if the ID is set in the URL and then populate it in the form
      if(isset($_GET['id'])) {
        // Query the database to get the value for the provided ID
        $q = 'SELECT * FROM membership WHERE membershipId='.$_GET['id'].' LIMIT 1';
        $r = $database->query($q);
        $membership = $database->fetch_array($r);

        // Store the data retrived from the database into variables
        $membershipId=$membership['membershipId'];
        $agentId=$membership['agencyId'];
        $agentFullName=$membership['agentFullName'];
        $address=$membership['agencyAddress'];
        $noOfVehicles=$membership['totalNoOfVehicles'];
        $vehicleDescription=$membership['vehiclesDescription'];
        $membershipFee=$membership['membershipFee'];
        $paidAmount=$membership['paidAmount'];
        $remainingAmount=$membership['remainingAmount'];
        $contractForm = $membership['contractFileName'];
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

               <h4>Membership Management </h4>
               <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
     <div class="card card-primary card-outline">
       <div class="card-body box-profile">
         <div class="text-center">
           <img class="profile-user-img img-circle"
                src="imgs/default/contract_icon.png"
                alt="User profile picture" width="50" height="100">
         </div>
         <p class="text-muted text-center">Asan Safar Membership</p>

         <form <?php if(isset($_GET['id'])) { ?> action="<?php echo $_SERVER['PHP_SELF']; ?>?update=true&id=<?php echo $_GET['id']; ?>" <?php } ?>
        action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" enctype="multipart/form-data">
        <div class="form-group input-group">
          <!-- /.form-group -->
          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fas fa-user-alt"></i> </span>
           </div>
            <select class="form-control select2bs4" name="agentId">
              <option selected="selected"><?php echo isset($agentId)? $agentId : "Select Agent ID"; ?></option>
              <?php
                $queryAgent = "SELECT ownerId FROM vehicleowner";
                $agentIds = $database->query($queryAgent);
                while($agent = $database->fetch_array($agentIds)){
               ?>
              <option><?php if(isset($agent['ownerId'])) echo $agent['ownerId']; ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user-circle"></i> </span>
          </div>
          <input name="agentFullName" id="agentFullName" required="required" class="form-control" placeholder="Agent Full Name" type="text" value="<?php if(isset($agentFullName)) echo $agentFullName; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Write the address of the agency" required="required"><?php if(isset($address)) echo $address; ?></textarea>
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- /.form-group -->
          <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fas fa-bus-alt"></i> </span>
           </div>
            <select class="form-control select2bs4" name="noOfVehicles">
              <option selected="selected"><?php echo isset($noOfVehicles)? $noOfVehicles : "Select total number of vehicles"; ?></option>
              <?php
                for($i = 1; $i<=50; $i++){
                  echo '<option>'.$i.'</option>';
                }
               ?>
            </select>
        </div>

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
        <textarea name="vehicleDescription" id="vehicleDescription" class="form-control" rows="3" placeholder="Write the description of the vehicle i.e. type, plate number etc..." required="required"><?php if(isset($vehicleDescription)) echo $vehicleDescription; ?></textarea>
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
          </div>
          <input name="membershipFee" id="membershipFee" required="required" class="form-control" placeholder="Enter membership fee" type="text" value="<?php if(isset($membershipFee)) echo $membershipFee; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
          </div>
          <input name="paidAmount" id="paidAmount" required="required" class="form-control" placeholder="Enter the paid amount" type="text" value="<?php if(isset($paidAmount)) echo $paidAmount; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
          </div>
          <input name="remainingAmount" id="remainingAmount" required="required" class="form-control" placeholder="Enter the remaining amount" type="text" value="<?php if(isset($remainingAmount)) echo $remainingAmount; ?>">
        </div> <!-- form-group// -->

        <div class="form-group text-center">
          <!-- /.col -->
          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-sm" name="contractForm"><i class="fas fa-print"> </i> Print Contract Form</button>
            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          </div>
        </div>

        <div class="form-group input-group">
          <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
          <div class="custom-file">
            <input name="contractFormUpload" type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile"><?php if(isset($contractForm)) echo $contractForm; ?></label>
          </div>
        </div>

        <!-- /.col -->

      <?php
        if(isset($_GET['update']) && $_GET['update'] === 'true'){
          echo '
              <div class="text-center">
                <!-- /.col -->
                <div class="text-center">
                  <input name="membershipId" type="hidden" value="'.$_GET['id'].'">
                  <button type="submit" name="update" id="updateMembership" class="btn btn-success btn-block update">Update Agency</button>
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
   </div>

     <!-- /.card -->

          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped" style="font-size:.8em;">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Agent ID</th>
                    <th>Agent Name</th>
                    <th>Membership Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                      $getAllMembers = $database->query("SELECT * FROM membership");
                      while($member = $database->fetch_array($getAllMembers)) { ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $member['agencyId']; ?></td>
                          <td><?php echo $member['agentFullName']; ?></td>
                          <td><?php echo $member['membershipDate']; ?></td>

                          <td>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=false&id='.$member['membershipId']; ?>" class="text-primary"><i class="fas fa-eye"></i></a>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=true&id='.$member['membershipId']; ?>" class="text-warning"><i class="fas fa-edit"></i></a>
                            <a href="" id="<?php echo $member['membershipId']; ?>" onClick="deleteRecord(this.id,'inc/membership_delete.php','Deleted')" class="text-danger"><i class="fas fa-trash"></i> </a>
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
</body>
</html>
