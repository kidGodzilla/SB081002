<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');

// connect to MySQL
$conn = dbConnect('query');

// prepare the SQL query
$sqlProduct = 'SELECT * FROM sb_products ORDER BY title';
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_name';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_name';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_name';
$sqlColor = 'SELECT * FROM sb_colors ORDER BY color_name';
$sqlLink = 'SELECT * FROM sb_links ORDER BY link_name';
$sqlStores = 'SELECT * FROM sb_stores ORDER BY store_name';

// submit the query and capture the result
$resultProduct = mysql_query($sqlProduct) or die(mysql_error());
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
$resultColor = mysql_query($sqlColor) or die(mysql_error());
$resultLink = mysql_query($sqlLink) or die(mysql_error());
$resultStores = mysql_query($sqlStores) or die(mysql_error());

// find out how many records were retrieved
$numRowsProduct = mysql_num_rows($resultProduct);
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
$numRowsColor = mysql_num_rows($resultColor);
$numRowsLink = mysql_num_rows($resultLink);
$numRowsStores = mysql_num_rows($resultStores);

$numbers = array('one','two','three','four','five','six');


if (array_key_exists('insert', $_POST)) {
	// remove backslashes
	nukeMagicQuotes();
	// prepare an array of expected items
	$expected = array('filename_one', 'filename_two','filename_three', 'filename_four', 'filename_five', 'filename_six', 'filename_pdf','title', 'category', 'material', 'brand', 'color', 'finish', 'depth', 'width', 'height', 'surface', 'bracket', 'load_B', 'load_TS', 'load_S', 'description_01', 'description_02', 'description_03', 'description_04', 'description_05', 'description_06', 'description_07', 'description_08');
	// make $_POST data safe for insertion into database
	foreach ($_POST as $key => $value) {
		if (in_array($key, $expected)) {
	  		${$key} = mysql_real_escape_string($value);
	  	}
	}
	
	// prepare the SQL query
	$sql = "INSERT INTO sb_products (filename_one, filename_two, filename_three, filename_four,  filename_five, filename_six, filename_pdf, title, category, material, brand, color, finish, depth, width, height, surface, bracket, load_B, load_TS, load_S, description_01, description_02, description_03, description_04, description_05, description_06, description_07, description_08, created)
		  VALUES('$filename_one','$filename_two', '$filename_three','$filename_four','$filename_five','$filename_six','$filename_pdf', '$title', '$category', '$material', '$brand', '$color', '$finish', '$depth','$width','$height', '$surface', '$bracket', '$load_B', '$load_TS', '$load_S', '$description_01', '$description_02', '$description_03', '$description_04', '$description_05', '$description_06','$description_07','$description_08', NOW())";
	// process the query
	$result = mysql_query($sql) or die(mysql_error());
	
	// This next bit is kinda hacky but it's quick and works. Don't ever do this on a system that would need to scale :) go team!
	// get the product id for the item we just added
	$sqlProdID = "SELECT product_id FROM sb_products WHERE title='$title'";
	$resProdID = mysql_query($sqlProdID) or die(mysql_error());
	$product_id = mysql_result($resProdID,0);
	
	// TODO: should probably check to make sure $product_id exists
	
	// TODO: this isn't really efficient, we can build a better query
	
	foreach ($_POST as $key => $value) {
		if(strpos($key,'link_')!==false){ // links (unknown number)
			// inserts links for product into productLinks table
			$sqlInsertLink = "INSERT INTO sb_productLinks (product_id, link_id) VALUES('".$product_id."','".mysql_real_escape_string($value)."')";
			$resultLink = mysql_query($sqlInsertLink) or die(mysql_error());
		}
		if(strpos($key,'store_')!==false){ // links (unknown number)
			// inserts links for product into productLinks table
			$sqlInsertStore = "INSERT INTO sb_productStores (product_id, store_id) VALUES('".$product_id."','".mysql_real_escape_string($value)."')";
			$resultLink = mysql_query($sqlInsertStore) or die(mysql_error());
		}
	}
	// if successful, redirect to list of existing records
	if ($result) {
	header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/products-list.php');
	exit;
	}
}


