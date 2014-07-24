<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['suser_id'])) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/index.php');
  exit;
  }
include('includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sqlCareer = 'SELECT * FROM sb_careers ORDER BY created DESC';
// submit the query and capture the result
$resultCareer = mysql_query($sqlCareer) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($resultCareer);
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN PAGE SPECIFIC -->
<p>A total of <b><?php echo $numRows; ?></b> careers were found. <a href="careers-insert.php">Insert</a> a new career.</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <th width="200" valign="top">Title</th>
    <th width="100" valign="top">Location</th>
    <th>Description</th>
    <th width="50">&nbsp;</th>
  </tr>
<?php
while ($row = mysql_fetch_assoc($resultCareer)) {
?>
  <tr>
    <td valign="top"><?php echo $row['title']; ?></td>
    <td valign="top"><?php echo $row['location']; ?></td>
    <td valign="top"><?php echo substr($row['description'], 0, 75); ?> ...</td>
    <td valign="top"><small><a href="careers-view.php?career_id=<?php echo $row['career_id']; ?>">VIEW</a>&nbsp;&Iota;&nbsp;<a href="careers-update.php?career_id=<?php echo $row['career_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="careers-delete.php?career_id=<?php echo $row['career_id']; ?>">DELETE</a></small></td>
  </tr>
<?php } ?>
</table>
<!-- BEGIN PAGE SPECIFIC -->

<?php include ('includes/footer-private.php'); ?>