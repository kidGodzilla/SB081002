
<ul id="clientlogos">
<?php

// get number of viable brands
$sql = "SELECT DISTINCT(brand_id),brand_name,brand_file FROM sb_products as a LEFT OUTER JOIN sb_brands as b ON a.brand=b.brand_id ORDER BY brand_id ASC"; // we only want to get brands with products (brands with no products don't have any reason to be here)
$res = mysql_query($sql) or die (mysql_error());
while($r=mysql_fetch_array($res)){
	// get the first product ID for this brand
	$sql = "SELECT MIN(product_id) FROM sb_products WHERE brand=".$r['brand_id'];
	$result = mysql_query($sql) or die (mysql_error());
	$product_id = mysql_result($result,0);
	echo '<li>';
	echo '<a href="products-catalog.php?product_id='.$product_id.'">';
	echo '<img src="brands/'.$r['brand_file'].'" alt="'.$r['brand_name'].'" />';
	echo '</a>';
	echo '</li>';
}
?>
</ul>