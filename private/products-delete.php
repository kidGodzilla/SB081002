<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/index.php');
  exit;
  }
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
  if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
	}
  else {
    $product_id = NULL;
	}
  if ($product_id) {
    $sql = "SELECT * FROM sb_products WHERE product_id = $product_id";
    $result = mysql_query($sql) or die (mysql_error());
    $row = mysql_fetch_assoc($result);
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  if (!is_numeric($_POST['product_id'])) {
    die('Invalid request');
	}
  $sql = "DELETE FROM sb_products
          WHERE product_id = {$_POST['product_id']}";
  $deleted = mysql_query($sql) or die(mysql_error());
  $sql = "DELETE FROM sb_productLinks
          WHERE product_id = {$_POST['product_id']}";
  $deletedLinks = mysql_query($sql) or die(mysql_error());
  $sql = "DELETE FROM sb_productStores
          WHERE product_id = {$_POST['product_id']}";
  $deletedStores = mysql_query($sql) or die(mysql_error());
  }
// redirect the page if deletion successful, cancel button clicked, or $_GET['product_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['product_id']))  {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/products-list.php');
  exit;
  }
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN DELETE FORM -->
<h1>Delete Product Entry</h1>
<?php if (!isset($product_id) || empty($row)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<p><b><?php echo htmlentities($row['title']); ?></b></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if (!empty($row)) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if (!empty($row)) { ?>
		<input name="product_id" type="hidden" value="<?php echo $row['product_id']; ?>" />
	<?php } ?>
    </p>
</form>
<!-- END DELETE FORM -->

<?php include ('includes/footer-private.php'); ?>