<?php
include('private/includes/connect.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sqlProduct = 'SELECT * FROM sb_products ORDER BY title';
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_id';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_id';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_id';
// submit the query and capture the result
$resultProduct = mysql_query($sqlProduct) or die(mysql_error());
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());

// find out how many records were retrieved
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
			<p>Slam Brands recogizes that the Company’s continued success is based on its ability to consistantly deliver exceptionally designed, high-value products. Innovative, functional designs are the key to the Company’s retail success. Accordingly, Slam Brands has instituted a tightly controlled, research oriented product development process supported by a team of talented design and product development professionals. As of the end of 2007, Slam Brands has developed over 500 products across multiple brands, materials and price points.</p> 
			<p>We take great pride in the design, quality and value of our products. All new products are meticulously developed from the ground up with specific consideration given to each and every component. The result is unparalleled product aesthetics and funtionality.</p>
			<p>Please browse our product catalog. We have included only those products currently available in retail stores or online so as not to disappoint. If you should have any problems finding our products in your area, please contact us and we will do everything we can to help with your search.</p>
        </div>
		<!-- End Right -->
        
	</div>
    <!-- END CONTENT -->

<?php include('includes/footer-main.php'); ?>