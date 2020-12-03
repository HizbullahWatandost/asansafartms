<?php include ('inc/db_connection_session.php'); ?>
<?php
if(!isset($_SESSION['adminId'])){
  redirect_to('login.php');
}
?>
<!-- retrevining website name and logo from database -->
<?php
$logMsg = "";
  $weblogo = "SELECT * FROM websitenamelogo LIMIT 1";
  $result = $database->query($weblogo);
  $result = mysqli_fetch_object($result);
  $webSiteName = $result->websiteName;
  $websiteLogo = $result->websiteLogo;
 ?>
 <?php
 // website logo and name update
 $target_path = 'imgs/logo/';
 $fileOK = 1;
 if(isset($_POST['update'])){
   $name = $database->escape_value(trim($_POST['websiteName']));
   if(!empty($name)){// check if the websitet name is not  empty
      if(!empty($_FILES['logo']['name'])){// check if the logo image is not empty
        $file = $_FILES['logo'];
        $temp_path = $file['tmp_name'];
        $imgName = basename($file['name']);
        $targetFile = $target_path.$imgName;
        $type = $file['type'];
        $size = $file['size'];
        // check if the file is an actual image or not
        $check = getimagesize($_FILES['logo']['tmp_name']);
        if($check !== false){
          // check size of the file
          if($_FILES['logo']['size'] < 5248880){
            // allow certain file formats
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
            if($imageFileType === "jpg" || $imageFileType === "png" || $imageFileType ==="jpeg" || $imageFileType ==="gif"){
                // determine the target path in which you store the image
                // atempt to move the file
                $fileOK = 1;
                if(move_uploaded_file($temp_path, $targetFile)){
                  // success, store name and logo in database
                  $query = "UPDATE websitenamelogo SET websiteName = '{$name}', websiteLogo ='{$imgName}' LIMIT 1";
                  if($database->query($query)){// if query was successfull then, delete the previous logo
                    // delete old image if exist
                    // TODo: in future
                    $_SESSION['type'] = 'success';
                    $_SESSION['msg'] = 'The website name and logo has been successfully update';
                    $logMsg = "The website name and logo has been changed successfully by admin with ID ".$_SESSION['adminId'];

                  }else{
                    $_SESSION['type'] = 'error';
                    $_SESSION['msg'] = 'Sorry, there is an error updating the logo. <br />Please try again.';
                    $logMsg = "There is error in changing website name and logo by admin with ID ".$_SESSION['adminId'];
                  }
                }
            }else{
              $fileOK = 0;
              $_SESSION['type'] = 'error';
              $_SESSION['msg'] = 'Only png, jpg, jpeg and gif image types are supported for log ';
              $logMsg = "There is error in changing website name and logo, only png, jpg and jpeg images are allowed as logo by admin with ID ".$_SESSION['adminId'];
            }
          }else{
            $_SESSION['type'] = 'error';
            $_SESSION['msg'] = 'The file is too large, it might not be an image!!!';
            $fileOK = 0;
            $logMsg = "The file can not be a logo, it is too large - tried by admin with ID ".$_SESSION['adminId'];
          }
        }else{
          $_SESSION['type'] = 'error';
          $_SESSION['msg'] = 'The file is not an image!!!';
          $fileOK = 0;
          $logMsg = "The file is not an image, please select an image as logo - tried by admin with ID ".$_SESSION['adminId'];
        }

      }else{//
        $query = "UPDATE websitenamelogo SET websiteName = '{$name}' LIMIT 1";
        if($database->query($query)){// if query was successfull then, delete the previous logo
          $_SESSION['type'] = 'success';
          $_SESSION['msg'] = 'The website name has been successfully updated';
          $logMsg = "The website name has been successfully updated by admin with ID ".$_SESSION['adminId'];
        }
      }
   }else{
     $_SESSION['type'] = 'error';
     $_SESSION['msg'] = 'Please enter a name for the website';
   }

 }else{
   $_SESSION['type'] = '';
   $_SESSION['msg'] = '';
 }

 if(isset($logMsg) && !empty($logMsg) && isset($_SESSION["adminId"])){
   $sql = "INSERT INTO logging(userName, userType,activityType,logMsg)
   VALUES('{$_SESSION["adminId"]}','Admin','Changing website name and logo','{$logMsg}')";
   $database->query($sql);
 }

  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Asan Safar  | Website Name and Logo</title>
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
            if(@$_SESSION['type'] === 'error' && $fileOK == 0) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo $_SESSION['msg']; ?>
              </div>
           <?php
           $_SESSION['msg'] = $_SESSION['type'] = '';
            } // End of error if condition

            // Check if type is success then display the success message
            if(@$_SESSION['type'] === 'success' && $fileOK == 1) { ?>
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

      <h4>Website Name and Logo </h4>
      <hr />
      <div class="container-fluid">
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                  <div class="active tab-pane">
                    <div class="tab-pane">
                      <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Website Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="websiteName" class="form-control" id="inputName" placeholder="Enter website name" value="<?php echo $webSiteName; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="websiteLogo" class="col-sm-2 col-form-label">Webiste Logo</label>
                            <div class="offset-sm-3 col-sm-4">
                              <div class="card" style="background-color:#ccc;">
                                <div class="card-body text-center">
                                  <img id = "logo" src="imgs/<?php echo isset($websiteLogo) ? 'logo/'.$websiteLogo: 'asan_safar.png'; ?>" alt="Asan Safar Logo" with="200" height="200"/>
                                  <div class="custom-file">
                                    <input name="logo" id="logo" type="file" class="custom-file-input" id="customFile" onchange="readURL(this);">
                                    <label class="custom-file-label" for="customFile">Choose your logo</label>
                                  </div>
                                </div>
                              </div>
                              <input type="submit" name="update" class="btn btn-block btn-success" />
                          </div>
                        </div>
                      </form>
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
  // live display image after input
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
