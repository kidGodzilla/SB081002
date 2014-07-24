<?php
session_start();
header("Cache-control: private"); // IE 6 Fix.
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  session_destroy();
  myRedirect('index.php');
  exit;
}
  
function myRedirect($myURL)
{ //passes user to relative URL
 header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . "/" . $myURL);
}
?>