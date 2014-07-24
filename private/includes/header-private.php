<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Slam Brands - Private</title>
<link rel="stylesheet" href="private.css" type="text/css" media="all" />


<!-- Begin JavaScript -->
<script src="../scripts/popUp.js" type="text/javascript"></script>
<!-- End JavaScript -->

</head>
<body>

<!-- START HEADER -->
<div id="header">
    <h1 id="logo"><a href="index.php"><img src="images/logo-private.gif" /></a></h1>
    <?php
		if(isset($_SESSION['susername'])) {
			echo '<p id="who">You are logged in as <b><a href="user-update.php">'.$_SESSION['susername'].'</a></b> | <small><a href="logout.php">LOGOUT</a></small></p>';
		}
	?>
    <br class="clear" />
</div>
<!-- END HEADER -->  
    
<!-- Begin Navigation -->
<?php 
	if(isset($_SESSION['susername'])) {
	include ('navigation-private.php');		
	}
?>
    
<!-- End Navigation -->

<!-- START MIDDLE -->
<div id="middle">