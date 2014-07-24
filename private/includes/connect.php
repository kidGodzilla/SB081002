<?php
function dbConnect($type) {
  if ($type  == 'query') {
    $user = 'msinkula';
	$pwd = 'mds0812';
	}
  elseif ($type == 'admin') {
    $user = 'msinkula';
	$pwd = 'mds0812';
	}
  else {
    exit('Unrecognized connection type');
	}
  $conn = mysql_connect('mysql.premiumdw.com', $user, $pwd) or die ('Cannot connect to server');
  mysql_select_db('msinkula_premiumdw_db2') or die ('Cannot open database');
  return $conn;
  }
?>