<?php
include('includes/session.php');
if (array_key_exists('insert', $_POST)) {
  include('includes/connect.php');
  include('includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // prepare an array of expected items
  $expected = array('material_name');
  // create database connection
  $conn = dbConnect('admin');
  // make $_POST data safe for insertion into database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // prepare the SQL query
  $sql = "INSERT INTO sb_materials ( material_name)
          VALUES('$material_name')";
  // process the query
  $result = mysql_query($sql) or die(mysql_error());
  // if successful, redirect to list of existing records
  if ($result) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/materials-list.php');
    exit;
    }
  }
 
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Material Entry</h1>
<?php
// if the "upload image" button has been submitted, display result
if (isset($result)) {
  echo "<p><strong>$result</strong></p>";
  }
?>
<form id="theform" name="theform" method="post" enctype="multipart/form-data" action="" >
    <p><label for="material_name">Material Name:</label><br /><input id="material_name" name="material_name" type="text" size="25" /></p>

    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>
</form>
<!-- END INSERT FORM -->


<?php include ('includes/footer-private.php'); ?>