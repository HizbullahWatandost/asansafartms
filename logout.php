<?php
  session_start();
  /* This section will clear the session specified int the login script
     remove all session variables */
  session_unset();
  // destroy the session
  session_destroy();

  // After the sessions has been cleared and the user is not available in the cache
  // user will be redirected to the home page
  //redirect_to('index.php');
  header ("location: index.php?msg=You%20have%20been%20successfully%20logged%20out!&type=information");
  exist();
 ?>