// TODO: this whole thing should be in an include file as an upload class (we have duplicate code)

if (array_key_exists('upload', $_POST)) {
	define('MAX_FILE_SIZE', 100*102400); // 10MB
	// convert the maximum size to KB
	$max = number_format(MAX_FILE_SIZE/1024, 0).'KB';
	// define a constant for the maximum upload size
	define('UPLOAD_DIR', '../uploads/');
	// create an array of permitted MIME types
	$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'application/pdf');
  
	if($_FILES['upload_pdf'] && $_FILES['upload_pdf']['name']) {
		$dir = '../downloads/'; // put into the download folder
		$fileFieldName = "filename_pdf";
		$info = $_FILES['upload_pdf'];
		$file = str_replace(' ', '_', $info['name']);
		// begin by assuming the file is unacceptable
		$sizeOK = false;
		$typeOK = false;
    	if ($info['size'] > 0) {
			$size = number_format($info['size']/1024, 0);
			if($size <= MAX_FILE_SIZE)	
				$sizeOK = true;
		}
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
					if (!file_exists($dir.$file)) {
						// move the file to the upload folder and rename it
						$success = move_uploaded_file($info['tmp_name'], $dir.$file);
					} else {
						// get the date and time
						ini_set('date.timezone', 'Europe/London');
						$now = date('Y-m-d-His');
						$success = move_uploaded_file($info['tmp_name'], $dir.$now.$file);
					}
					if ($success) {
						$row[$fileFieldName] = $file; // update result set to have NEW file instead (this will get saved with update form)
						$uploadResult = '<span class="success"><a target="_blank" href="../downloads/'.$file.'">'.$file.'</a> uploaded successfully</span>';
					} else {
						$uploadResult = "<span class=\"error\">Error uploading $file. Please try again.</span>";
					}
					break;
				case 3:
					$uploadResult = "<span class=\"error\">Error uploading $file. Please try again.</span>";
					break;
				default:
					$uploadResult = "<span class=\"error\">System error uploading $file. Contact webmaster.</span>";
					break;
	    	}
		} elseif ($info['error'] == 4) {
			$uploadResult = '<span class=\"error\">No file selected</span>';
		} else {
			$uploadResult = "<span class=\"error\">$file cannot be uploaded. Maximum size: $max and file is ".$size."KB. Acceptable file types: gif, jpg, png, pdf.</span>";
		}
	}else{
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
						$result[] = "<span class=\"success\">$file uploaded successfully</span>";
						$poo[] = "$file";
						}
					  else {
						$result[] = "<span class=\"error\">Error uploading $file. Please try again.</span>";
						}
					  break;
					case 3:
					  $result[] = "<span class=\"error\">Error uploading $file. Please try again.</span>";
					default:
					  $result[] = "<span class=\"error\">System error uploading $file. Contact webmaster.</span>";
				}
			}
			elseif ($_FILES['image']['error'][$number] == 4) {
			  $result[] = '<span class=\"error\">No file selected</span>';
			}
			else {
			  $result[] = "<span class=\"error\">$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.</span>";
			}
		}
	}
} 
?>


<?php include ('includes/header-private.php'); ?>

