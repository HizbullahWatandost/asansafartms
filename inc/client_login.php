<?php
  if(isset($_POST['login'])){
    $username = trim($_POST['userName']);
    $password = trim($_POST['loginPass']);

    // check the database to see if the username / password exist
    $found_user = Client::authenticate($username, $password);
    if($found_user){
      // store the user data into a session for later use
      $_SESSION['login'] = 'true';
      $_SESSION['username'] = $found_user->clientEmail;
      $_SESSION['loginStatus'] = 'success';
      $_SESSION['loginMsg'] = "You have successfully logged in AsanSafar";
      // do your staff and conditon here
    }else{
      // It means the user name or password is incorrect
      $_SESSION['loginStatus'] = 'error';
      $_SESSION['loginMsg'] = "Sorry, login to AsanSafar failed, please try again";
    }
  }else{
    // form has not been submitted
    // clear the form
    $username = "";
    $password = "";
    // It means the user name or password is incorrect
    $_SESSION['loginStatus'] = "";
    $_SESSION['loginMsg'] = "";
  }

  if(isset($_SESSION['loginStatus']) && isset($_SESSION['loginMsg'])){
    if($_SESSION['loginStatus'] === 'success'){
        $_SESSION['loginMsg'] = '<script>bootbox.alert({message: "'.$_SESSION['loginMsg'].'"});</script>';
    }else{
        $_SESSION['loginMsg'] = '<script>bootbox.alert({title:"Invalid username and password",message: "'.$_SESSION['loginMsg'].'"});</script>';
    }
  }
 ?>
