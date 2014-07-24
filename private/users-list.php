<?php
include('includes/session.php');
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM sb_users ORDER BY lastname DESC';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> users were found. <a href="user-register.php">Register</a> a new user.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
  	<th width="100">Last Name</th>
  	<th width="100">First Name</th>
    <th>Username</th>
    <th>&nbsp;</th>
    <th width="75">&nbsp;</th>
  </tr>
<?php
while ($users = mysql_fetch_assoc($result)) {
?>
  <tr>
    <td><?php echo $users['lastname']; ?></td>
    <td><?php echo $users['firstname']; ?></td>
    <td><?php echo $users['username']; ?></td>
    <td>&nbsp;</td>
	<td><small><a href="user-update.php?user_id=<?php echo $users['user_id']; ?>">EDIT</a> | <a href="user-delete.php?user_id=<?php echo $users['user_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>