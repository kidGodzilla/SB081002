<?php
function nukeMagicQuotes() {
  if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value) {
      $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
      return $value;
      }
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  }
}
function mailTo($frmEmail,$usrEmail,$subject,$message,$redirect){
	// Begin Header information
	//$eol = "\x0d\x0a";
	$headers = '';
//		$headers .= "X-Mailer: AtomMailer" . "\x0d\x0a";
	$headers .= "From: \"Slam Brands\" <".$frmEmail.">\x0d\x0a";
	$headers .= "Reply-To: \"Slam Brands\" <".$frmEmail.">\x0d\x0a";
	$headers .= "Return-Path: \"Slam Brands\" <".$frmEmail.">\x0d\x0a";
	$headers .= "Message-ID: <".time()." admin@".$_SERVER['SERVER_NAME'].">\x0d\x0a";
	$headers .= "MIME-Version: 1.0" . "\x0d\x0a";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\x0d\x0a";
	$headers .= "Content-Type: text/html; charset=UTF-8\x0d\x0a";
	$headers .= "X-Priority: 3\x0d\x0a";
	$headers .= "X-MSMail-Priority: Normal\x0d\x0a";
	$headers .= "X-Mailer: PHP v".phpversion()."\x0d\x0a"; // These two to help avoid spam-filters
	//$headers .= "To: " . $recipient . "\n";
	mail($usrEmail, $subject, $message, $headers);
	if($redirect)	header("Location: ".$redirect);
}
?>