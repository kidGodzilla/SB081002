<?php
	
	#**********************************************
	# Multiple File Upload
	#**********************************************
	
	#**********************************************
	# Change history
	# ==============
	# 10/10/2007 - WebDevBoost.co.uk
	#
	#**********************************************
	# Description
	# ===========
	# The script is designed to allow you to upload multiple files in one go, the script also presents you with the variable option
	# of keeping a files name or randomly renaming it.
	# Remember, there maybe a a upload limit set by the server of 2MB, you can change this by changing the php.ini if you have access
	#**************************************************************************************************


	###/ VARIABLES - CHANGE ACCORDINGLY
	define("VAR_BASE_DIRECTORY",	"../uploads/"); 				#/ Your webhosting directory
	define("VAR_UPLOAD_FOLDER",		"../uploads/"); 				#/ Chmod directory 777 for successful upload
	define("VAR_UPLOAD_DIRECTORY",	VAR_BASE_DIRECTORY.VAR_UPLOAD_FOLDER); 		#/ DO NOT EDIT
	define("VAR_UPLOAD_FIELDS",		5); 										#/ Set number of upload fields
	define("VAR_FILENAME_KEEP",		0);											#/ If set to 0 (Zero) the filename will generate randomly, if 1 (One) it will maintain filename


	##/ Function that displays forms and is called by default
	function defaultForm()
	{
		
		echo "<form method=\"post\" enctype=\"multipart/form-data\">\n";
			
			for($i=0; $i < VAR_UPLOAD_FIELDS; $i++)
			{        
				  echo "Upload field ".$i." &nbsp;<input name=\"file[]\" type=\"file\" id=\"file[]\" /><br />\n";
			}
			
		echo "<input name=\"Submit\" type=\"submit\" value=\"Submit\">\n";
		echo "<input name=\"filter\" type=\"hidden\" value=\"processForm\">\n";		##/ hidden value points the switch to processing
		echo "</form>\n";
		
		return;
		
	}
	#/ End of defaultForm

	##/ Function that displays forms and is called by default
	function processForm()
	{
			
		for($i=0; $i < VAR_UPLOAD_FIELDS; $i++)
		{
			echo "Upload field $i ";

			if(!empty($_FILES[file][size][$i])) 
			{ 
				if(VAR_FILENAME_KEEP==1)
				{
					##/ File maintaining upload name
					$fileName	 = $_FILES[file][name][$i];
				}
				else
				{
					##/ Filename randomized
					$fileName	 = rand(1,4000).rand(1,4000).rand(1,4000).rand(1,4000).rand(1,4000).'.' . substr($_FILES[file][name][$i], -3);
				}
				
				##/ Creating reference address 
				$newLocation	 = VAR_UPLOAD_DIRECTORY.$fileName;
				
				if(!copy($_FILES[file][tmp_name][$i],$newLocation)) 
				{
					echo "<b>Failed - ".$_FILES[file][name][$i]." would not copy to ".$newLocation."</b> (Check your upload directory and permissions)";
				}
				else
				{
					###/ SUCCESS /###
					
					#/ Stripping of VAR_BASE_DIRECTORY for better viewing and linking
					$urlShow = str_replace(VAR_BASE_DIRECTORY,'',$newLocation); 
					
					echo "<b>Uploaded successfully - <a href=\"$urlShow\" target=\"_blank\">$urlShow</a></b>";
				}
			} 
			else
			{
				echo "<b>No file uploaded</b>";
			}
			echo "<br />";
		}
		return;
	}
	#/ End of processForm
	

    ##/ This object handles which function the application should call
	switch($_POST[filter]) {
		case "processForm":
			processForm();
		break;
		default:
			defaultForm();
		break;
	}
	#/ End of Handling

?>