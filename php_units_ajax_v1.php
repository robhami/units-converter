<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);



	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
	');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
		
	}

	$error = "";
	$units_from='Klbs';
	$units_to='Klbs';
	$value=0;
	$units_cat='Mass';

#Connect and echo if working
	
	$link = mysqli_connect("shareddb-g.hosting.stackcp.net","units-2019-373172b1", "Booboo111", "units-2019-373172b1");
	
	if (mysqli_connect_error()) {	
		die ("Database error");	
		} else {
			
			$error = "Database working";
		}

		
	echo $error;
	if(isset($_POST["units_cat"])){
		$units_cat=($_POST["units_cat"]);
		}else
		{
			$_POST["units_cat"]="Mass";
		}
	
	if(isset($_POST["units_from"])){
		$units_from=mysqli_real_escape_string($link,$_POST["units_from"]);
		}else
		{
			$_POST["units_from"]="Klbs";
		
		}
	if(isset($_POST["units_to"])){
		$units_to=mysqli_real_escape_string($link,$_POST["units_to"]);
		}else
		{
			$_POST["units_to"]="Klbs";
		}
		
	if(isset($_POST["value"])){
		$value=mysqli_real_escape_string($link,(int)$_POST["value"]);
		}else
		{
			$_POST["value"]=0;	
		}
		
	# Describe table for selected units, to get column values, need to whitelist tables
	$query2=("DESCRIBE ".($units_cat));
	
	if ($result2 = mysqli_query($link, $query2)) {
		$table_desc = mysqli_fetch_all($result2);
		$rowcount=mysqli_num_rows ($result2);
	
	#Create an array of column values	
		foreach($table_desc as $val) {	
			$col[]=$val[0];	
		}
			
	#debug to check create column array worked and show output		
		echo "<br>";
		echo "COLUMNS ARRAY";
		echo "<br>";
		print_r($col);	
		echo "<br>";	
		#print_r($col[2]);		
	
			
		} else {	
			echo nl2br(" \n Query failed");
		}
	
	
	$units_cat=$_POST['units_cat'];
		echo nl2br (" \n Units_Cat: ".$units_cat);

		
	$units_to=$_POST['units_to'];
		echo nl2br (" \n Units_To: ".$units_to);

?>