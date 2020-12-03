<?php include ('inc/db_connection_session.php');
  if(isset($_SESSION['ticketId'])){
    $ticketId = $_SESSION['ticketId'];
    $sql = "SELECT * FROM ticket WHERE ticketId = '{$ticketId}'";
    $result = $database->query($sql);
    $result = mysqli_fetch_array($result);
    $_SESSION['ticketId'] = $result['ticketId'];
    $_SESSION['srcPlace'] = $result['srcPlacce'];
    $_SESSION['destPlace'] = $result['destPlace'];
    $_SESSION['distance'] = $result['distance'];
    $_SESSION['departureDate'] = $result['departureDate'];
    $_SESSION['arrivalDate'] = $result['arrivalDate'];
    $_SESSION['departureTime'] = $result['departureTime'];
    $_SESSION['arrivalTime'] = $result['arrivalTime'];
    $_SESSION['vehicleId'] = $result['vehicleId'];
    $_SESSION['price'] = $result['price'];
    $_SESSION['setNo'] = $result['setNo'];
    $_SESSION['discount'] = $result['discount'];
    $_SESSION['vehicleType'] = $result['vehicleType'];
    $departureTime = $result["departureTime"];
    $hourSep = stripos($departureTime,":");

    $departureHour = substr($departureTime,0,$hourSep);
    $departureMinute = substr($departureTime,$hourSep+1,$hourSep+1);

    $arrivalTime = $result["arrivalTime"];
    $hourSep = stripos($arrivalTime,":");
    $arrivalHour = substr($arrivalTime,0,$hourSep);
    $arrivalMinute = substr($arrivalTime,$hourSep+1,$hourSep+1);

    $durationHours = (int) $arrivalHour - (int)$departureHour;
    $durationMinutes = (int)$arrivalMinute - (int)$departureMinute;
    $duration = $durationHours . ' H &  '.$durationMinutes.' M';

    $_SESSION['duration'] = $duration;

    $sql = "SELECT * FROM vehicle WHERE vehicleId = '{$result["vehicleId"]}'";
    $vehicleResult = $database->query($sql);
    $vehicleResult = mysqli_fetch_array($vehicleResult);
    $_SESSION['vehicleImg'] = $vehicleResult['vehicleImg'];
    $vehicleImg = $vehicleResult['vehicleImg'];

    $userEmail = $_SESSION['username'];
    $clientResult = "SELECT * FROM client WHERE clientEmail = '{$userEmail}' LIMIT 1";
    $clientResult = $database->query($clientResult);
    $clientResult = mysqli_fetch_array($clientResult);
    $_SESSION['clientFullName'] = $clientResult['clientFullName'];
    $_SESSION['clientMobile'] = $clientResult['clientMobile'];
    $_SESSION['clientEmail'] = $clientResult['clientEmail'];
    $_SESSION['bookingDate'] = date("d/m/Y");
    $_SESSION['bookingTime'] = date("h:i A");

    $bookingDate = date('Y/m/d h:i:s');
    $query = "UPDATE ticket SET status = 1, bookingDate = '{$bookingDate}',clientId = {$clientResult['clientId']} WHERE ticketId = {$ticketId} LIMIT 1";
    $database->query($query);
  }

  if(isset($_POST["printTicket"])){
    header("Location: asansafar_ticket.php");
  }
  if(isset($_POST['downlaodTicket'])){
    header("Location: downlaod_ticket.php");
  }
  if(isset($_POST['emailTicket'])){
        $clientEmail = $database->escape_value(trim($_SESSION['username']));
        if(isset($clientEmail)){
            // fetching client details
            $sql = "SELECT * FROM client WHERE clientEmail = '{$clientEmail}' LIMIT 1";
            $result = $database->query($sql);
            $result = mysqli_fetch_array($result);
            $usedEmail = $database->countOf("client","clientEmail like '%$clientEmail'");
            if($usedEmail == 1){
                header("Location: downlaod_ticket.php");

          }else{
            $_SESSION['ticketSentMsg'] = "The email '{$recoveryEmail}' is not registered with us, please use a valid email";
            $_SESSION['type'] = 'error';
          }
      }
}

