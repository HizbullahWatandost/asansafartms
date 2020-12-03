<?php
if(isset($_POST['forgotPassword'])){
  if(!empty($_POST['recoveryEmail'])){

    $recoveryEmail = $database->escape_value(trim($_POST['recoveryEmail']));
    // fetching client details
    $sql = "SELECT * FROM client WHERE clientEmail = '{$recoveryEmail}' LIMIT 1";
    $result = $database->query($sql);
    $result = mysqli_fetch_array($result);
    $usedEmail = $database->countOf("client","clientEmail like '%$recoveryEmail'");
    if($usedEmail == 1){
      // generating unique random reset code
     $passwordResetUniqueCode = md5(rand(999, 99999));
     $unisize = substr(md5(uniqid(rand(),1)),3,10);
     $passwordResetUniqueCode = $passwordResetUniqueCode . $unisize;
     // updating the passwordResetCode column in client table
     $sql = "UPDATE client SET passwordResetCode= '{$passwordResetUniqueCode}' WHERE clientEmail = '{$recoveryEmail}'";
     if($database->query($sql)){
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
          $mail->Port = 587;                                    // TCP port to connect to

          $mail->setFrom('asansafar2020@gmail.com', 'AsanSafar Admin');
          $mail->addAddress($recoveryEmail, $result["clientFullName"]);     // Add a recipient
          $mail->addAddress('asansafar2020@gmail.com');               // Name is optional
          $mail->addReplyTo('asansafar2020@gmail.com', 'Information');
          //$mail->addCC('cc@example.com');
          //$mail->addBCC('bcc@example.com');

          //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
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
                                    </a> AsanSafar Password Reset Link
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style='width:100% !important;padding:2em 1.3em;background-color:#ebf0e7;border:3px solid #cbd8c0;'>
                        <tbody>
                            <tr>
                                <td style='text-align:left;width:40%;' height='40' colspan='2'>
                                    <br /><br />
                                    Hello ".$result['clientFullName'].",
                                    <br /><br />
                                </td>
                            </tr>
                              <tr>
                                <td style='text-align:left;width:40%;' height='40' colspan='2'>
                                    Recently a request has been submitted to reset the password for your account!
                                </td>
                            </tr>
                              <tr>
                                <td style='text-align:left;width:40%;' height='40' colspan='2'>
                                    In case it was done by mistake or initiated by someone else , then ignore this email and nothing will happen.
                                </td>
                            </tr>
                             <tr>
                                <td style='text-align:left;width:40%;' height='40' colspan='2'>
                                    If the request is submitted by you, then click on link below to reset your password.
                                    <br /><br />
                                </td>
                            </tr>
                              <tr>
                                <td style='text-align:left;width:40%;' height='40' colspan='2'>
                                    <a href='http://localhost/tms/reset_password.php?passResetCode=".$passwordResetUniqueCode."&uid=".$result['clientId']."'><strong>Click here to reset your password</strong></a>
                                    <br /><br /><br />
                                    Thank you,
                                    <br />
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
              $_SESSION['emailCheckMsg'] = "Password reset link could not be sent to client-> "+$mail->ErrorInfo;
              $_SESSION['type'] = 'error';
          } else {
              $_SESSION['emailCheckMsg'] = "The password reset link successfully sent to your email, please check your inbox or spam folder";
              $_SESSION['type'] = 'success';
          }
   }
  }else{
    $_SESSION['emailCheckMsg'] = "The email '{$recoveryEmail}' is not registered with us, please use a valid email";
    $_SESSION['type'] = 'error';
  }
}
}
if(isset($_SESSION['emailCheckMsg'] )){
  if($_SESSION['type'] === 'success'){
      $_SESSION['emailCheckMsg']  = '<script>bootbox.alert({message: "'.$_SESSION['emailCheckMsg'].'"});</script>';
  }else{
      $_SESSION['emailCheckMsg']  = '<script>bootbox.alert({title:"Invalid recovery email",message: "'.$_SESSION['emailCheckMsg'].'"});</script>';
  }
}
 ?>
