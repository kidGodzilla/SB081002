<?php
include('includes/session.php');
include('includes/corefuncs.php');
include('includes/connect.php');
nukeMagicQuotes();
// connect to database as administrator
$conn = dbConnect('admin');

// execute script only if form has been submitted
if (array_key_exists('register', $_POST)) {
  
  // check length of username and password
  $username = trim($_POST['username']);
  $firstname = trim($_POST['firstname']);
  $lastname = trim($_POST['lastname']);
  $email = trim($_POST['email']);
  $pwd = trim($_POST['pwd']);
  // initialize error array
  $message = array();
  // check length of username
  if (strlen($username) < 5 || strlen($username) > 15) {
    $message[] = 'Username must be between 5 and 15 characters';
	}
  // validate username
  if (!ctype_alnum($username)) {
    $message[] = 'Username must consist of alphanumeric characters with no spaces';
	}
  // check password
  if (strlen($pwd) < 6 || preg_match('/\s/', $pwd)) {
    $message[] = 'Password must be at least 6 characters with no spaces';
	}
  // check that the passwords match
  if ($pwd != $_POST['conf_pwd']) {
    $message[] = 'Your passwords don\'t match';
	}
  // if no errors so far, check for duplicate username
  if (!$message) {
	// check for duplicate username
    $checkDuplicate = "SELECT user_id FROM sb_users
	                   WHERE username = '$username'";
	$result = mysql_query($checkDuplicate) or die(mysql_error());
	$numRows = mysql_num_rows($result);
	// if $numRows is positive, the username is already in use
	if ($numRows) {
	  $message[] = "$username is already in use. Please choose another username.";
	  }
	// otherwise, it's OK to insert the details in the database
	else {
	  // create a salt using the current timestamp
	  $salt = time();
	  // encrypt the password and salt with SHA1
	  $pwd = sha1($pwd.$salt);
	  // insert details into database
	  $insert = "INSERT INTO sb_users (firstname, lastname, username, email, salt, pwd)
	             VALUES ('$firstname', '$lastname', '$username', '$email', $salt, '$pwd')";
	  $result = mysql_query($insert) or die(mysql_error());
	  if ($result) {
		$message[] = "Account created for $username";
		mailTo("admin@".$_SERVER['SERVER_NAME'],$email,'Slam Brands Account Created',"Hello $firstname $lastname,<br /><br />Your account has been created on SlamBrands.<br />You can login on <a href=\"http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."\">http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."</a> with the following credentials: <br /><br />user: $username<br />pass: ".$_POST['pwd'],0);
		$message[] = $email." has been notified of the change.";
	  }
	  else {
	    $message[] = "There was a problem creating an account for $username";
	  }
	}
  }
}
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>Register User</h1>
<?php
if (isset($message)) {
  foreach ($message as $item) {
    echo "<p>$item</p>";
	}
  }
?>
<form id="form1" name="form1" method="post" action="">
    <p><label for="firstname">First Name:</label><br /><input value="<?php echo $_POST['firstname']; ?>" type="text" name="firstname" id="firstname" /></p>
    <p><label for="lastname">Last Name:</label><br /><input value="<?php echo $_POST['lastname']; ?>" type="text" name="lastname" id="lastname" /></p>
    <p><label for="email">Email:</label><br /><input value="<?php echo $_POST['email']; ?>" type="text" name="email" id="email" /></p>
    <p><label for="username">Username:</label><br /><input value="<?php echo $_POST['username']; ?>" type="text" name="username" id="username" /></p>
    <p><label for="pwd">Password:</label><br /><input type="password" name="pwd" id="pwd" /></p>
    <p><label for="conf_pwd">Confirm Password:</label><br /><input type="password" name="conf_pwd" id="conf_pwd" /></p>
    <p><input name="register" type="submit" id="register" value="Register" /></p>
</form>
<!-- END INSERT FORM -->

<?php include ('includes/footer-private.php'); ?>