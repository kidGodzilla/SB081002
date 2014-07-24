<h2>Product Search</h2>
<div id="products-search">
<form id="products-search-name" action="products-found.php" method="get" name="products-search-name">
<p><label for="product_id">By Product Name</label><br />
<span class="select-box">
<select name="product_id" id="product_id">
    <?php while ($rowProduct = mysql_fetch_assoc($resultProduct)) { ?>
    <option value="<?php echo $rowProduct['product_id']; ?>"><?php echo $rowProduct['title']; ?></option>
    <?php } ?>
</select></span><input id="goIE" name="submit" type="submit" value="Go" /></p>
</form>

<form id="products-search-details" action="products-results.php" method="get" name="products-search-details">
<p><label>Or By Product Details:</label></p>
<p><label for="category_id">Product Category</label><br />
<span class="select-box">
<select name="category_id" id="category_id">
    <option value="0">Any</option>
    <?php while ($rowCategory = mysql_fetch_assoc($resultCategory)) { ?>
    <option value="<?php echo $rowCategory['category_id']; ?>"><?php echo $rowCategory['category_name']; ?></option>
    <?php } ?>
</select></span></p>
<p><label for="material_id">Product Material</label><br />
<span class="select-box">
<select name="material_id" id="material_id">
  <option value="0">Any</option>
    <?php while ($rowMaterial = mysql_fetch_assoc($resultMaterial)) { ?>
    <option value="<?php echo $rowMaterial['material_id']; ?>"><?php echo $rowMaterial['material_name']; ?></option>
    <?php } ?>
</select></span></p>
<p><label for="brand_id">Product Brand</label><br />
<span class="select-box">
<select name="brand_id" id="brand_id">
  <option value="0">Any</option>
    <?php 
	
	// Reset Our Pointer.
	mysql_data_seek($resultBrand, 0);
	while ($rowBrand = mysql_fetch_assoc($resultBrand)) { 
	?>
    <option value="<?php echo $rowBrand['brand_id']; ?>"><?php echo $rowBrand['brand_name']; ?></option>
    <?php } ?>
</select><input name="submit" type="submit" value="Go" /></span></p>
</form>
</div>

<script type="text/javascript" src="http://us.js2.yimg.com/us.js.yimg.com/lib/common/utils/2/yahoo_2.0.0-b3.js"></script>
<script type="text/javascript" src="http://us.js2.yimg.com/us.js.yimg.com/lib/common/utils/2/event_2.0.0-b3.js" ></script>
<script type="text/javascript" src="http://us.js2.yimg.com/us.js.yimg.com/lib/common/utils/2/dom_2.0.2-b3.js" ></script>
<script type="text/javascript" src="scripts/ie-select-width-fix.js" ></script>

<script>

var s1 = new YAHOO.Hack.FixIESelectWidth( 'product_id', 'goIE' );
var s2 = new YAHOO.Hack.FixIESelectWidth( 'category_id' );
var s3 = new YAHOO.Hack.FixIESelectWidth( 'material_id' );

</script>