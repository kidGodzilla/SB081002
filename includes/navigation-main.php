<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>
<?php 

	/*INDEX*/
	
	if ($page == 'index.php') {
	
	print'<li><a href="products.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'products\',\'\',\'images/navigation-products-on.gif\',1)"><img src="images/navigation-products-off.gif" alt="Products" name="products" border="0" id="products" /></a></li>
    	<li><a href="support.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'support\',\'\',\'images/navigation-support-on.gif\',1)"><img src="images/navigation-support-off.gif" alt="Support" name="support" border="0" id="support" /></a></li>
        <li><a href="about-history.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'aboutus\',\'\',\'images/navigation-aboutus-on.gif\',1)"><img src="images/navigation-aboutus-off.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>
        <li><a href="careers.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'careers\',\'\',\'images/navigation-careers-on.gif\',1)"><img src="images/navigation-careers-off.gif" alt="Careers" name="careers" border="0" id="careers" /></a></li>';		
	}
		
	else {
	
		/*PRODUCTS*/
		
		if ($page == 'products.php') {
		
		print '<li><a href="products.php"><img src="images/navigation-products-on.gif" alt="Products" name="products" border="0" id="products" /></a></li>';
		
		}
		
		elseif ($page == 'products-found.php') {
		
		print '<li><a href="products.php"><img src="images/navigation-products-on.gif" alt="Products" name="products" border="0" id="products" /></a></li>';
		
		}
		
		elseif ($page == 'products-catalog.php') {
		
		print '<li><a href="products.php"><img src="images/navigation-products-on.gif" alt="Products" name="products" border="0" id="products" /></a></li>';
		
		}
		
		elseif ($page == 'products-results.php') {
		
		print '<li><a href="products.php"><img src="images/navigation-products-on.gif" alt="Products" name="products" border="0" id="products" /></a></li>';
		
		}
		
		else {
		
		print '<li><a href="products.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'products\',\'\',\'images/navigation-products-on.gif\',1)"><img src="images/navigation-products-off.gif" alt="Products" name="products" border="0" id="products" /></a></li>';
		
		}
		
		/*SUPPORT*/
		
		if ($page == 'support.php') {
		
		print '<li><a href="support.php"><img src="images/navigation-support-on.gif" alt="Support" name="support" border="0" id="support" /></a></li>';
		
		}
		
		else {
		
		print '<li><a href="support.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'support\',\'\',\'images/navigation-support-on.gif\',1)"><img src="images/navigation-support-off.gif" alt="Support" name="support" border="0" id="support" /></a></li>';
		
		}
		
		/*ABOUT*/
		
		if ($page == 'about-history.php') {
		
		print '<li><a href="about-history.php"><img src="images/navigation-aboutus-on.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>';
		
		}
		
		elseif ($page == 'about-brands.php') {
		
		print '<li><a href="about-history.php"><img src="images/navigation-aboutus-on.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>';
		
		}
		
		elseif ($page == 'about-contact.php') {
		
		print '<li><a href="about-history.php"><img src="images/navigation-aboutus-on.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>';
		
		}
		
		elseif ($page == 'about-values.php') {
		
		print '<li><a href="about-history.php"><img src="images/navigation-aboutus-on.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>';
		
		}
		
		else {
		
		print '<li><a href="about-history.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'aboutus\',\'\',\'images/navigation-aboutus-on.gif\',1)"><img src="images/navigation-aboutus-off.gif" alt="About Us" name="aboutus" border="0" id="aboutus" /></a></li>';
		
		}
		
		/*CAREERS*/
		
		if ($page == 'careers.php') {
		
		print '<li><a href="careers.php"><img src="images/navigation-careers-on.gif" alt="Careers" name="careers" border="0" id="careers" /></a></li>';
		
		}
		
		elseif ($page == 'careers-results.php') {
		
		print '<li><a href="careers.php"><img src="images/navigation-careers-on.gif" alt="Careers" name="careers" border="0" id="careers" /></a></li>';
		
		}
		
		else {
		
		print '<li><a href="careers.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'careers\',\'\',\'images/navigation-careers-on.gif\',1)"><img src="images/navigation-careers-off.gif" alt="Careers" name="careers" border="0" id="careers" /></a></li>';
		
		}
	
	}
		
?>