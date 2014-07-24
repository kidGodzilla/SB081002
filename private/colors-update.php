<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('color_name', 'color_id', 'color_file');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if (isset($_GET['color_id']) && is_numeric($_GET['color_id'])) {
	$career_id = $_GET['color_id'];
} else {
	$career_id = NULL;
}
if ($career_id) {
	$sql = "SELECT * FROM sb_colors WHERE color_id = $color_id";
	$result = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_assoc($result);
}
// if update form has been submitted, update record
if (array_key_exists('update', $_POST)) {
  // prepare expected items for insertion in to database
	foreach ($_POST as $key => $value) {
		if (in_array($key, $expected)) {
		  ${$key} = mysql_real_escape_string($value);
		}
	}
	// abandon the process if primary key invalid
	if (!is_numeric($color_id)) {
    	die('Invalid request: color not numeric');
	}
	// prepare the SQL query
	$sql = "UPDATE sb_colors SET color_name = '$color_name', color_file= '$color_file'
	WHERE color_id = $color_id";
	// submit the query and redirect if successful
	$done = mysql_query($sql) or die(mysql_error());
} 
  

// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 51200);
$fileFieldName = "color_file";
$fileUploadDir = 'colors';

if (array_key_exists('upload', $_POST)) {
	// define constant for upload folder
	define('UPLOAD_DIR', '../'.$fileUploadDir.'/');
	// convert the maximum size to KB
	$max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
	// create an array of permitted MIME types
	$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
	foreach($_FILES as $post_var=>$info) {
		if($info['name']!="") {
			$file = str_replace(' ', '_', $info['name']);
			// begin by assuming the file is unacceptable
			$sizeOK = false;
			$typeOK = false;
			// check that file is within the permitted size
    		if ($info['size'] > 0 || $info['size'] <= MAX_FILE_SIZE) {
    			$sizeOK = true;
			}

    		// check that file is of an permitted MIME type
    		foreach ($permitted as $type) {
      			if ($type == $info['type']) {
        			$typeOK = true;
	    			break;
	    		}
	  		}
    		if ($sizeOK && $typeOK) {
      			switch($info['error']) {
	    			case 0:
						// check if a file of the same name has been uploaded
						if (!file_exists(UPLOAD_DIR.$file)) {
							// move the file to the upload folder and rename it
							$success = move_uploaded_file($info['tmp_name'], UPLOAD_DIR.$file);
						} else {
							// get the date and time
							ini_set('date.timezone', 'Europe/London');
							$now = date('Y-m-d-His');
							$success = move_uploaded_file($info['tmp_name'], UPLOAD_DIR.$now.$file);
						}
		  				if ($success) {
							$row[$fileFieldName] = $file; // update result set to have NEW file instead (this will get saved with update form)				
            				$uploadResult = $file." uploaded successfully";
	        			} else {
		    				$uploadResult = "Error uploading $file. Please try again.";
		    			}
	      				break;
	    			case 3:
		  				$uploadResult = "Error uploading $file. Please try again.";
					default:
          				$uploadResult = "System error uploading $file. Contact webmaster.";
	    		}
      		} elseif ($info['error'] == 4) {
	  			$uploadResult = 'No file selected';
	  		} else {
      			$uploadResult = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.";
	  		}
		}
	}    
}


// redirect page on success or if $article_id is invalid
if ($done && $uploadImage=="") {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/colors-list.php');
  exit;
  }
  
?>

<?php include ('includes/header-private.php'); ?>


<!-- BEGIN UPDATE FORM -->
<h1>Update Color Entry</h1>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<form id="theform" name="theform" enctype="multipart/form-data" method="post" action="" >
    <?
	$filename = htmlentities($row[$fileFieldName]);
	$filepath = '../colors/'.$filename;
	echo '<p>Image:<br />';
	echo '<img class="color-image-thumb" src="'.$filepath.'" /><br />'; 
	// hidden field with data
	echo '<input id="color_file" name="color_file" type="hidden" size="25" value="'.$row[$fileFieldName].'" />'; // TODO: change value to new file
	// show upload form
	echo '<p><input type="file" name="uploadImage" id="uploadImage" /></p>';
	echo '<p><input name="upload" type="submit" id="upload" value="Upload New Image" /></p>';
	echo "</p>";
	?>
    <p><label for="color_name">Color Name:</label><br /><input id="color_name" name="color_name" type="text" size="25" value="<?php echo htmlentities($row['color_name']); ?>" /></p>
    <p><input type="submit" name="update" value="Update Entry" /></p>
	<p><input name="color_id" type="hidden" value="<?php echo $row['color_id']; ?>" /></p>
</form>
<?php } ?>
<!-- END UPDATE FORM -->

<?php include ('includes/footer-private.php'); ?>