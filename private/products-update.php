<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');

// connect to MySQL
$conn = dbConnect('query');

// prepare the SQL query
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_name';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_name';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_name';
$sqlColor = 'SELECT * FROM sb_colors ORDER BY color_name';
$sqlLink = 'SELECT * FROM sb_links ORDER BY link_name';
$sqlStores = 'SELECT * FROM sb_stores ORDER BY store_name';

// submit the query and capture the result
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
$resultColor = mysql_query($sqlColor) or die(mysql_error());
$resultLink = mysql_query($sqlLink) or die(mysql_error());
$resultStores = mysql_query($sqlStores) or die(mysql_error());

// find out how many records were retrieved
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
$numRowsColor = mysql_num_rows($resultColor);
$numRowsLink = mysql_num_rows($resultLink);
$numRowsStores = mysql_num_rows($resultStores);


$numbers = array('one','two','three','four','five','six');

$product_links = array();
$product_stores = array();

// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('filename_one', 'filename_two','filename_three', 'filename_four', 'filename_five', 'filename_six', 'filename_pdf', 'title', 'category', 'material', 'brand', 'color', 'finish', 'depth', 'width', 'height', 'surface', 'bracket', 'load_B', 'load_TS', 'load_S', 'description_01', 'description_02', 'description_03', 'description_04', 'description_05', 'description_06', 'description_07', 'description_08', 'description_09', 'description_10');
// get details of selected record

if (isset($_REQUEST['product_id']) && is_numeric($_REQUEST['product_id'])) {
	$product_id = $_REQUEST['product_id'];
} else {
	$product_id = NULL;
}
if ($product_id) {
	$sql = 'SELECT * FROM sb_products WHERE product_id="'.$product_id.'"';
	$result = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_assoc($result);
	
	$sql = 'SELECT link_id FROM sb_productLinks WHERE product_id="'.$product_id.'"';
	$resultProdLinks = mysql_query($sql) or die (mysql_error());
	while($r=mysql_fetch_row($resultProdLinks)) {
		array_push($product_links,$r[0]);
	}
	
	$sql = 'SELECT store_id FROM sb_productStores WHERE product_id="'.$product_id.'"';
	$resultProdStores = mysql_query($sql) or die (mysql_error());
	while($r=mysql_fetch_row($resultProdStores)) {
		array_push($product_stores,$r[0]);
	}
}

// if form has been submitted, update record

if (array_key_exists('update', $_POST)) {
  // prepare expected items for insertion in to database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // abandon the process if primary key invalid
  	if (!is_numeric($product_id)) {
    	die('Invalid request');
	}
	// prepare the SQL query
	$sql = "UPDATE sb_products SET filename_one = '$filename_one', filename_two = '$filename_two', filename_three = '$filename_three', filename_four = '$filename_four', filename_five = '$filename_five', filename_six = '$filename_six', filename_pdf = '$filename_pdf', title = '$title', category = '$category', material = '$material', brand = '$brand', color = '$color', finish = '$finish', depth = '$depth', width = '$width', height = '$height', surface = '$surface', bracket = '$bracket', load_B = '$load_B', load_TS = '$load_TS', load_S = '$load_S', description_01 = '$description_01', description_02 = '$description_02', description_03 = '$description_03', description_04 = '$description_04', description_05 = '$description_05', description_06 = '$description_06', description_07 = '$description_07', description_08 = '$description_08', description_09 = '$description_09', description_10 = '$description_10'
		  WHERE product_id = $product_id";
	// submit the query and redirect if successful
	$done = mysql_query($sql) or die(mysql_error());
	
	// TODO: should probably check to make sure $product_id exists
	
	// remove all of the old links
	$sql = "DELETE FROM sb_productLinks
		  WHERE product_id='".$product_id."'";
	$deletedLinks = mysql_query($sql) or die(mysql_error());
	
	// remove all of the old stores
	$sql = "DELETE FROM sb_productStores
		  WHERE product_id='".$product_id."'";
	$deletedStores = mysql_query($sql) or die(mysql_error());
	
	// TODO: this isn't really efficient, we can build a better query
	foreach ($_POST as $key => $value) {
		if(strpos($key,'link_')!==false){ // links (unknown number)
			// inserts links for product into productLinks table
			$sqlInsertLinks = "INSERT INTO sb_productLinks (product_id, link_id) VALUES('".$product_id."','".mysql_real_escape_string($value)."')";
			$resultLinks = mysql_query($sqlInsertLinks) or die(mysql_error());
		}
		if(strpos($key,'store_')!==false){ // links (unknown number)
			// inserts links for product into productLinks table
			$sqlInsertStore = "INSERT INTO sb_productStores (product_id, store_id) VALUES('".$product_id."','".mysql_real_escape_string($value)."')";
			$resultLink = mysql_query($sqlInsertStore) or die(mysql_error());
		}
	}
  }
