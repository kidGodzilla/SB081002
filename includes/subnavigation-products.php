<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>
<?php 

	/*CATALOG*/
	
	if ($page == 'products-catalog.php') {
	
		print' <li><img src="images/subnavigation-products-on.gif" alt="Product Catalog" name="prodme" width="61" height="28" border="0" id="prodme" /></li>';
	
	}
	
	else {
	
		print' <li><a href="products-catalog.php?product_id=135" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'prodme\',\'\',\'images/subnavigation-products-on.gif\',1)"><img src="images/subnavigation-products-off.gif" alt="Product Catalog" name="prodme" width="61" height="28" border="0" id="prodme" /></a></li>';
	
	}
	
?>