<?php $page = basename($_SERVER['SCRIPT_NAME']); ?>
<?php 

	/*ABOUT*/
	
	if ($page == 'about.php') {
	
	print' 	<li><a href="about-history.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'history\',\'\',\'images/subnavigation-history-on.gif\',1)"><img src="images/subnavigation-history-off.gif" alt="History" name="history" border="0" id="history" /></a></li>
        <li><a href="about-brands.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'brands\',\'\',\'images/subnavigation-brands-on.gif\',1)"><img src="images/subnavigation-brands-off.gif" alt="Brands" name="brands" border="0" id="brands" /></a></li>
        <li><a href="about-values.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'values\',\'\',\'images/subnavigation-values-on.gif\',1)"><img src="images/subnavigation-values-off.gif" alt="Values" name="values" border="0" id="values" /></a></li>
        <li><a href="about-contact.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'contact\',\'\',\'images/subnavigation-contact-on.gif\',1)"><img src="images/subnavigation-contact-off.gif" alt="Contact Us" name="contact" border="0" id="contact" /></a></li>';		
	}
		
	else {
	
		/*HISTORY*/
		
		if ($page == 'about-history.php') {
		
		print '<li><img src="images/subnavigation-history-on.gif" alt="History" name="history" border="0" id="history" /></li>';
		
		}
		
		else {
		
		print '<li><a href="about-history.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'history\',\'\',\'images/subnavigation-history-on.gif\',1)"><img src="images/subnavigation-history-off.gif" alt="History" name="history" border="0" id="history" /></a></li>';
		
		}
		
		/*BRANDS*/
		
		if ($page == 'about-brands.php') {
		
		print '<li><img src="images/subnavigation-brands-on.gif" alt="Brands" name="brands" border="0" id="brands" /></li>';
		
		}
		
		else {
		
		print '<li><a href="about-brands.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'brands\',\'\',\'images/subnavigation-brands-on.gif\',1)"><img src="images/subnavigation-brands-off.gif" alt="Brands" name="brands" border="0" id="brands" /></a></li>';
		
		}
		
		/*VALUES*/
		
		if ($page == 'about-values.php') {
		
		print '<li><img src="images/subnavigation-values-on.gif" alt="Values" name="values" border="0" id="values" /></li>';
		
		}
		
		else {
		
		print '<li><a href="about-values.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'values\',\'\',\'images/subnavigation-values-on.gif\',1)"><img src="images/subnavigation-values-off.gif" alt="Values" name="values" border="0" id="values" /></a></li>';
		
		}
		
		/*CONTACT*/
		
		if ($page == 'about-contact.php') {
		
		print '<li><img src="images/subnavigation-contact-on.gif" alt="Contact Us" name="contact" border="0" id="contact" /></li>';
		
		}
		
		else {
		
		print '<li><a href="about-contact.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'contact\',\'\',\'images/subnavigation-contact-on.gif\',1)"><img src="images/subnavigation-contact-off.gif" alt="Contact Us" name="contact" border="0" id="contact" /></a></li>';
		
		}
	
	}
		
?>