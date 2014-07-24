<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');

// connect to MySQL
$conn = dbConnect('query');

// prepare the SQL query
$sqlProduct = 'SELECT * FROM sb_products ORDER BY title';
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_id';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_id';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_id';
$sqlColor = 'SELECT * FROM sb_colors ORDER BY color_id';

// submit the query and capture the result
$resultProduct = mysql_query($sqlProduct) or die(mysql_error());
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
$resultColor = mysql_query($sqlColor) or die(mysql_error());

// find out how many records were retrieved
$numRowsProduct = mysql_num_rows($resultProduct);
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
$numRowsColor = mysql_num_rows($resultColor);

if (array_key_exists('insert', $_POST)) {
	// remove backslashes
	nukeMagicQuotes();
	// prepare an array of expected items
	$expected = array('filename_one', 'filename_two','filename_three', 'filename_four', 'title', 'category', 'material', 'brand', 'color', 'depth', 'width', 'height', 'surface', 'bracket', 'load_B', 'load_TS', 'load_S', 'description');
	// make $_POST data safe for insertion into database
	foreach ($_POST as $key => $value) {
	if (in_array($key, $expected)) {
	  ${$key} = mysql_real_escape_string($value);
	  }
	}
	// prepare the SQL query
	$sql = "INSERT INTO sb_products (filename_one, filename_two, filename_three, filename_four, title, category, material, brand, color, depth, width, height, surface, bracket, load_B, load_TS, load_S, description, created)
		  VALUES('$filename_one','$filename_two', '$filename_three','$filename_four', '$title', '$category', '$material', '$brand', '$color', '$depth','$width','$height', '$surface', '$bracket', '$load_B', '$load_TS', '$load_S', '$description', NOW())";
	// process the query
	$result = mysql_query($sql) or die(mysql_error());
	// if successful, redirect to list of existing records
	if ($result) {
	header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/products-list.php');
	exit;
	}
}
	
// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 51200);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', '../uploads/');
  // convert the maximum size to KB
  $max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
  // create an array of permitted MIME types
  $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
  
  foreach ($_FILES['image']['name'] as $number => $file) {
    // replace any spaces in the filename with underscores
	$file = str_replace(' ', '_', $file);
    // begin by assuming the file is unacceptable
    $sizeOK = false;
    $typeOK = false;
  
    // check that file is within the permitted size
    if ($_FILES['image']['size'][$number] > 0 || $_FILES['image']['size'][$number] <= MAX_FILE_SIZE) {
    $sizeOK = true;
	}

    // check that file is of an permitted MIME type
    foreach ($permitted as $type) {
      if ($type == $_FILES['image']['type'][$number]) {
        $typeOK = true;
	    break;
	    }
	  }
  
    if ($sizeOK && $typeOK) {
      switch($_FILES['image']['error'][$number]) {
	    case 0:
          // check if a file of the same name has been uploaded
		  if (!file_exists(UPLOAD_DIR.$file)) {
		    // move the file to the upload folder and rename it
		    $success = move_uploaded_file($_FILES['image']['tmp_name'][$number], UPLOAD_DIR.$file);
		    }
		  else {
		    // get the date and time
		    ini_set('date.timezone', 'Europe/London');
		    $now = date('Y-m-d-His');
		    $success = move_uploaded_file($_FILES['image']['tmp_name'][$number], UPLOAD_DIR.$now.$file);
		    }
		  if ($success) {
            $result[] = "$file uploaded successfully";
			$poo[] = "$file";
			
	        }
		  else {
		    $result[] = "Error uploading $file. Please try again.";
		    }
	      break;
	    case 3:
		  $result[] = "Error uploading $file. Please try again.";
		default:
          $result[] = "System error uploading $file. Contact webmaster.";
	    }
      }
    elseif ($_FILES['image']['error'][$number] == 4) {
	  $result[] = 'No file selected';
	  }
	else {
      $result[] = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.";
	  }
	}
  }
  
  
  
  
?>


<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Product Entry</h1>
<?php
// if the form has been submitted, display result
if (isset($result)) {
  foreach ($result as $item) {
    echo "<strong><p>$item</p></strong>";
	}
  }
?>
<form action="" method="post" enctype="multipart/form-data" name="multiUpload" id="multiUpload">
  
    <?php 
		for($i=0; $i < 4; $i++) {        
			  echo "<p>Upload Image ".$i."</p><p><input name=\"image[]\" type=\"file\" id=\"file[]\" /></p>";
			  echo "<p><input type=\"text\" name=\"filename_$i\" value=\"$file\" /></p>";
			}
		echo "<p><input name=\"upload\" type=\"submit\" value=\"Submit\"></p>";
			
	?>    
    <p><label for="title">Title:</label><br /><input id="title" name="title" type="text" size="25" /></p>
    <p><label for="category">Category:</label><br />
    <select name="category" id="category">
        <option value="---">---</option>
        <?php while ($row = mysql_fetch_assoc($resultCategory)) { ?>
        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="material">Material:</label><br />
    <select name="material" id="material">
      <option value="---">---</option>
        <?php while ($row = mysql_fetch_assoc($resultMaterial)) { ?>
        <option value="<?php echo $row['material_id']; ?>"><?php echo $row['material_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="brand">Brand:</label><br />
    <select name="brand" id="brand">
      <option value="---">---</option>
        <?php while ($row = mysql_fetch_assoc($resultBrand)) { ?>
        <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
        <?php } ?>
    </select></p>
    
    <p><label for="color">Color:</label><br />
    <select name="color" id="color">
      <option value="---">---</option>
        <?php while ($row = mysql_fetch_assoc($resultColor)) { ?>
        <option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
        <?php } ?>
    </select></p>
    
    <p><label for="depth">Depth:</label><br /><input id="depth" name="depth" type="text" size="5" /> in.</p>
    <p><label for="width">Width:</label><br /><input id="width" name="width" type="text" size="5" /> in.</p>
    <p><label for="height">Height:</label><br /><input id="height" name="height" type="text" size="5" /> in.</p>
    <p><label for="surface">Surface Accomodation:</label><br /><input id="surface" name="surface" type="text" size="5" /> in.</p>
    <p><label for="bracket">Bracket Accomodation:</label><br /><input id="bracket" name="bracket" type="text" size="5" /> in.</p>
    <p><label for="load_B">Load - Bracket:</label><br /><input id="load_B" name="load_B" type="text" size="5" /> lbs.</p>
    <p><label for="load_TS">Load - Top Surface:</label><br /><input id="load_TS" name="load_TS" type="text" size="5" /> lbs.</p>
    <p><label for="load_S">Load - Shelves:</label><br /><input id="load_S" name="load_S" type="text" size="5" /> lbs.</p>
	<p><label for="description">Description:</label><br /><textarea id="description" name="description" cols="40" rows="10"></textarea></p>
    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>
</form>
<!-- END INSERT FORM -->

<?php include ('includes/footer-private.php'); ?>