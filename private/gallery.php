<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  header('Location: http://www.premiumdw.com/testies/index.php');
  exit;
  }
include('includes/conn_mysql.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM testies_gallery ORDER BY created DESC';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> records were found. <a href="insert.php">Insert</a> a new record, bitch.</p>

<!-- Begin Product List -->
        <?php while ($row = mysql_fetch_assoc($result)) { ?>
		<div class="product-list">
        <a href="individual.php?gallery_id=<?php echo $row['gallery_id']; ?>"><img src="uploads/<?php echo $row['filename']; ?>" alt="<?php echo $row['title']; ?>" border="0" /></a>
        <h2><a href="individual.php?gallery_id=<?php echo $row['gallery_id']; ?>"><?php echo $row['title']; ?></a></h2>
        <p><a href="individual.php?gallery_id=<?php echo $row['gallery_id']; ?>"><?php echo $row['description']; ?></a></p>
        </div>
        <?php } ?>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>