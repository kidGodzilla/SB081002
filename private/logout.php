<?
//myLogout.php
//Clears session data, forwards user to myLogin1.php upon successful logout
//Works with myLogin1.php, myValLogin.php, index.php & myLogged.php

session_start();
header("Cache-control: private"); // IE 6 Fix.

// destroy session data
$_SESSION = array();

// This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
}

session_destroy();

myRedirect("index.php?msg=1"); //redirect for successful logout

function myRedirect($myURL)
{ //passes user to relative URL
 header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . "/" . $myURL);
}
?>
