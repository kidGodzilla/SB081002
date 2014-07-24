<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('category_name', 'category_id');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if ($_GET && !$_POST) {
  if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $career_id = $_GET['category_id'];
	}
  else {
    $career_id = NULL;
	}
  if ($career_id) {
    $sql = "SELECT * FROM sb_categories WHERE category_id = $category_id";
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
  if (!is_numeric($category_id)) {
    die('Invalid request');
	}
  // prepare the SQL query
  $sql = "UPDATE sb_categories SET category_name = '$category_name'
  WHERE category_id = $category_id";
  // submit the query and redirect if successful
  $done = mysql_query($sql) or die(mysql_error());
  }
// redirect page on success or if $article_id is invalid
if ($done || !isset($career_id)) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/categories-list.php');
  exit;
  }
?>

<?php include ('includes/header-private.php'); ?>


<!-- BEGIN UPDATE FORM -->
<h1>Update Category Entry</h1>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<form id="theform" name="theform" method="post" action="" >
	<p><label for="category_name">Category Name:</label><br /><input id="category_name" name="category_name" type="text" size="25" value="<?php echo htmlentities($row['category_name']); ?>" /></p>
    <p><input type="submit" name="update" value="Update Entry" /></p>
	<p><input name="category_id" type="hidden" value="<?php echo $row['category_id']; ?>" /></p>
</form>
<?php } ?>
<!-- END UPDATE FORM -->

<?php include ('includes/footer-private.php'); ?>