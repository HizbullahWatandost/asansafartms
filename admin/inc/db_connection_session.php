<?php
  // to resolve back reload form submission error in chrome
  //header('Cache-Control: no cache'); //no cache
  //session_cache_limiter('private_no_expire'); // works
  //session_cache_limiter('public'); // works too
  session_start();
  define('DEBUG',true);
  error_reporting(E_ALL);
  ini_set('display_errors',DEBUG ? 'on': 'off');
  date_default_timezone_set('Asia/Kabul');
  require_once("initialize.php");
 ?>
