<?php
include('private/includes/connect.php');
include('private/includes/queries.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sqlCareer = 'SELECT * FROM sb_careers ORDER BY created DESC';
// submit the query and capture the result
$resultCareer = mysql_query($sqlCareer) or die(mysql_error());
// find out how many records were retrieved
$numRows = mysql_num_rows($resultCareer);
?>
<?php include('includes/header-main.php'); ?>

	<!-- START LOGOS -->
    <div id="logos">
    	<?php include('includes/clientlogos-main.php'); ?>
	</div>
    <!-- END LOGOS -->
    
    <!-- START SUBNAVIGATION -->
    <ul id="subnavigation">
   		&nbsp;
    </ul>
	<!-- END SUBNAVIGATION -->
    
    <!-- START CONTENT -->
    <div id="content">
    	
    	<div id="content-left">            
			<div id="content-left-box">
                <h2>Current Job Openings</h2>
                <div id="careers-text">
                	<?php while ($therow = mysql_fetch_assoc($resultCareer)) { ?>
                	<p><a href="careers-results.php?career_id=<?php echo $therow['career_id']; ?>"><?php echo htmlentities($therow['title']); ?><br /><?php echo htmlentities($therow['location']); ?></p>
                    <?php } ?>
            	</div>
            </div>
            
            <img id="icon-pdf" src="images/icon-pdf.gif" alt="Abobe PDF" />
            <p class="about-caption"><a href="downloads/SlamBrands_USBenefits_2008.pdf">Download our Comprehensive Benefits Package</a></p>
      </div>
    	
        <div id="content-right">
        	<p>Slam Brands is a leading designer and importer of audio/video furniture servicing the nation’s largest national retail chains. Our current customers include Wal-Mart, Target, Costco, Best Buy, Circuit City, JCPenney, and a host of regional and online retailers. Driven by innovative, research-focused design processes, unmatched program management capabilities, and in-depth manufacturing expertise, the Company has achieved tremendous growth and quickly gained market share in the $3B ready-to-assemble furniture market.</p>
			<p>Our success is rooted in our energetic, innovative, and consumer driven approach coupled with a wide range of best-of-breed operational capabilities. We work in a very fast paced, dynamic environment that is results focused. We offer competitive compensation packages, performance-based bonus incentives, comprehensive benefits and a work environment that fosters integrity, mutual respect and professional growth. If you are an experienced professional seeking to join a dynamic organization, we would like to hear from you!</p>
        </div>
		
	</div>
    <!-- END CONTENT -->

<?php include('includes/footer-main.php'); ?>