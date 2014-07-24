<?php
// start the session
session_start();
include('includes/corefuncs.php');
include('includes/connect.php');

// process the script only if the form has been submitted
if (array_key_exists('login', $_POST)) {
  
  // clean the $_POST array and assign to shorter variables
  nukeMagicQuotes();
  // connect to the database as a restricted user
  $conn = dbConnect('query');
  // prepare username for use in SQL query
  $username = mysql_real_escape_string(trim($_POST['username']));
  $pwd = trim($_POST['pwd']);
  // get the username's details from the database
  $sql = "SELECT * FROM sb_users WHERE username = '$username'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  // use the salt to encrypt the password entered in the form
  // and compare it with the stored version of the password
  // if they match, set the authenticated session variable 
  if (sha1($pwd.$row['salt']) == $row['pwd']) {
	$_SESSION['sticket'] = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
	$_SESSION['suser_id'] = $row['user_id'];
	$_SESSION['suser_type'] = $row['user_type'];
	$_SESSION['susername'] = $row['username'];
	$_SESSION['sfirstname'] = $row['firstname'];
	$_SESSION['slastname'] = $row['lastname'];
	$_SESSION['semail'] = $row['email'];
    $_SESSION['spwd'] = $row['pwd'];
	$_SESSION['ssalt'] = $row['salt'];
  }
  // if no match, destroy the session and prepare error message
  else {
    $_SESSION = array();
	session_destroy();
	$error = 'Invalid username or password';
	}
  // if the session variable has been set, redirect
  if (isset($_SESSION['suser_id'])) {
	// get the time the session started
	$_SESSION['sstart'] = time();
	header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/products-list.php');
	exit;
	}
  }
?>

<?php include ('includes/header-private.php'); ?>

<?php
if (isset($error)) {
  echo '<h1>Login</h1>';
  echo "<p>$error</p>";
  echo '<form id="form1" name="form1" method="post" action="">
			<p><label for="username">Username:</label><br /><input type="text" name="username" id="username" /></p>
			<p><label for="textfield">Password:</label><br /><input type="password" name="pwd" id="pwd" /></p>
			<p><input name="login" type="submit" id="login" value="Log in" /></p>
		</form>';
} elseif (isset($_GET['expired'])) {
?>
  <p>Your session has expired. Please log in again.</p>
<?php 
}elseif(isset($_SESSION['suser_id'])) {
	echo '<p>Welcome back <b>'.$_SESSION['sfirstname'].'</b>! Choose where to go in the links above.</p>';

}else{
?>
<!-- BEGIN INSERT FORM -->
<h1>Login</h1>
<form id="form1" name="form1" method="post" action="">
    <p><label for="username">Username:</label><br /><input type="text" name="username" id="username" /></p>
    <p><label for="textfield">Password:</label><br /><input type="password" name="pwd" id="pwd" /></p>
    <p><input name="login" type="submit" id="login" value="Log in" /></p>
</form>
<!-- END INSERT FORM -->

<?php 
}

include ('includes/footer-private.php'); 

?>