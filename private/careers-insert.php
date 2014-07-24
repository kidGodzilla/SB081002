<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/index.php');
  exit;
  }
if (array_key_exists('insert', $_POST)) {
  include('includes/connect.php');
  include('includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // prepare an array of expected items
  $expected = array('title', 'location', 'qualification_01', 'qualification_02', 'qualification_03', 'qualification_04', 'qualification_05', 'qualification_06', 'qualification_07', 'qualification_08', 'qualification_09', 'qualification_10', 'mailto', 'description');
  // create database connection
  $conn = dbConnect('admin');
  // make $_POST data safe for insertion into database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // prepare the SQL query
  $sql = "INSERT INTO sb_careers ( title, location, description, qualification_01, qualification_02, qualification_03, qualification_04, qualification_05, qualification_06, qualification_07, qualification_08, qualification_09, qualification_10, mailto, created)
          VALUES('$title', '$location', '$description', '$qualification_01', '$qualification_02', '$qualification_03', '$qualification_04', '$qualification_05', '$qualification_06', '$qualification_07', '$qualification_08', '$qualification_09', '$qualification_10', '$mailto', NOW())";
  // process the query
  $result = mysql_query($sql) or die(mysql_error());
  // if successful, redirect to list of existing records
  if ($result) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/careers-list.php');
    exit;
    }
  }
 
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Career Entry</h1>
<?php
// if the "upload image" button has been submitted, display result
if (isset($result)) {
  echo "<p><strong>$result</strong></p>";
  }
?>
<form id="theform" name="theform" method="post" enctype="multipart/form-data" action="" >
    <p><label for="title">Title:</label><br /><input id="title" name="title" type="text" size="25" /></p>
    <p><label for="location">Location:</label><br /><input id="location" name="location" type="text" size="25" /></p>
	<p><label for="description">Description:</label><br /><textarea id="description" name="description" cols="40" rows="10"></textarea></p>
    
    	<?php
        for($i=1;$i<=10;$i++){
            $num = sprintf("%02d",$i);
            echo '<p><label for="qualification_'.$num.'">Qualification '.$num.':</label><br /><textarea id="qualification_'.$num.'" name="qualification_'.$num.'" cols="40" rows="5"></textarea></p>';
        }
    ?>
    <p><label for="mailto">Mail To:</label><br /><input id="mailto" name="mailto" type="text" size="25" />@hiredesk.net</p>

    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>
</form>
<!-- END INSERT FORM -->


<?php include ('includes/footer-private.php'); ?>