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

$dbname = 'units-2019-373172b1';

	#connect and echo if working, NEED to add DIE
	
	$link = mysqli_connect("shareddb-g.hosting.stackcp.net","units-2019-373172b1", "Booboo111", "units-2019-373172b1");
	
	if (mysqli_connect_error()) {	
		die ("Database error");	
		} else {
			
			$error = "Database working";
		}
	#echo $error;
	
	#set variables from POSTs add default values if not set
	if(isset($_POST["units_cat"])){
		$units_cat=($_POST["units_cat"]);
		$units_from=mysqli_real_escape_string($link,$_POST["units_from"]);
		
		
		
		
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
	
	
	
	# select table row from SQL that matches '$units_cat' and '$units_from' selected in dropdown
	# can't prepare and bind from table, need to white-list tables
	
	$query= $link->prepare("SELECT * FROM ".mysqli_real_escape_string($link, $units_cat)." WHERE from_value = ?");
	$query->bind_param("s", $units_from);
	$query->execute();
	echo "<br>";
	
	# if query works assign array to $row variable, can't use mysqli_query with prepared statement
	if ($result = $query->get_result()) {
		#echo nl2br (" \n ARRAY FOR CONVERSION FACTORS");
		$row = mysqli_fetch_array($result);
	
	}
	
	# Describe table for selected units, to get column values
	$query2=("DESCRIBE ".mysqli_real_escape_string($link, $units_cat));
	
	
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
	# debug output to show array selected, if query worked, conversion factor
			
	} else {	
		echo nl2br(" \n Query failed");
	}
	
	# select conversion factor from called array 
	$conversion=$row["$units_to"];
	
	# debug output to show conversion factor
	echo "<br>";
	echo "<br>Conversion factor: ";
	print_r ($conversion);
	echo "<br>";
	
	# get answer
	$answer = ($value * $conversion);
	# debug answer
	#echo($answer);
#Get tables list for whitelisting
	$query3="Show tables";
	$result3=mysqli_query($link,$query3);
	
	if (!$result3) {
		echo "DB Error, could not list tables\n";
		echo 'MySQL Error: ' . mysqli_error();
		exit;
	}
	
	if ($result3=mysqli_query($link,$query3)){
		while($row=mysqli_fetch_row($result3)){
			
			$tables[]=$row[0];
		
		}
	}		
		echo "<br>";
		echo "Tables: ";
		print_r($tables);
		
	#UNITS CAT WHITELIST CHECK	
	if (in_array($units_cat,$tables)){
		
		echo nl2br (" \n Units Cat Table exists");
		
	}else{
	
		echo "Table does not exist";
		mysqli_close($link);
		echo "<br>";
		die("non valid entry");
	}
	
	echo "<br>";
	echo "Units from: ";
	print_r($units_from);
	
	#UNITS FROM WHITELIST CHECK	
	if (in_array($units_from,$col)){
		
		echo nl2br ("\n Units from Table exists");
		
	}else{
	
		echo nl2br ("\n Units FROM Table does not exist");
		#print_r($tables);
		
	
	}	
	
	#UNITS FROM WHITELIST CHECK	
	if (in_array($units_to,$col)){
		
		echo "Units to Table exists";
		
	}else{
	
		echo nl2br (" \n Units TO Table does not exist");
		#mysqli_close($link);
		#echo "<br>";
		#die("non valid entry");
	}	
?>
