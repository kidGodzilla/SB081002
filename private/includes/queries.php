<?php
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sqlProduct = 'SELECT * FROM sb_products ORDER BY title';
$sqlCategory = 'SELECT * FROM sb_categories ORDER BY category_id';
$sqlMaterial = 'SELECT * FROM sb_materials ORDER BY material_id';
$sqlBrand = 'SELECT * FROM sb_brands ORDER BY brand_id';
$sqlLogo = 'SELECT * FROM sb_brands ORDER BY brand_id';
// submit the query and capture the result
$resultProduct = mysql_query($sqlProduct) or die(mysql_error());
$resultCategory = mysql_query($sqlCategory) or die(mysql_error());
$resultMaterial = mysql_query($sqlMaterial) or die(mysql_error());
$resultBrand = mysql_query($sqlBrand) or die(mysql_error());
$resultLogo = mysql_query($sqlLogo) or die(mysql_error());
// find out how many records were retrieved
$numRowsProduct = mysql_num_rows($resultProduct);
$numRowsCategory = mysql_num_rows($resultCategory);
$numRowsMaterial = mysql_num_rows($resultMaterial);
$numRowsBrand = mysql_num_rows($resultBrand);
$numRowsLogo = mysql_num_rows($resultLogo);
?>