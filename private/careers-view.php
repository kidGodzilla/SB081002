<?php
include('includes/connect.php');
include('includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('title', 'description', 'qualification_01', 'qualification_02', 'qualification_03', 'qualification_04', 'qualification_05', 'qualification_06', 'mailto', 'career_id');
 // create database connection
$conn = dbConnect('query');
// get details of selected record
if ($_GET && !$_POST) {
  if (isset($_GET['career_id']) && is_numeric($_GET['career_id'])) {
    $career_id = $_GET['career_id'];
	}
  else {
    $career_id = NULL;
	}
  if ($career_id) {
	$sql = "SELECT * FROM sb_careers WHERE career_id = $career_id";
	$result = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_assoc($result);
	}
  }
// prepare the SQL query for the "job openings" box
$sqlCareer = 'SELECT * FROM sb_careers ORDER BY created DESC';
// submit the query and capture the result
$resultCareer = mysql_query($sqlCareer) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($resultCareer);
?>
<?php include('includes/header-private.php'); ?>

	<!-- START LOGOS -->
    <div id="logos">
    	&nbsp;
	</div>
    <!-- END LOGOS -->
    
    <!-- START SUBNAVIGATION -->
    <ul id="subnavigation">
   		&nbsp;
    </ul>
	<!-- END SUBNAVIGATION -->
    
    <!-- START CONTENT -->
    <div id="content">
        <?php if (empty($row)) { ?>
        	<p class="warning">Invalid request: record does not exist.</p>
        <?php } 
        else { ?>
        	<p><?php echo htmlentities($row['title']); ?><br /><?php echo htmlentities($row['location']); ?></p>
            <p><?php echo htmlentities($row['description']); ?></p>
            <p>Ideal candidates will have the following:</p>
            <ul>
            <?php
				for($i=1;$i<=10;$i++){
					$num = sprintf("%02d",$i);
					echo '<li>'.htmlentities($row['qualification_'.$num]).'</li>';
				}
			?>
            </ul>
            <p>HOW TO APPLY:</p>
            <p>To submit your application by email, please paste your Cover Letter and Resume into the body of the email and send to <a href="mailto:<?php echo htmlentities($row['mailto']); ?>@hiredesk.net"><?php echo htmlentities($row['mailto']); ?>@hiredesk.net</a>.</p>
            <?php } ?>		
	</div>
    <!-- END CONTENT -->

<?php include('includes/footer-private.php'); ?>