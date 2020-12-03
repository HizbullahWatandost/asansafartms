<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php
$logMsg = "";
$target_path = 'data/files/';
$fileOK = 1;

 if(isset($_POST['update'])){

   if(!empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['guarantorDetails'])){// check if the websitet name is not  empty

     $ownerId = $database->escape_value(trim($_POST['ownerId']));
     $fullName = $database->escape_value(trim($_POST['fullName']));
     $email = $database->escape_value(trim($_POST['email']));
     $mobile = $database->escape_value(trim($_POST['mobile']));
     $guarantorDetails = $database->escape_value(trim($_POST['guarantorDetails']));

     $q = "SELECT ownerEmail FROM vehicleowner WHERE ownerId = '{$ownerId}' LIMIT 1";
     $result = $database->query($q);
     $result = mysqli_fetch_array($result);
     $agencyOldEmail = $result['ownerEmail'];

     $usedEmail = $database->countOf("vehicleowner","ownerEmail like '%$email'");
     if($agencyOldEmail !== $email && $usedEmail > 0 ){
       $fileOK = 0;
       $_SESSION['msg'] = "The email '{$email}' is already used. Please use different email!";
       $_SESSION['type'] = "error";
       // get the original name of the file on client machine
      }else{
        // get the original name of the file on client machine
        $ownerTazkira = $_FILES['ownerTazkira']['name'];
        $guarantorTazkira = $_FILES['guarantorTazkira']['name'];
        // check if the input field is not empty
         if(!empty($ownerTazkira) && !empty($guarantorTazkira)){// check if the logo image is not empty
           // Allow certain file formats
           $allowTypes = array('jpg','png','jpeg','doc','docx','pdf');

           // get the file name from the full path
           $ownerTazkiraName = basename($ownerTazkira);
           $guarantorTazkiraName = basename($guarantorTazkira);

           // the file target path to store
           $ownerTazkiraFilePath = $target_path.$ownerTazkiraName;
           $guarantorTazkiraFilePath = $target_path.$guarantorTazkiraName;

           // get the file extension
           $file1Type = strtolower(pathinfo($ownerTazkiraFilePath,PATHINFO_EXTENSION));
           $file2Type = strtolower(pathinfo($guarantorTazkiraFilePath,PATHINFO_EXTENSION));

           // check for valid extension
           if(in_array($file1Type,$allowTypes) && in_array($file2Type,$allowTypes)){

               // get the size of the file
               $fileSize1 = $_FILES["ownerTazkira"]["size"];
               $fileSize2 = $_FILES["guarantorTazkira"]["size"];
               // check size of the file
               if($fileSize1 < 5248880 && $fileSize2 < 5248880){

                     $fileOK = 1;
                     // get the temporary filename of th file in which the uploaded file was stored on the server
                     $temp_path1 = $_FILES["ownerTazkira"]["tmp_name"];
                     $temp_path2 = $_FILES["guarantorTazkira"]["tmp_name"];

                     if(move_uploaded_file($temp_path1, $ownerTazkiraFilePath) && move_uploaded_file($temp_path2, $guarantorTazkiraFilePath)){
                       // success, store name and logo in database
                       $query = "UPDATE vehicleowner SET ownerFullName = '{$fullName}', ownerEmail = '{$email}', ownertMobile = '{$mobile}', onwerTazkira = '{$ownerTazkiraName}', gurantorDetails = '{$guarantorDetails}',gurantorTazkira = '{$guarantorTazkiraName}' WHERE ownerId = '{$ownerId}' LIMIT 1";
                         // $query = "UPDATE websitenamelogo SET websiteName = '{$name}', websiteLogo ='{$imgName}' LIMIT 1";
                         if($database->query($query)){// if query was successfull then, delete the previous logo
                           // delete old image if exist
                           // TODo: in future
                           $_SESSION['type'] = 'success';
                           $_SESSION['msg'] = 'The agency details have been successfully saved';
                           $logMsg = "The agency {$ownerId} has been updated by operator {$_SESSION['adminId']}";

                         }else{
                           $_SESSION['type'] = 'error';
                           $_SESSION['msg'] = 'Sorry, there is error saving the agency details. <br />Please try again.';
                           $logMsg = "The agency {$ownerId} update by operator {$_SESSION['adminId']} failed";
                         }
                     }else{
                       $fileOK = 0;
                       $_SESSION['type'] = 'error';
                       $_SESSION['msg'] = 'Sorry, the file couldn\'t be saved in sepcefied directory. <br />Please check the file path. ';
                       $logMsg = "The agency {$ownerId} update failed by {$_SESSION['adminId']} due to invalid file path";
                       }
                   }else{
                     $_SESSION['type'] = 'error';
                     $_SESSION['msg'] = 'The file is too large!!!';
                     $fileOK = 0;
                     $logMsg = "The agency {$ownerId} update failed by {$_SESSION['adminId']} due to large file";
                   }
             }else{
               $_SESSION['type'] = 'error';
               $_SESSION['msg'] = 'Unsupported file type. <br /> Only png, jpeg, jpg, pdf, doc, docx and pdo file types are supported!!!';
               $fileOK = 0;
                $logMsg = "The agency {$ownerId} update failed by {$_SESSION['adminId']} due to invalid file type";
             }
         }else{//
           $query = "UPDATE vehicleowner SET ownerFullName = '{$fullName}', ownerEmail = '{$email}', ownertMobile = '{$mobile}', gurantorDetails = '{$guarantorDetails}' WHERE ownerId = '{$ownerId}' LIMIT 1";
            if($database->query($query)) {
              $_SESSION['type'] = 'success';
              $_SESSION['msg'] = 'The agency details have been successfully saved';
              $logMsg = "The agency {$ownerId} details has been successfully updated by {$_SESSION['adminId']}";
            }else{
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Sorry, there was error while updating the agency details!!!';
              $fileOK = 0;
              $logMsg = "The agency {$ownerId} details update failed";
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

  ?>
    <?php // Check if the ID is set in the URL and then populate it in the form
      if(isset($_GET['id'])) {
        // Query the database to get the value for the provided ID
        $q = 'SELECT * FROM vehicleowner WHERE ownerId='.$_GET['id'].' LIMIT 1';
        $r = $database->query($q);
        $agency = $database->fetch_array($r);

        // Store the data retrived from the database into variables
        $agencyFullName = $agency['ownerFullName'];
        $agencyEmail = $agency['ownerEmail'];
        $agencyMobile = $agency['ownertMobile'];
        $agencyTazkira = $agency['onwerTazkira'];
        $gurantorDetails = $agency['gurantorDetails'];
        $gurantorTazkira = $agency['gurantorTazkira'];
      }

      if(isset($logMsg) && !empty($logMsg)){
        $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
        VALUES('{$_SESSION["adminId"]}','Operator','Agency update','{$logMsg}')";
        $database->query($sql);
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

               <h4>Agency Management </h4>
               <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
     <div class="card card-primary card-outline">
       <div class="card-body box-profile">
         <div class="text-center">
           <img class="profile-user-img img-circle"
                src="imgs/default/user_login_icon.png"
                alt="User profile picture" width="50" height="100">
         </div>
         <p class="text-muted text-center">Asan Safar Agency</p>

         <form <?php if(isset($_GET['id'])) { ?> action="<?php echo $_SERVER['PHP_SELF']; ?>?update=true&id=<?php echo $_GET['id']; ?>" <?php } ?>
        action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" enctype="multipart/form-data">
        <div class="form-group input-group">
          <span class="frm-validation-err-tooltip" id="fullname_err_msg">Full Name Error</span>
          <!-- First name -->
          <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-user"></i> </span>
          </div>
          <input name="fullName" id="full-name" required="required" class="form-control" placeholder="Full name" type="text" value="<?php if(isset($agencyFullName)) echo $agencyFullName; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <span class="frm-validation-err-tooltip" id="email_err_msg">Email Error</span>
          <!-- First name -->
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
         </div>
          <input name="email" id="email" required="required" class="form-control" placeholder="Email address" type="email" value="<?php if(isset($agencyEmail)) echo $agencyEmail; ?>">
        </div> <!-- form-group// -->

        <div class="form-group input-group">
          <span class="frm-validation-err-tooltip" id="mobile_err_msg">Mobile Error</span>
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
          </div>
          <select class="custom-select" style="max-width: 80px;">
              <option selected="">+93</option>
          </select>
          <input name="mobile" id="mobile" required="required" class="form-control" placeholder="Phone number" type="text" value="<?php if(isset($agencyMobile)) echo $agencyMobile; ?>">
        </div> <!-- form-group// -->

       <div class="form-group input-group">
         <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Owner tazkira Error</span> -->
         <div class="custom-file">
           <input name="ownerTazkira" type="file" class="custom-file-input" id="customFile">
           <label class="custom-file-label" for="customFile"><?php if(isset($agencyTazkira)) echo $agencyTazkira; ?></label>
         </div>
       </div>

       <div class="form-group input-group">
         <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
         <!-- First name -->
         <div class="input-group-prepend">
           <span class="input-group-text"> <i class="fa fa-user-circle"></i> </span>
         </div>
         <input name="guarantorDetails" id="guarantorDetails" required="required" class="form-control" placeholder="Guarantor details" type="text" value="<?php if(isset($gurantorDetails)) echo $gurantorDetails; ?>">
       </div> <!-- form-group// -->

       <div class="form-group input-group">
         <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->
         <div class="custom-file">
           <input name="guarantorTazkira" type="file" class="custom-file-input" id="customFile">
           <label class="custom-file-label" for="customFile"><?php if(isset($gurantorTazkira)) echo $gurantorTazkira; ?></label>
         </div>
       </div>

      <?php
        if(isset($_GET['update']) && $_GET['update'] === 'true'){
          echo '
              <div class="text-center">
                <!-- /.col -->
                <div class="text-center">
                  <input name="ownerId" type="hidden" value="'.$_GET['id'].'">
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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1;
                      $getAllAgencies = $database->query("SELECT * FROM vehicleowner");
                      while($agency = $database->fetch_array($getAllAgencies)) { ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $agency['ownerFullName']; ?></td>
                          <td><?php echo $agency['ownerEmail']; ?></td>
                          <td><?php echo $agency['ownertMobile']; ?></td>

                          <td>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=false&id='.$agency['ownerId']; ?>" class="text-primary"><i class="fas fa-eye"></i></a>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?><?php echo '?update=true&id='.$agency['ownerId']; ?>" class="text-warning"><i class="fas fa-edit"></i></a>
                            <a href="" id="<?php echo $agency['ownerId']; ?>" onClick="deleteRecord(this.id,'inc/agency_delete.php','Deleted')" class="text-danger"><i class="fas fa-trash"></i> </a>
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
