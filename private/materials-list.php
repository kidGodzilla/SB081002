<?php
include('includes/session.php');
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM sb_materials ORDER BY material_name';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> materials were found. <a href="materials-insert.php">Insert</a> a new material.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <th width="250">Material Name</th>
    <th>&nbsp;</th>
    <th width="125">&nbsp;</th>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
  <tr>
    <td valign="top"><?php echo $row['material_name']; ?></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><small><a href="materials-update.php?material_id=<?php echo $row['material_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="materials-delete.php?material_id=<?php echo $row['material_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>