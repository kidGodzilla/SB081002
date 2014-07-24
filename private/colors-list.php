<?php
include('includes/session.php');
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM sb_colors ORDER BY color_name';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> colors were found. <a href="colors-insert.php">Insert</a> a new color.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <th width="100" valign="top">Color Image</th>
    <th width="200" valign="top">Color Name</th>
    <th>&nbsp;</th>
    <th width="50">&nbsp;</th>
  </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
  <tr>
    <td valign="top"><img src="../colors/<?php echo $row['color_file']; ?>" /></td>
    <td valign="top"><?php echo $row['color_name']; ?></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><small><a href="colors-update.php?color_id=<?php echo $row['color_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="colors-delete.php?color_id=<?php echo $row['color_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>