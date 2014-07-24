<?php
include('includes/session.php');
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM sb_products ORDER BY title';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> products were found. <a href="products-insert.php">Insert</a> a new product.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
  	<th width="100">Image</th>
    <th width="250">Title</th>
    <th>Description</th>
    <th width="125">&nbsp;</th>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
  <tr>
    <td valign="top"><img class="product-images-list" src="../uploads/<?php echo $row['filename_one']; ?>" alt="<?php echo $row['title']; ?>" /></td>
    <td valign="top"><?php echo $row['title']; ?></td>
    <td valign="top"><b><?php echo htmlentities($row['depth']); ?>in.(D) x <?php echo htmlentities($row['width']); ?>in.(W) x <?php echo htmlentities($row['height']); ?>in.(H)</b></td>
    <td valign="top"><small><a href="products-view.php?product_id=<?php echo $row['product_id']; ?>">VIEW</a>&nbsp;&Iota;&nbsp;<a href="products-update.php?product_id=<?php echo $row['product_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="products-delete.php?product_id=<?php echo $row['product_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>