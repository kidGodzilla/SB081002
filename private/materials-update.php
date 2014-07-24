<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('material_name', 'material_id');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if ($_GET && !$_POST) {
  if (isset($_GET['material_id']) && is_numeric($_GET['material_id'])) {
    $career_id = $_GET['material_id'];
	}
  else {
    $career_id = NULL;
	}
  if ($career_id) {
    $sql = "SELECT * FROM sb_materials WHERE material_id = $material_id";
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
  if (!is_numeric($material_id)) {
    die('Invalid request');
	}
  // prepare the SQL query
  $sql = "UPDATE sb_materials SET material_name = '$material_name'
  WHERE material_id = $material_id";
  // submit the query and redirect if successful
  $done = mysql_query($sql) or die(mysql_error());
  }
// redirect page on success or if $article_id is invalid
if ($done && $uploadImage=="") {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/materials-list.php');
  exit;
  }
?>

<?php include ('includes/header-private.php'); ?>


<!-- BEGIN UPDATE FORM -->
<h1>Update Material Entry</h1>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {

	if($uploadResult){
		echo "<b><p>$uploadResult</p></b>";
	}
?>
<form id="theform" name="theform" method="post" action="" >
	<p><label for="material_name">Material Name:</label><br /><input id="material_name" name="material_name" type="text" size="25" value="<?php echo htmlentities($row['material_name']); ?>" /></p>
    <p><input type="submit" name="update" value="Update Entry" /></p>
	<p><input name="material_id" type="hidden" value="<?php echo $row['material_id']; ?>" /></p>
</form>
<?php } ?>
<!-- END UPDATE FORM -->

<?php include ('includes/footer-private.php'); ?>