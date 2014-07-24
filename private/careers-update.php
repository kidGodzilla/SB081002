<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('title', 'location', 'description', 'career_id');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if ($_GET && !$_POST) {
  if (isset($_GET['career_id']) && is_numeric($_GET['career_id'])) {
    $career_id = $_GET['career_id'];
	}
  else {
    $career_id = NULL;
	}
  if ($career_id) {
    $sql = "SELECT * FROM sb_careers WHERE career_id = $career_id";
  $result = mysql_query($sql) or die (mysql_error());
  $row = mysql_fetch_assoc($result);
	}
  }
// if form has been submitted, update record
if (array_key_exists('update', $_POST)) {
  // prepare expected items for insertion in to database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // abandon the process if primary key invalid
  if (!is_numeric($career_id)) {
    die('Invalid request');
	}
  // prepare the SQL query
  $sql = "UPDATE sb_careers SET title = '$title', location = '$location', description = '$description', qualification_01 = '$qualification_01', qualification_02 = '$qualification_02', qualification_03 = '$qualification_03', qualification_04 = '$qualification_04', qualification_05 = '$qualification_05', qualification_06 = '$qualification_06', qualification_07 = '$qualification_07', qualification_08 = '$qualification_08', qualification_09 = '$qualification_09', qualification_10 = '$qualification_10', mailto = '$mailto'
  WHERE career_id = $career_id";
  // submit the query and redirect if successful
  $done = mysql_query($sql) or die(mysql_error());
  }
// redirect page on success or if $article_id is invalid
if ($done || !isset($career_id)) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/careers-list.php');
  exit;
  }
?>

<?php include ('includes/header-private.php'); ?>


<!-- BEGIN UPDATE FORM -->
<h1>Update Career Entry</h1>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<form id="theform" name="theform" method="post" action="" >
	<p><label for="title">Title:</label><br /><input id="title" name="title" type="text" size="25" value="<?php echo htmlentities($row['title']); ?>" /></p>
    <p><label for="location">Location:</label><br /><input id="location" name="location" type="text" size="25" value="<?php echo htmlentities($row['location']); ?>" /></p>
	<p><label for="description">Description:</label><br /><textarea id="description" name="description" cols="40" rows="10"><?php echo htmlentities($row['description']); ?></textarea></p>
    
    
	<?php
        for($i=1;$i<=10;$i++){
            $num = sprintf("%02d",$i);
            echo '<p><label for="qualification_'.$num.'">Qualification '.$num.':</label><br /><textarea id="qualification_'.$num.'" name="qualification_'.$num.'" cols="40" rows="5">'.htmlentities($row['qualification_'.$num]).'</textarea></p>';
        }
    ?>
    <p><label for="mailto">Mail To:</label><br /><input id="mailto" name="mailto" type="text" size="25" value="<?php echo htmlentities($row['mailto']); ?>" />@hiredesk.net</p>
    <p><input type="submit" name="update" value="Update Entry" /></p>
	<p><input name="career_id" type="hidden" value="<?php echo $row['career_id']; ?>" /></p>
</form>
<?php } ?>
<!-- END UPDATE FORM -->

<?php include ('includes/footer-private.php'); ?>