<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// create database connection
$conn = dbConnect('admin');
// initialize flag
$deleted = false;
// get details of selected record
if ($_GET && !$_POST) {
  // check that primary key is numeric
  if (isset($_GET['brand_id']) && is_numeric($_GET['brand_id'])) {
    $career_id = $_GET['brand_id'];
	}
  else {
    $career_id = NULL;
	}
  if ($career_id) {
    $sql = "SELECT * FROM sb_brands WHERE brand_id = $brand_id";
    $result = mysql_query($sql) or die (mysql_error());
    $row = mysql_fetch_assoc($result);
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  if (!is_numeric($_POST['brand_id'])) {
    die('Invalid request');
	}
  $sql = "DELETE FROM sb_brands
          WHERE brand_id = {$_POST['brand_id']}";
  $deleted = mysql_query($sql) or die(mysql_error());
  }
// redirect the page if deletion successful, cancel button clicked, or $_GET['career_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['brand_id']))  {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/brands-list.php');
  exit;
  }
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN DELETE FORM -->
<h1>Delete Brand Entry</h1>
<?php if (!isset($brand_id) || empty($row)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<p><b><?php echo htmlentities($row['brand_name']); ?></b></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if (!empty($row)) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if (!empty($row)) { ?>
		<input name="brand_id" type="hidden" value="<?php echo $row['brand_id']; ?>" />
	<?php } ?>
    </p>
</form>
<!-- END DELETE FORM -->

<?php include ('includes/footer-private.php'); ?>