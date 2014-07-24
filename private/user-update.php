<?php
include('includes/session.php');
include('includes/corefuncs.php');
include('includes/connect.php');
nukeMagicQuotes(); 
// connect to database as administrator
$conn = dbConnect('admin');
// execute script only if form has been submitted
if (array_key_exists('update', $_POST)) {
  
  // check length of username and password
  $user_id = mysql_real_escape_string(trim($_POST['user_id']));
  $firstname = mysql_real_escape_string(trim($_POST['firstname']));
  $lastname = mysql_real_escape_string(trim($_POST['lastname']));
  $username = mysql_real_escape_string(trim($_POST['username']));
  $email = mysql_real_escape_string(trim($_POST['email']));
  $pwd = trim($_POST['pass']);
  // initialize error array
  $message = array();
  if ($_SESSION['suser_id']!=$user_id && $_SESSION['suser_type']!=1) {
    $message[] = 'You do not have authority to edit this account';
  }
  // check length of username
  if (strlen($username) < 5 || strlen($username) > 15) {
    $message[] = 'Username must be between 5 and 15 characters';
	}
  // validate username
  if (!ctype_alnum($username)) {
    $message[] = 'Username must consist of alphanumeric characters with no spaces';
	}
  // check password
  if ($pwd!="" && (strlen($pwd) < 6 || preg_match('/\s/', $pwd))) {
    $message[] = 'Password must be at least 6 characters with no spaces';
	}
  // check that the passwords match
  if ($pwd != $_POST['conf_pwd']) {
    $message[] = 'Your passwords don\'t match';
	}
  // if no errors so far, check the username
  if (!$message) {
  	  if($pwd!="") {	
		  // create a salt using the current timestamp
		  $salt = time();
		  // encrypt the password and salt with SHA1
		  $pwd = sha1($pwd.$salt);
	  	  $pwdSql = ", salt='$salt', pwd='$pwd'";
	  }else{
	      $pwdSql = '';
	  }
	  // insert details into database
	  $sql = "UPDATE sb_users SET firstname='$firstname', lastname='$lastname', email='$email', username='$username'$pwdSql
	             WHERE user_id='$user_id'";
	  $result = mysql_query($sql) or die(mysql_error());
	  if ($result) {
	    $message[] = "Account #$user_id modified for $username";
			if($email!="") {
				if($_POST['pass']!="") {
					$creds = "Your password has been changed. You can login on <a href=\"http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."\">http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."</a> with the following credentials: <br /><br />user: $username<br />pass: ".strip_tags($_POST['pass']);
				}else{
					$creds = "Your password has not changed.";
				}
				mailTo("admin@".$_SERVER['SERVER_NAME'],$email,'Slam Brands Account Updated',"Hello $firstname $lastname,<br /><br />Your account with the username of <b>$username</b> has been updated on SlamBrands.<br />".$creds,0);
				$message[] = $email." has been notified of the change.";
			}
		}
	  else {
	    $message[] = "There was a problem modifying account #$user_id for $username";
		}
	  }
  }
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>Update User</h1>
<?php

if (isset($message)) {
  foreach ($message as $item) {
    echo "<p>$item</p>";
	}
  }

if($_SESSION['suser_type']==1 && isset($_GET['user_id'])) { // admin, changing another user
	$user_id = mysql_real_escape_string($_GET['user_id']);
}else{
	$user_id = $_SESSION['suser_id'];
}
$sql = "SELECT * FROM sb_users WHERE user_id = '$user_id'";
$res = mysql_query($sql);
$r = mysql_fetch_assoc($res);

$user_id = $r['user_id'];
$username = $r['username'];
$firstname = $r['firstname'];
$lastname = $r['lastname'];
$email = $r['email'];
?>
<form id="form1" name="form1" method="post" action="">
	<input value="<?php echo $user_id; ?>" type="hidden" name="user_id" id="user_id" />
    <p><label for="firstname">First Name:</label><br /><input value="<?php echo $firstname; ?>" type="text" name="firstname" id="firstname" /></p>
    <p><label for="lastname">Last Name:</label><br /><input value="<?php echo $lastname; ?>" type="text" name="lastname" id="lastname" /></p>
    <p><label for="email">Email:</label><br /><input value="<?php echo $email; ?>" type="text" name="email" id="email" /></p>
    <p><label for="username">Username:</label><br /><input value="<?php echo $username; ?>" type="text" name="username" id="username" /></p>
    
    <p><label for="pass">Password:</label><br /><input value="" type="password" name="pass" id="pass" /></p>
    <p><label for="conf_pwd">Confirm Password:</label><br /><input value="" type="password" name="conf_pwd" id="conf_pwd" /></p>
    <p><input name="update" type="submit" id="update" value="Update" /></p>
</form>
<!-- END INSERT FORM -->

<?php include ('includes/footer-private.php'); 


?>