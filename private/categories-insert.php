<?php
include('includes/session.php');
if (array_key_exists('insert', $_POST)) {
  include('includes/connect.php');
  include('includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // prepare an array of expected items
  $expected = array('category_name');
  // create database connection
  $conn = dbConnect('admin');
  // make $_POST data safe for insertion into database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // prepare the SQL query
  $sql = "INSERT INTO sb_categories ( category_name)
          VALUES('$category_name')";
  // process the query
  $result = mysql_query($sql) or die(mysql_error());
  // if successful, redirect to list of existing records
  if ($result) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/categories-list.php');
    exit;
    }
  }
 
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Category Entry</h1>
<?php
// if the "upload image" button has been submitted, display result
if (isset($result)) {
  echo "<p><strong>$result</strong></p>";
  }
?>
<form id="theform" name="theform" method="post" enctype="multipart/form-data" action="" >
    <p><label for="category_name">Category Name:</label><br /><input id="category_name" name="category_name" type="text" size="25" /></p>

    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>
</form>
<!-- END INSERT FORM -->


<?php include ('includes/footer-private.php'); ?>