<!-- BEGIN INSERT FORM -->
<h1>New Product Entry</h1>
<form action="" method="post" enctype="multipart/form-data" name="multiUpload" id="multiUpload">
	<br /><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
    <p><b>STEP 01) Upload Images</b></p>
    <p><small>NOTE: Images size is 284px X 284px</small></p>
    <?php
	for($i=0;$i<6;$i++) {
		$num = $i+1;
		$file = 'filename_'.$numbers[$i];
		if(isset($poo))	$filename = $poo[$i];
		else	$filename = ${$file};
		$filepath = '../uploads/'.$filename;
		echo '<p><label for="image'.$num.'">Image 0'.$num.':</label><br />';
		if($filename!='')	echo '<img class="product-images-thumb" src="'.$filepath.'" /><br />'; 
		// hidden field with data
		echo '<input type="hidden" id="'.$file.'" name="'.$file.'" value="'.$filename.'" />';
		// show upload form
		echo '<input type="file" name="image[]" id="image'.$num.'" />';
		echo "</p>";
	}
	echo '<p><input name="upload" type="submit" id="upload" value="Upload Images" /></p>';
	// if the form has been submitted, display result
	if (isset($result)) {
	  foreach ($result as $item) {
		echo "<strong><p>$item</p></strong>";
		}
	  }
	?>
    <p>&nbsp;</p> 
    <p><b>STEP 02) Upload Product Manual</b></p>
    <p>Product Manual:</p>
    <?
		if($uploadResult)	echo "<p>$uploadResult</p>";
		if(!$upload_pdf || $upload_pdf=="") { // no manual
			echo '<p>No manual uploaded yet.</p>';
		}
	?>
    <p><input type="hidden" name="filename_pdf" value="<?php echo $filename_pdf; ?>" /><input type="file" name="upload_pdf" id="upload_pdf" /></p>
    <p><input name="upload" type="submit" id="uploadpdf" value="Upload Manual" /></p>    
    <p>&nbsp;</p> 
    <p><b>STEP 03) Create Data</b></p> 
    <p><label for="title">Title:</label><br /><input id="title" name="title" type="text" size="25" /></p>
    <p><label for="category">Category:</label><br />
    <select name="category" id="category">
        <option value="">---</option>
        <?php while ($row = mysql_fetch_assoc($resultCategory)) { ?>
        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="material">Material:</label><br />
    <select name="material" id="material">
      <option value="">---</option>
        <?php while ($row = mysql_fetch_assoc($resultMaterial)) { ?>
        <option value="<?php echo $row['material_id']; ?>"><?php echo $row['material_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="brand">Brand:</label><br />
    <select name="brand" id="brand">
      <option value="">---</option>
        <?php while ($row = mysql_fetch_assoc($resultBrand)) { ?>
        <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="color">Color:</label><br />
    <select name="color" id="color">
      <option value="">---</option>
        <?php while ($row = mysql_fetch_assoc($resultColor)) { ?>
        <option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="finish">Finish:</label><br /><input id="finish" name="finish" type="text" size="20" /></p>
    <p><label for="depth">Depth:</label><br /><input id="depth" name="depth" type="text" size="5" /> in.</p>
    <p><label for="width">Width:</label><br /><input id="width" name="width" type="text" size="5" /> in.</p>
    <p><label for="height">Height:</label><br /><input id="height" name="height" type="text" size="5" /> in.</p>
    <p><label for="surface">Surface Accomodation:</label><br /><input id="surface" name="surface" type="text" size="5" /> in.</p>
    <p><label for="bracket">Bracket Accomodation:</label><br /><input id="bracket" name="bracket" type="text" size="5" /> in.</p>
    <p><label for="load_B">Load - Bracket:</label><br /><input id="load_B" name="load_B" type="text" size="5" /> lbs.</p>
    <p><label for="load_TS">Load - Top Surface:</label><br /><input id="load_TS" name="load_TS" type="text" size="5" /> lbs.</p>
    <p><label for="load_S">Load - Shelves:</label><br /><input id="load_S" name="load_S" type="text" size="5" /> lbs.</p>
    
    <p>Pop-Up Links:</p>
    <?php while ($row = mysql_fetch_assoc($resultLink)) { ?>
    <p><input name="link_<?php echo $row['link_id']; ?>" type="checkbox" value="<?php echo $row['link_id']; ?>" /> <?php echo $row['link_name']; ?></p>
    <?php } ?>
    <p>Available in Stores:</p>
    <?php while ($row = mysql_fetch_assoc($resultStores)) { ?>
    <p><input name="store_<?php echo $row['store_id']; ?>" type="checkbox" value="<?php echo $row['store_id']; ?>" /> <?php echo $row['store_name']; ?></p>
    <?php } 
	
	for($i=1; $i<=8;$i++) {
		echo '<p><label for="description_0'.$i.'">Description 0'.$i.':</label><br /><textarea id="description_0'.$i.'" name="description_0'.$i.'" cols="40" rows="3"></textarea></p>';
	}
	?>

    <p><input id="insert" name="insert" type="submit" value="Insert Entry" /></p>    
</form>
<!-- END INSERT FORM -->

<?php include ('includes/footer-private.php'); ?>

