<?php
include('private/includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');

$expected = array('category_id', 'material_id', 'brand_id');
// if form has been submitted, update record
if (array_key_exists('submit', $_POST)) {
  // prepare expected items for insertion in to database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
    }
  }
}

$brandQuery = "";
$categoryQuery = "";
$materialQuery = "";
$error = 1;
if($brand_id && $brand_id!='') {
	$error = 0;
 	$brandQuery = " brand='$brand_id'";
}
if($category_id && $category_id!='') {
	$error = 0;
 	$categoryQuery = " category='$category_id'";
}
if($material_id && $material_id!='') {
	$error = 0;
 	$materialQuery = " material='$material_id'";
}

$where = $brandQuery;
if($where!="" && $categoryQuery!="")	$where .= " AND "; // only add the AND if there was a brand set too
$where .= $categoryQuery;
if($where!="" && $materialQuery!="")	$where .= " AND "; // only add the AND if there was a brand or category first
$where .= $materialQuery;

if($error)	$where = ""; // just select all
else		$where = "WHERE ".$where;

// prepare the SQL query
$sql = "SELECT * FROM sb_products $where ORDER BY title";
//echo $sql;
$sqlProduct = 'SELECT * FROM sb_products ORDER BY title';
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_id';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_id';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_id';
// submit the query and capture the result
$result = mysql_query($sql) or die(mysql_error());
$resultProduct = mysql_query($sqlProduct) or die(mysql_error());
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($result);	
$numRowsProduct = mysql_num_rows($resultProduct);
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
?>
<?php include('includes/header-main.php'); ?>

	<!-- START LOGOS -->
    <div id="logos">
    	<?php include('includes/clientlogos-main.php'); ?>
	</div>
    <!-- END LOGOS -->
    
    <!-- START SUBNAVIGATION -->
    <ul id="subnavigation">
   		<?php include ('includes/subnavigation-products.php'); ?>
    </ul>
<!-- END SUBNAVIGATION -->
    
    <!-- START CONTENT -->
    <div id="content">
    
    	<!-- Begin Left -->
    	<div id="content-left">
        	<div id="content-left-box">
                <?php include('includes/product-search.php'); ?>
            </div>
        </div>
       	<!-- End Left -->
        
    	<!-- Begin Right -->
        <div id="content-right">
        	<p>A total of <b><?php echo $numRows; ?></b> records were found.</p>
            <?php while ($row = mysql_fetch_assoc($result)) { ?>
            <div class="product-list">
            <a href="products-found.php?product_id=<?php echo $row['product_id']; ?>"><img src="uploads/<?php echo htmlentities($row['filename_one']); ?>" alt="<?php echo $row['title']; ?>" border="0" /></a>
            <h2><a href="products-found.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['title']; ?></a></h2>
            <p><a href="products-found.php?product_id=<?php echo $row['product_id']; ?>"><?php echo $row['description']; ?></a></p>
            </div>
            <?php } ?>
        </div>
		<!-- End Right -->
        
	</div>
    <!-- END CONTENT -->

<?php include('includes/footer-main.php'); ?>