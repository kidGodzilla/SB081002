<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  header('Location: http://www.premiumdw.com/testies/index.php');
  exit;
  }
include('includes/conn_mysql.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('title', 'description', 'gallery_id');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if ($_GET && !$_POST) {
  if (isset($_GET['gallery_id']) && is_numeric($_GET['gallery_id'])) {
    $gallery_id = $_GET['gallery_id'];
	}
  else {
    $gallery_id = NULL;
	}
  if ($gallery_id) {
    $sql = "SELECT * FROM testies_gallery WHERE gallery_id = $gallery_id";
  $result = mysql_query($sql) or die (mysql_error());
  $row = mysql_fetch_assoc($result);
	}
  }
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PRODUCT DETAIL -->
<?php if (empty($row)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else { ?>
<div class="product-detail">
    <img src="uploads/<?php echo htmlentities($row['filename']); ?>"  alt=""  border="0" />
    <h2><?php echo htmlentities($row['title']); ?></h2>
    <p><?php echo htmlentities($row['description']); ?></p>
</div>
<?php } ?>
<!-- END PRODUCT DETAIL -->


<?php include ('includes/footer-private.php'); ?>