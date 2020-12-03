<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php
$logMsg = "";
if(isset($_POST['contractForm'])){
  if(!empty($_POST['agentId']) && !empty($_POST['agentFullName']) && !empty($_POST['membershipDate']) && !empty($_POST['address'])
     && !empty($_POST['noOfVehicles']) && !empty($_POST['vehicleDescription']) && !empty($_POST['membershipFee']) && !empty($_POST['paidAmount'])
     && !empty($_POST['remainingAmount'])){
       $agentId = $database->escape_value(trim($_POST['agentId']));
       $agentFullName = $database->escape_value(trim($_POST['agentFullName']));
       $membershipDate = $database->escape_value(trim($_POST['membershipDate']));
       $address = $database->escape_value(trim($_POST['address']));
       $noOfVehicles = $database->escape_value(trim($_POST['noOfVehicles']));
       $vehicleDescription = $database->escape_value(trim($_POST['vehicleDescription']));
       $membershipFee = $database->escape_value(trim($_POST['membershipFee']));
       $paidAmount = $database->escape_value(trim($_POST['paidAmount']));
       $remainingAmount = $database->escape_value(trim($_POST['remainingAmount']));

       $_SESSION['agentId'] = $agentId;
       $_SESSION['agentFullName'] = $agentFullName;
       $_SESSION['membershipDate'] = $membershipDate;
       $_SESSION['address'] = $address;
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

if(isset($_POST['register'])){

  $agentId = $database->escape_value(trim($_POST['agentId']));
  $agentFullName = $database->escape_value(trim($_POST['agentFullName']));
  $membershipDate = $database->escape_value(trim($_POST['membershipDate']));
  $address = $database->escape_value(trim($_POST['address']));
  $noOfVehicles = $database->escape_value(trim($_POST['noOfVehicles']));
  $vehicleDescription = $database->escape_value(trim($_POST['vehicleDescription']));
  $membershipFee = $database->escape_value(trim($_POST['membershipFee']));
  $paidAmount = $database->escape_value(trim($_POST['paidAmount']));
  $remainingAmount = $database->escape_value(trim($_POST['remainingAmount']));

  if(!empty($agentId) && !empty($agentFullName) && !empty($membershipDate) && !empty($address)
     && !empty($noOfVehicles) && !empty($vehicleDescription) && !empty($membershipFee) && !empty($paidAmount)
     && !empty($remainingAmount)){
       $membershipCheck = $database->countOf("membership","agencyId like '%$agentId'");
       if($membershipCheck == 0){
      // get the original name of the file on client machine
         $contractForm = $_FILES['contractFormUpload']['name'];
         // check if the input field is not empty
          if(!empty($contractForm)){
         // Allow certain file formats
         $allowTypes = array('jpg','png','jpeg','pdf','PDF','docx','doc');

         // get the file name from the full path
         $contractForm = basename($contractForm);
         // the file target path to store
         $contractFormFilePath = $target_path.$contractForm;

         // get the file extension
         $file1Type = strtolower(pathinfo($contractFormFilePath,PATHINFO_EXTENSION));

         // check for valid extension
         if(in_array($file1Type,$allowTypes)){

             // get the size of the file
             $fileSize1 = $_FILES["contractFormUpload"]["size"];
             // check size of the file
             if($fileSize1 < 5248880){

                   $fileOK = 1;
                   // get the temporary filename of th file in which the uploaded file was stored on the server
                   $temp_path1 = $_FILES["contractFormUpload"]["tmp_name"];

                   if(move_uploaded_file($temp_path1, $contractFormFilePath)){
                     $query = "INSERT INTO membership(agencyId, agentFullName, membershipDate, agencyAddress, totalNoOfVehicles, vehiclesDescription, membershipFee, paidAmount, remainingAmount,contractFileName) VALUES ('{$agentId}','{$agentFullName}','{$membershipDate}','{$address}','{$noOfVehicles}','{$vehicleDescription}','{$membershipFee}','{$paidAmount}','{$remainingAmount}','{$contractForm}')";
                       if($database->query($query)){
                         // delete old image if exist
                         // TODo: in future
                         $_SESSION['type'] = 'success';
                         $_SESSION['msg'] = 'The membership details have been successfully saved';
                         $logMsg = "The membership granted to the agency by operator {$_SESSION['adminId']}";

                       }else{
                         $_SESSION['type'] = 'error';
                         $_SESSION['msg'] = 'Sorry, there is error adding membership. <br />Please try again.';
                         $logMsg = "The membership grant to the agency by operator {$_SESSION['adminId']} failed";
                       }
                   }else{
                     $fileOK = 0;
                     $_SESSION['type'] = 'error';
                     $_SESSION['msg'] = 'Sorry, the file couldn\'t be saved in sepcefied directory. <br />Please check the file path. ';
                     $logMsg = "The membership grant to the agency by operator {$_SESSION['adminId']} failed due to invalid file path";
                     }
                 }else{
                   $_SESSION['type'] = 'error';
                   $_SESSION['msg'] = 'The file is too large!!!';
                   $fileOK = 0;
                   $logMsg = "The membership grant to the agency by operator {$_SESSION['adminId']} failed due to large size of contract form";

                 }
           }else{
             $_SESSION['type'] = 'error';
             $_SESSION['msg'] = 'Unsupported file type. <br /> Only png, jpeg, jpg and gif file types are supported!!!';
             $fileOK = 0;
             $logMsg = "The membership grant to the agency by operator {$_SESSION['adminId']} failed due to invalid file type";
           }
       }else{//
           $fileOK = 0;
           $_SESSION['type'] = 'error';
           $_SESSION['msg'] = 'Please upload the contract form';
         }
       }
         else{
           $fileOK = 0;
           $_SESSION['type'] = 'error';
           $_SESSION['msg'] = 'The membership is already issued for this agency!';
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
  VALUES('{$_SESSION["adminId"]}','Operator','Granting membership','{$logMsg}')";
  $database->query($sql);
}
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Issue Membership</title>
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

      <h4> Issue Membership </h4>
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
                          <img class="profile-user-img img-circle" src="imgs/default/contract_icon.png" alt="User profile picture" width="50" height="100">
                        </div>
                        <p class="text-muted text-center">Asan Safar | Issue Membershipt</p>
                        <form form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

                          <div class="form-group input-group">
                            <!-- /.form-group -->
                            <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                             <div class="input-group-prepend">
                               <span class="input-group-text"> <i class="fas fa-user-alt"></i> </span>
                             </div>
                              <select class="form-control select2bs4" name="agentId">
                                <option selected="selected" disabled="disabled">Select the agent ID</option>
                                <?php
                                  $queryAgent = "SELECT ownerId FROM vehicleowner";
                                  $ownerIds = $database->query($queryAgent);
                                  while($owner = $database->fetch_array($ownerIds)){
                                 ?>
                                <option><?php if(isset($owner['ownerId'])) echo $owner['ownerId']; ?></option>
                              <?php } ?>
                              </select>
                          </div>

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-user-circle"></i> </span>
                            </div>
                            <input name="agentFullName" id="agentFullName" required="required" class="form-control" placeholder="Agent Full Name" type="text">
                          </div> <!-- form-group// -->
                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="fullname_err_msg">Vehicle plate number Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fas fa-calendar-alt"></i> </span>
                            </div>
                            <input name="membershipDate" type="date" class="form-control" placeholder="Enter the membership date" aria-label="Membership date" aria-describedby="basic-addon2" required="required">
                          </div> <!-- form-group// -->
                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                          <textarea name="address" id="address" class="form-control" rows="3" placeholder="Write the address of the agency" required="required"></textarea>
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- /.form-group -->
                            <!-- <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Enter vehicle onwer ID</span> -->
                             <div class="input-group-prepend">
                               <span class="input-group-text"> <i class="fas fa-bus-alt"></i> </span>
                             </div>
                              <select class="form-control select2bs4" name="noOfVehicles">
                                <option selected="selected" disabled="disabled">Enter total number of behicles</option>
                                <?php
                                  for($i = 1; $i<=50; $i++){
                                    echo '<option>'.$i.'</option>';
                                  }
                                 ?>
                              </select>
                          </div>

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                          <textarea name="vehicleDescription" id="vehicleDescription" class="form-control" rows="3" placeholder="Write the description of the vehicle i.e. type, plate number etc..." required="required"></textarea>
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
                            </div>
                            <input name="membershipFee" id="membershipFee" required="required" class="form-control" placeholder="Enter membership fee" type="text">
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
                            </div>
                            <input name="paidAmount" id="paidAmount" required="required" class="form-control" placeholder="Enter the paid amount" type="text">
                          </div> <!-- form-group// -->

                          <div class="form-group input-group">
                            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                            <!-- First name -->
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-money-bill"></i> </span>
                            </div>
                            <input name="remainingAmount" id="remainingAmount" required="required" class="form-control" placeholder="Enter the remaining amount" type="text">
                          </div> <!-- form-group// -->

                          <div class="row">
                            <!-- /.col -->
                            <div class="col-sm-4">
                              <button type="submit" class="btn btn-primary btn-sm" name="contractForm"><i class="fas fa-print"> </i> Print Contract Form</button>
                              <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
                            </div>
                              <div class="custom-file col-sm-8">
                                <input name="contractFormUpload" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Upload the contract form</label>
                              </div>
                            </div>
                            <!-- /.col -->
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
</body>
</html>
