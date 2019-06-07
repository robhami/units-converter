<?php
Session_start();

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


$units_cat=$_SESSION['units_cat'];
$link = mysqli_connect("shareddb-g.hosting.stackcp.net","units-2019-373172b1", "Booboo111", "units-2019-373172b1");

function callCols($link, $units_cat) {
	global $link;
	global $units_cat;
	$query2=("DESCRIBE ".mysqli_real_escape_string($link, $units_cat));
	
	
	if ($result2 = mysqli_query($link, $query2)) {
		$table_desc = mysqli_fetch_all($result2);
		$rowcount=mysqli_num_rows ($result2);
		echo nl2br(" \n Query success");
	#Create an array of column values	
		foreach($table_desc as $val) {	
			global $col;
			$col[]=$val[0];	
		}
			
	#debug to check create column array worked and show output		
	echo "<br>";
	echo "COLUMNS ARRAY";
	echo "<br>";
	print_r($col);	
	echo "<br>";
	return $col;
	#print_r($col[2]);		
	# debug output to show array selected, if query worked, conversion factor
			
	} else {	
		echo nl2br(" \n Query failed");
	}

}

callCols($link,$units_cat);

$view_variable = $col; 
console_log($view_variable);
?>