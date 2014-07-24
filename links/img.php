<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Link</title>
<style>
body, img{
	padding:0;
	margin:0;
	border:0;
}
</style>
</head>

<body>
<?php

if($_GET['src'])	
	echo '<img src="'.stripslashes(strip_tags($_GET['src'])).'" />';

?>
</body>
</html>