if(isset($_POST['ticketSend'])){
  //Import PHPMailer classes into the global namespace
     require 'PHPMailer/PHPMailerAutoload.php';
     $mail = new PHPMailer;
     //$mail->SMTPDebug = 4;                               // Enable verbose debug output
     $mail->isSMTP();                                      // Set mailer to use SMTP
     $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
     $mail->SMTPAuth = true;                               // Enable SMTP authentication
     $mail->Username = 'asansafar2020@gmail.com';                 // SMTP username
     $mail->Password = 'asansafar12345';                           // SMTP password
     $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
     $mail->Port = 587;
                                        // TCP port to connect to
     $clientEmail = $database->escape_value(trim($_SESSION['username']));
     $clientFullName = $database->escape_value(trim($_SESSION['clientFullName']));
     $mail->setFrom('asansafar2020@gmail.com', 'AsanSafar Admin');
     $mail->addAddress($clientEmail, $clientFullName);     // Add a recipient
     //$mail->addAddress($_SESSION['username']);               // Name is optional
     $mail->addReplyTo('asansafar2020@gmail.com', 'Information');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');
     // get the original name of the file on client machine
     $filePath = $_FILES['ticket']['tmp_name'];
     $ticketFileName = $_FILES['ticket']['name'];
     //$ticket = "C://Users/".get_current_user()."/Downlaods/".basename($ticketFileName);
     $mail->addAttachment($filePath,$ticketFileName);         // Add attachments
     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
     $mail->isHTML(true);

     $mail->SMTPOptions = array(
       'ssl' => array(
       'verify_peer' => false,
       'verify_peer_name' => false,
       'allow_self_signed' => true
           )
       );                              // Set email format to HTML

     $mail->Subject = 'AsanSafar Password Reset';
     $mail->Body    ="
              <table style='width:100% !important;text-align:left;align:left;'>
                   <tbody>
                       <tr>
                           <td style='background-color:#cbd8c0;text-align:left;padding:1em 1.5em'>
                               <a href='http://localhost/tms/index.php' target='_blank'>
                                   <img src='http://localhost/tms/assets/images/logo/asan_safar.png' />
                               </a> You have successfully booked the ticket
                           </td>
                       </tr>
                   </tbody>
               </table>

               <table style='width:100% !important;padding:2em 1.3em;background-color:#ebf0e7;border:3px solid #cbd8c0;'>
                   <tbody>
                       <tr>
                           <td style='text-align:left;width:40%;' height='40' colspan='2'>
                               <br /><br />
                               Hello ".$clientFullName.",
                               <br /><br />
                           </td>
                       </tr>

                        <tr>
                           <td style='text-align:left;width:40%;' height='40' colspan='2'>
                               The ticket has been sent in your email as per your request.
                               <br /><br />
                           </td>
                       </tr>
                        <tr>
                           <td ed style='text-align:left;width:40%;' height='40' colspan='2'>

                               <strong>AsanSafar Transportaion Management System</strong>
                               <br />
                               <a href='http://localhost/tms/index.php' target='_blank'>
                                   www.asansafar.com
                               </a>
                               <br /><br />
                               <strong>-** This is automatically generated email, please do not reply! **-</strong>
                               <br />
                           </td>
                       </tr>
                   </tbody>
               </table>
               ";
     //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

     if(!$mail->send()) {
         $_SESSION['ticketSentMsg'] = "The ticket could not be sent to client-> "+$mail->ErrorInfo;
         $_SESSION['type'] = 'error';
     } else {
         $_SESSION['ticketSentMsg'] = "The ticket has been sent to your email successfully";
         $_SESSION['type'] = 'success';
     }
}
if(isset($_SESSION['ticketSentMsg'] )){
  if($_SESSION['type'] === 'success'){
      $_SESSION['ticketSentMsg']  = '<script>bootbox.alert({message: "'.$_SESSION['ticketSentMsg'].'"});</script>';
  }else{
      $_SESSION['ticketSentMsg']  = '<script>bootbox.alert({title:"Invalid recovery email",message: "'.$_SESSION['ticketSentMsg'].'"});</script>';
  }
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- style -->
  <?php include ('include/pagecomn_head.php'); ?>
  <!-- jquery scipt for auto search index -- product search -->
  <style>
  .ticketInfoContainer{
    border-left: .5em solid green;
  }
  </style>
  <title>AsanSafar - Booking Ticket</title>
</head>

<body>
    <main>
      <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" >
          <!-- Main content -->
          <section class="content" style="padding-top: .5em;">

            <h4 style="text-align:center;"> Ticket Details </h4>
            <hr />
            <div class="container-fluid">
              <div class="row">
                <div class="col-md">
                  <div class="card">
                    <div class="card-body">
                          <div class="card card-primary card-outline offset-sm-2 col-sm-8">
                            <div class="card-body box-profile">
                              <div class="text-center" style="background-color: #cccccc; margin: .5em;">
                                <img class="profile-user-img img-circle" src="assets/images/logo/asan_safar.png" alt="AsanSafar logo" width="150" height="100">
                              </div>
                                <div class="row" style="padding: .5em;">
                                  <div class="col-sm-4 ticketInfoContainer" style="display: flex;justify-content: center;align-items: center;">
                                    <img src="admin/data/vehicleimgs/<?php if(isset($vehicleImg)) echo $vehicleImg; ?>" width="200" height="150" alt="Vehicle Image" />
                                  </div>
                                  <!-- /.col -->
                                  <div class="ticketInfoContainer col-sm-4">
                                    <strong>Ticket Id: </strong> <?php if(isset($result['ticketId'])) echo $result['ticketId']; ?> <br />
                                    <strong>Source Place: </strong> <?php if(isset($result['srcPlacce'])) echo $result['srcPlacce']; ?> <br />
                                    <strong>Destination Place: </strong> <?php if(isset($result['destPlace'])) echo $result['destPlace']; ?> <br />
                                    <strong>Distance: </strong> <?php if(isset($result['distance'])) echo $result['distance']; ?> <br />
                                    <strong>Departure Date: </strong> <?php if(isset($result['departureDate'])) echo $result['departureDate']; ?> <br />
                                    <strong>Arrival Date: </strong> <?php if(isset($result['arrivalDate'])) echo $result['arrivalDate']; ?><br />
                                    <strong>Departure Time: </strong> <?php if(isset($result['departureTime'])) echo $result['departureTime']; ?> <br />
                                    <strong>Arrival Time: </strong>  <?php if(isset($result['arrivalTime'])) echo $result['arrivalTime']; ?><br />
                                    <strong>Duration: </strong> <?php if(isset($duration)) echo $duration; ?> <br />
                                  </div>
                                    <div class="ticketInfoContainer col-sm-4">
                                      <strong>Vehicle Type </strong> <?php if(isset($result['vehicleType'])) echo $result['vehicleType']; ?> <br />
                                      <strong>Set Number: </strong> <?php if(isset($result['setNo'])) echo $result['setNo']; ?> <br />
                                      <strong>Price </strong> <?php if(isset($result['price'])) echo $result['price']; ?> <br />
                                      <strong>Client Name: </strong> <?php if(isset($clientResult['clientFullName'])) echo $clientResult['clientFullName']; ?> <br />
                                      <strong>Client Mobile: </strong> <?php if(isset($clientResult['clientMobile'])) echo $clientResult['clientMobile']; ?> <br />
                                      <strong>Client Email: </strong> <?php if(isset($clientResult['clientEmail'])) echo $clientResult['clientEmail']; ?> <br />
                                      <strong>Booking Date: </strong> <?php echo (date("d/m/Y")); ?> <br />
                                      <strong>Booking Time: </strong> <?php echo (date("h:i A")); ?> <br />
                                    </div>
                                  </div>
                                  <!-- /.col -->
                              </div>
                              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                  <div style="text-align:center;padding-bottom: 1em;">
                                    <a type="button" class="btn btn-success btn-sm" name="downlaodTicket" href="index.php"><i class="fas fa-home"></i> Home Page </a>
                                    <button type="submit" class="btn btn-primary btn-sm" name="printTicket"> <i class="fas fa-print"></i> Print ticket</button>
                                    <button type="submit" class="btn btn-primary btn-sm" name="emailTicket" href="#" data-toggle="modal" data-target="#ticketToEmailModel"><i class="fas fa-envelope"></i> Send to my email </button>
                                    <button type="submit" class="btn btn-primary btn-sm" name="downlaodTicket"><i class="fas fa-save"></i> Download </button>
                                    <a type="button" class="btn btn-success btn-sm" name="downlaodTicket" href="index.php"><i class="fas fa-home"></i> Home Page </a>

                                  </div>

                                </form>
                          </div>
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

      <div class="modal fade" id="ticketToEmailModel" tabindex="-1" role="dialog" aria-labelledby="ticketToEmailModel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="card bg-light">
        <div class="modal-content borderstyle">
          <div class="modal-header bg-success text-white border-0">
            <h5 class="modal-title" id="editAccountModalLabel">Sending Email to your Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">

      <article class="card-body mx-auto" style="max-width: 400px;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group input-group">
            <!-- <span class="frm-validation-err-tooltip" id="email_err_msg">Guarantor Details Error</span> -->

              <input name="ticket" type="file">

            </div>
          </div> <!-- form-group// -->
          <div class="form-group">

              <button type="submit" name="ticketSend" class="btn btn-success btn-block"> Sent this ticket to my email  </button>
          </div> <!-- form-group// -->
      </form>
      </article>
      </div> <!-- card.// -->


              </div>
            </div>
          </div>
      </div>

  </main>
    <!-- scripts -->
    <?php include 'include/pagecomn_scripts.php'; ?>
    <!-- ticket search -->
    <script src="plugins/select2dropdown/js/select2.min.js"></script>
    <script src="plugins/select2dropdown/js/select2-custom.js"></script>
    <!-- quick ticket book slider -->
    <script src="plugins/owlcarousel/js/owl.carousel.js"></script>
    <script src="assets/js/quick-book-slider.js"></script>
    <script src="assets/js/script.js"></script>
    <?php
        if(isset($_SESSION['ticketSentMsg'])){
          echo $_SESSION['ticketSentMsg'];
          unset($_SESSION['ticketSentMsg']);
          unset($_SESSION['type']);
        }
      ?>
</body>
</html>
