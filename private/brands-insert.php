<?php
include('includes/session.php');
if (array_key_exists('insert', $_POST)) {
  include('includes/connect.php');
  include('includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // prepare an array of expected items
  $expected = array('brand_name');
  // create database connection
  $conn = dbConnect('admin');
  // make $_POST data safe for insertion into database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // prepare the SQL query
  $sql = "INSERT INTO sb_brands (brand_name, brand_file)
          VALUES('$brand_name','$brand_file')";
  // process the query
  $result = mysql_query($sql) or die(mysql_error());
  // if successful, redirect to list of existing records
  if ($result) {
    header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/brands-list.php');
    exit;
    }
  }
  
  // define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 51200);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', '../brands/');
  // replace any spaces in original filename with underscores
  // at the same time, assign to a simpler variable
  $file = str_replace(' ', '_', $_FILES['image']['name']);
  // convert the maximum size to KB
  $max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
  // create an array of permitted MIME types
  $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
  // begin by assuming the file is unacceptable
  $sizeOK = false;
  $typeOK = false;
  
  // check that file is within the permitted size
  if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
    $sizeOK = true;
	}

  // check that file is of an permitted MIME type
  foreach ($permitted as $type) {
    if ($type == $_FILES['image']['type']) {
      $typeOK = true;
	  break;
	  }
	}
  
  if ($sizeOK && $typeOK) {
    switch($_FILES['image']['error']) {
	  case 0:
        // check if a file of the same name has been uploaded
		if (!file_exists(UPLOAD_DIR.$file)) {
		  // move the file to the upload folder and rename it
		  $success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$file);
		  }
		else {
		  // get the date and time
		  ini_set('date.timezone', 'Europe/London');
		  $now = date('Y-m-d-His');
		  $success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$now.$file);
		  }
		if ($success) {
          $result = "$file uploaded successfully";
		  $poo = "$file";
	      }
		else {
		  $result = "Error uploading $file. Please try again.";
		  }
	    break;
	  case 3:
		$result = "Error uploading $file. Please try again.";
	  default:
        $result = "System error uploading $file. Contact webmaster.";
	  }
    }
  elseif ($_FILES['image']['error'] == 4) {
    $result = 'No file selected';
	}
  else {
    $result = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.";
	}
  }
 
?>

<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Brand Entry</h1>
<form id="theform" name="theform" method="post" enctype="multipart/form-data" action="" >
<p><b>STEP 01) Upload Image</b></p>
    <p><label for="brand_file">Brand Image:</label><br /><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" /><input type="file" name="image" id="image" /></p>
    <?php
	// if the "upload image" button has been submitted, display result
	if (isset($result)) {
	  echo "<p><strong>$result</strong></p>";
	  echo "<p><input type=\"hidden\" name=\"brand_file\" value=\"$poo\" /></p>";
	  echo "<p><img src=\"../brands/$poo\" /></p>";
	  }
	?>
    <p><input type="submit" name="upload" id="upload" value="Upload" /></p>
    <p><b>STEP 02) Insert Data</b></p>
    <p><label for="brand_name">Brand Name:</label><br /><input id="brand_name" name="brand_name" type="text" size="25" /></p>

    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>
</form>
<!-- END INSERT FORM -->


<?php include ('includes/footer-private.php'); ?>