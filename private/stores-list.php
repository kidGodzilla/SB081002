<?php
include('includes/session.php');
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM sb_stores ORDER BY store_name';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> stores were found. <a href="stores-insert.php">Insert</a> a new store.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <th width="100" valign="top">Store Image</th>
    <th width="200" valign="top">Store Name</th>
    <th>&nbsp;</th>
    <th width="50">&nbsp;</th>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
  <tr>
    <td valign="top"><img src="../stores/<?php echo $row['store_file']; ?>" /></td>
    <td valign="top"><?php echo $row['store_name']; ?></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><small><a href="stores-update.php?store_id=<?php echo $row['store_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="stores-delete.php?store_id=<?php echo $row['store_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>