// redirect page on success or if $article_id is invalid
// TODO: don't redirect on upload submit (need to click save)
if ($done || !isset($product_id)) {
  header("Location: http://" . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']) . '/products-list.php');
  exit;
}


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
						$row['filename_pdf'] = $file; // update result set to have NEW file instead (this will get saved with update form)
						$uploadManualResult = '<span class="success"><a target="_blank" href="../downloads/'.$file.'">'.$file.'</a> uploaded successfully</span>';
					} else {
						$uploadManualResult = "<span class=\"error\">Error uploading $file. Please try again.</span>";
					}
					break;
				case 3:
					$uploadManualResult = "<span class=\"error\">Error uploading $file. Please try again.</span>";
					break;
				default:
					$uploadManualResult = "<span class=\"error\">System error uploading $file. Contact webmaster.</span>";
					break;
	    	}
		} elseif ($info['error'] == 4) {
			$uploadManualResult = '<span class=\"error\">No file selected</span>';
		} else {
			$uploadManualResult = "<span class=\"error\">$file cannot be uploaded. Maximum size: $max and file is ".$size."KB. Acceptable file types: gif, jpg, png, pdf.</span>";
		}
	}else{
		foreach($_FILES as $post_var=>$info) {
			$imageNum = split('image_', $post_var); 
			if(sizeof($imageNum)==2 && $info['name']!="") { // must be posted in format 'image_1' or 'image_[]' and ignore blank upload fields
				$myNum = $imageNum[1]; // trim off the actual number of the file upload from the post variable
				$wordNum = $numbers[$myNum-1];		
				// replace any spaces in the filename with underscores
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
								$row['filename_'.$wordNum] = $file; // update result set to have NEW file instead (this will get saved with update form)				
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
} 

?>
<?php include ('includes/header-private.php'); ?>

<!-- BEGIN UPDATE FORM -->
<h1>Update Product Entry</h1>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
	
<form id="theform" name="theform" method="post" enctype="multipart/form-data" action="" >
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" /> 
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" /><br />
    <p><b>STEP 01) Update Images</b></p>
    <p><small>NOTE: Images size is 284px X 284px</small></p>
	<?php
	if($uploadResult){
		echo "<b><p>$uploadResult</p></b>";
	}
	for($i=0;$i<6;$i++) {
		$num = $i+1;
		$file = 'filename_'.$numbers[$i];
		$filename = htmlentities($row[$file]);
		$filepath = '../uploads/'.$filename;
		echo '<p>Image 0'.$num.':<br />';
		echo '<img class="product-images-thumb" src="'.$filepath.'" /><br />'; 
			// hidden field with data
			echo '<input id="'.$file.'" name="'.$file.'" type="hidden" size="25" value="'.$filename.'" />'; // TODO: change value to new file
			// show upload form
			echo '<p><input type="file" name="image_'.$num.'" id="image_'.$num.'" /></p>';
			echo '<p><input name="upload" type="submit" id="upload" value="Upload New Image" /></p>';
		echo "</p>";
	}
	// if the form has been submitted, display result
	//if (isset($result)) {
	 // foreach ($result as $item) {
	//	echo "<strong><p>$item</p></strong>";
	//	}
	 // }
	?> 
    <p>&nbsp;</p> 
    <p><b>STEP 02) Update Product Manual</b></p>
    <p>Product Manual:</p>
    <?
		if($uploadManualResult){
			echo "<b><p>$uploadManualResult</p></b>";
		}
		if($row['filename_pdf']=="") { // no manual
			echo '<p>No manual uploaded yet.</p>';
		}else{
			echo '<p>Current Manual: <a target="_blank" href="../downloads/'.$row['filename_pdf'].'">'.$row['filename_pdf'].'</a></p>';
		}
	?>
    <p><input type="hidden" name="filename_pdf" value="<?php echo $row['filename_pdf']; ?>" /><input type="file" name="upload_pdf" id="upload_pdf" /></p>
    <p><input name="upload" type="submit" id="uploadpdf" value="Replace Manual" /></p> 
    <p>&nbsp;</p> 
    <p><b>STEP 03) Update Data</b></p> 
    <p><label for="title">Title:</label><br /><input id="title" name="title" type="text" size="40" value="<?php echo htmlentities($row['title']); ?>" /></p>
    <p><label for="category">Category:</label><br />
    <select name="category" id="category">
        <?php while ($rowCategory = mysql_fetch_assoc($resultCategory)) { 
			if( $rowCategory['category_id']==$row['category'])
				$selected = 'selected="selected"';
			else
				$selected = "";
		?>
        <option <?php echo $selected; ?> value="<?php echo $rowCategory['category_id']; ?>"><?php echo $rowCategory['category_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="material">Material:</label><br />
    <select name="material" id="material">
        <?php while ($rowMaterial = mysql_fetch_assoc($resultMaterial)) { 
			if( $rowMaterial['material_id']==$row['material'])
				$selected = 'selected="selected"';
			else
				$selected = "";
		?>
        <option <?php echo $selected; ?> value="<?php echo $rowMaterial['material_id']; ?>"><?php echo $rowMaterial['material_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="brand">Brand:</label><br />
    <select name="brand" id="brand">
        <?php while ($rowBrand = mysql_fetch_assoc($resultBrand)) { 
			if( $rowBrand['brand_id']==$row['brand'])
				$selected = 'selected="selected"';
			else
				$selected = "";
		?>
        <option <?php echo $selected; ?> value="<?php echo $rowBrand['brand_id']; ?>"><?php echo $rowBrand['brand_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="color">Color:</label><br />
    <select name="color" id="color">
        <?php while ($rowColor = mysql_fetch_assoc($resultColor)) { 
			if( $rowColor['color_id']==$row['color'])
				$selected = 'selected="selected"';
			else
				$selected = "";
		?>
        <option <?php echo $selected; ?> value="<?php echo $rowColor['color_id']; ?>"><?php echo $rowColor['color_name']; ?></option>
        <?php } ?>
    </select></p>
    <p><label for="finish">Finish:</label><br /><input id="finish" name="finish" type="text" size="20" value="<?php echo htmlentities($row['finish']); ?>" /></p>
    <p><label for="depth">Depth:</label><br /><input id="depth" name="depth" type="text" size="5" value="<?php echo htmlentities($row['depth']); ?>" /> in.</p>
    <p><label for="width">Width:</label><br /><input id="width" name="width" type="text" size="5" value="<?php echo htmlentities($row['width']); ?>" /> in.</p>
    <p><label for="height">Height:</label><br /><input id="height" name="height" type="text" size="5" value="<?php echo htmlentities($row['height']); ?>" /> in.</p>
    <p><label for="surface">Surface Accomodation:</label><br /><input id="surface" name="surface" type="text" size="5" value="<?php echo htmlentities($row['surface']); ?>" /> in.</p>
    <p><label for="bracket">Bracket Accomodation:</label><br /><input id="bracket" name="bracket" type="text" size="5" value="<?php echo htmlentities($row['bracket']); ?>" /> in.</p>
    <p><label for="load_B">Load - Bracket:</label><br /><input id="load_B" name="load_B" type="text" size="5" value="<?php echo htmlentities($row['load_B']); ?>" /> lbs.</p>
    <p><label for="load_TS">Load - Top Surface:</label><br /><input id="load_TS" name="load_TS" type="text" size="5" value="<?php echo htmlentities($row['load_TS']); ?>" /> lbs.</p>
    <p><label for="load_S">Load - Shelves:</label><br /><input id="load_S" name="load_S" type="text" size="5" value="<?php echo htmlentities($row['load_S']); ?>" /> lbs.</p>
       
    
    <p>Links:</p>
    <?php 
	while ($rowLinks = mysql_fetch_assoc($resultLink)) { 
    	if(in_array($rowLinks['link_id'], $product_links)) {
			$checked = 'checked="checked" ';
		}else{
			$checked = '';
		}
		echo '<p><input name="link_'.$rowLinks['link_id'].'" '.$checked.'type="checkbox" value="'.$rowLinks['link_id'].'" />'.$rowLinks['link_name'].'</p>';
	} 
	?>
    <p>Available in Stores:</p>
    <?php 
	while ($rowStores = mysql_fetch_assoc($resultStores)) {
		if(in_array($rowStores['store_id'], $product_stores)) {
			$checked = 'checked="checked" ';
		}else{
			$checked = '';
		}
    	echo '<p><input name="store_'.$rowStores['store_id'].'" '.$checked.'type="checkbox" value="'.$rowStores['store_id'].'" /> '.$rowStores['store_name'].'</p>';
    } 
	
	for($i=1; $i<=8;$i++) {
		echo '<p><label for="description_0'.$i.'">Description 0'.$i.':</label><br /><textarea id="description_0'.$i.'" name="description_0'.$i.'" cols="40" rows="3">'.htmlentities($row['description_0'.$i]).'</textarea></p>';
	}
	?>
    <p><input type="submit" name="update" value="Update entry" /></p>
	<p><input name="product_id" type="hidden" value="<?php echo $row['product_id']; ?>" /></p>
</form>
<?php } ?>
<!-- END UPDATE FORM -->

<?php include ('includes/footer-private.php'); ?>