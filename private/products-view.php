<?php
include('includes/session.php');
include('includes/connect.php');
include('includes/corefuncs.php');

// connect to MySQL
$conn = dbConnect('query');

// prepare the SQL query
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_id';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_id';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_id';
$sqlColor = 'SELECT * FROM sb_colors ORDER BY color_id';

// submit the query and capture the result
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
$resultColor = mysql_query($sqlColor) or die(mysql_error());

// find out how many records were retrieved
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
$numRowsColor = mysql_num_rows($resultColor);


// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('filename_one', 'filename_two','filename_three', 'filename_four', 'title', 'category', 'material', 'brand', 'store', 'color', 'finish', 'depth', 'width', 'height', 'surface', 'bracket', 'load_B', 'load_TS', 'load_S', 'description');
// get details of selected record
if ($_GET && !$_POST) {
	if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
		$product_id = $_GET['product_id'];
	} else {
		$product_id = NULL;
	}
	if ($product_id) {
		$sql = "SELECT * FROM sb_products as a LEFT OUTER JOIN sb_brands as b ON a.brand=b.brand_id WHERE product_id = $product_id";
		$result = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_assoc($result);
		
		$sql = 'SELECT DISTINCT(link_name),link_file FROM sb_productLinks as a LEFT OUTER JOIN sb_links as b ON a.link_id=b.link_id WHERE product_id="'.$product_id.'" ORDER BY link_name ASC';
		$resultLinks = mysql_query($sql) or die (mysql_error());
		
		$sql = 'SELECT DISTINCT(store_name),store_file FROM sb_productStores as a LEFT OUTER JOIN sb_stores as b ON a.store_id=b.store_id WHERE product_id="'.$product_id.'" ORDER BY store_name ASC';
		$resultMyStores = mysql_query($sql) or die (mysql_error());
	}
}
  
  
?>
<?php include('includes/header-private.php'); ?>
	
<?php if (empty($row)) { ?>
   <p class="warning">Invalid request: record does not exist.</p>
   <?php } 
   else { ?>
   <!-- START POO -->
   <div id="product-poo">
   		<?php
		echo '<p><img src="../brands/'.$row['brand_file'].'" /></p><br />';
        if($row['filename_pdf']!='') {   
         echo '<p id="assembly-icon"><img src="../images/icon-pdf.gif" alt="Abobe PDF" /></p>';
         echo '<p id="assembly-text"><a href="../downloads/'.$row['filename_pdf'].'">Assembly Instructions</a></p><br />';
        }
		if(mysql_num_rows($resultMyStores) > 0) { // Do not show if there is no data
			echo '<p>Available at:</p>';
			while ($r = mysql_fetch_assoc($resultMyStores)) { 
				echo '<p><img src="../stores/'.$r['store_file'].'" alt="'.$r['store_name'].'" /></p>';
			} 
		}
		?>
         
   </div>
   <!-- END POO -->
    
   <!-- START PRODUCT OPTIONS -->
   <div id="product-options">
        <p><small><?php while ($rowColor = mysql_fetch_assoc($resultColor)) { 
        $color = $rowColor['color_file'];
        if( $rowColor['color_id'] == $row['color']) {
            echo "<img src=\"../colors/$color\" /><br />";
            }
        } ?></small></p>
        <p><b><?php echo htmlentities($row['finish']); ?></b><p>
        <?php if (!empty($row['surface'])) { // Do not show if there is no data ?>
        <p id="product-options-stand"><?php echo htmlentities($row['surface']); ?>in.<p>
        <?php } else { }?>
        
        <?php if (!empty($row['bracket'])) { // Do not show if there is no data ?>
        <p id="product-options-bracket"><?php echo htmlentities($row['bracket']); ?>in.<p>
        <?php } else { }?>
        
        <p><small><b>Maximum Load Weights:</b></small></p>
        <?php if (!empty($row['load_B'])) { // Do not show if there is no data ?>
        <p><small>Bracket: <?php echo htmlentities($row['load_B']); ?> lbs.</small><br />
        <?php } else { }?>
        <?php if (!empty($row['load_TS'])) { // Do not show if there is no data ?>
        <small>Top Surface: <?php echo htmlentities($row['load_TS']); ?> lbs.</small><br />
        <?php } else { }?>
        <?php if (!empty($row['load_S'])) { // Do not show if there is no data ?>
        <small>Shelves:  <?php echo htmlentities($row['load_S']); ?> lbs.</small></p>
        <?php } else { }?>
         
   </div>
   <!-- END PRODUCT OPTIONS -->
    
   <!-- START PRODUCT DESCRIPTION -->
   <div id="product-description">
        <h2><?php echo htmlentities($row['title']); ?></h2>
        <ul>
        <li><b><?php echo htmlentities($row['depth']); ?>in.(D) x <?php echo htmlentities($row['width']); ?>in.(W) x <?php echo htmlentities($row['height']); ?>in.(H)</b></li>
  		<!-- START TEXT DESCRIPTION -->
        <?php 
		
		for($i=1; $i<=8;$i++) {
			if (!empty($row['description_0'.$i])) { // Do not show if there is no data
				echo  '<li>'.htmlentities($row['description_0'.$i]).'</li>';
			}
		}
        // START LINK DESCRIPTION
        while ($r = mysql_fetch_assoc($resultLinks)) { 
			echo '<li><a href="../links/img.php?src='.$r['link_file'].'" class="popup">'.$r['link_name'].'</a></li>';
		} 
		?>     
        </ul>
    </div>
    <!-- END PRODUCT DESCRIPTION -->
     
    <!-- START PRODUCT IMAGES -->
    <div id="product-images">
        <p class="product-images-main"><img src="../uploads/<?php echo htmlentities($row['filename_one']); ?>" id="slides" /></p>
        <ul>	
            <?php if (!empty($row['filename_one'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_one']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_one']); ?>" /></a></li>
            <?php } else { }?>
            	
            <?php if (!empty($row['filename_two'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_two']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_two']); ?>" /></a></li>	
            <?php } else { }?>
            
            <?php if (!empty($row['filename_three'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_three']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_three']); ?>" /></a></li>
            <?php } else { }?>
            
            <?php if (!empty($row['filename_four'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_four']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_four']); ?>" /></a></li>	
            <?php } else { }?>
            
            <?php if (!empty($row['filename_five'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_five']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_five']); ?>" /></a></li>
            <?php } else { }?>
            
            <?php if (!empty($row['filename_six'])) { // Do not show if there is no data ?>
            <li class="product-images-small"><a href="#" onclick="document.getElementById('slides').src='../uploads/<?php echo htmlentities($row['filename_six']); ?>';"><img src="../uploads/<?php echo htmlentities($row['filename_six']); ?>" /></a></li>
            <?php } else { }?>
        </ul>
        
    </div>
    <!-- END PRODUCT IMAGES -->
<?php } ?>
	
    <!-- START VIEW POO -->
    <div id="product-view-poo"  class="clear">
    <p><small><a href="products-update.php?product_id=<?php echo $row['product_id']; ?>">EDIT</a>&nbsp;&Iota;&nbsp;<a href="products-delete.php?product_id=<?php echo $row['product_id']; ?>">DELETE</a></small></p>
    </div>
    <!-- END VIEW POO -->

<?php include('includes/footer-private.php'); ?>