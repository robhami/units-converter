<?php
$error = "";
$units_from='klbs';
$units_to='klbs';
$value=0;
$units_cat='Mass';
	#connect and echo if working, NEED to add DIE
	
	$link = mysqli_connect("shareddb-g.hosting.stackcp.net","units-2019-373172b1", "Booboo111", "units-2019-373172b1");
	
	if (mysqli_connect_error()) {	
		$error = "Database error";	
		} else {
			
			$error = "Database working";
		}
	echo $error;
	
	#set variables from POSTs add default values if not set
	if(isset($_POST["units_cat"])){
		$units_cat=($_POST["units_cat"]);
		}else
		{
			$_POST["units_cat"]="Mass";
		
		}
	
	if(isset($_POST["units_from"])){
		$units_from=($_POST["units_from"]);
		}else
		{
			$_POST["units_from"]="klbs";
		
		}
	if(isset($_POST["units_to"])){
		$units_to=($_POST["units_to"]);
		}else
		{
			$_POST["units_to"]="klbs";
		}
	if(isset($_POST["value"])){
		$value=($_POST["value"]);
		}else
		{
			$_POST["value"]=0;	
		}
		
		
	# debug output to show units from and to
	echo "<br>";
	print_r($units_cat);
	echo "<br>";
	print_r($units_from);
	echo "<br>";
	print_r($units_to);
	
	
	
	# select array from SQL that matches '$units_cat' and '$units_from' selected in dropdown
	$query="SELECT * FROM ".($units_cat)." WHERE from_value ='".($units_from)."'";
	
	
	
	# if query works assign array to $row variable
	if ($result = mysqli_query($link, $query)) {
		$row = mysqli_fetch_array($result);
		
	# debug output to show array selected, if query worked, conversion factor
		echo nl2br (" \n Query was successful \n");
		print_r($row);
		echo "<br>";	
	} else {	
		echo nl2br(" \n Query failed");
	}
	
	/*# select array from SQL that matches '$units_from' selected in dropdown OBSOLETED BY ABOVE
	$query="SELECT * FROM Mass WHERE from_value ='".($units_from)."'";
	
	# if query works assign array to $row variable
	if ($result = mysqli_query($link, $query)) {
		$row = mysqli_fetch_array($result);
		
	# debug output to show array selected, if query worked, conversion factor
		echo nl2br (" \n Query was successful \n");
		print_r($row);
		echo "<br>";	
	} else {	
		echo nl2br(" \n Query failed");
	}
	*/
	
	
	# select conversion factor from called array 
	$conversion=$row["$units_to"];
	
	# debug output to show conversion factor
	echo "<br>";
	echo "<br>Conversion factor: ";
	print_r ($conversion);
	echo "<br>";
	
	# debug output to show POST values for value, units_from, units_to
	if(isset($_POST["value"])){
	echo  (" \n Units value is: ".$_POST["value"]);
	echo nl2br(" \n Units FROM is: ".$_POST["units_from"]);  
	echo nl2br(" \n Units TO is: ".$_POST["units_to"]); 
	}
	echo "<br>";
	
	# debug output to show conversion factor with units from and to
	echo ("1 " .$row[1]." equals ".$row[$units_to]." ".$units_to);
	echo "<br>";
	
	# get answer
	$answer = ($value * $conversion);
	# debug answer
	echo($answer);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
  
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="norton-safeweb-site-verification" content="letrdxujkunglh0t7k65mmnivdbycwh7zq49hxtnzhurkca81jybivhr72fdsqlgecpi4busrjjlosrwc80ealajcc8en-hjavdovln7i9rkg39-0miefuviosm7prtk" />
    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<!-- Jquery from https://developers.google.com/speed/libraries/#ext-core -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script><title>Units Converter</title>
  
  </head>

<style>
</style>

<body>


<!-- need to look at PHP security issues !-->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	
	Units category: 
	<select name="units_cat">
	<!--php is there to make selected DD stick not sure how it works from stack overflow- need to look at it!-->	
		<option value="Mass"<?php if($_POST['units_cat']=='Mass') echo 'selected="selected"';?>>Mass</option>
		<option value="Flow"<?php if($_POST['units_cat']=='Flow') echo 'selected="selected"';?>>Flow</option>
		<!--<option value="Pressure"<?php if($_POST['units_from']=='ton') echo 'selected="selected"';?>>Ton</option>
		<option value="Torque"<?php if($_POST['units_from']=='kg') echo 'selected="selected"';?>>Kg</option>
		<option value="Density"<?php if($_POST['units_from']=='n') echo 'selected="selected"';?>>Newton</option>
		<option value="Temp"<?php if($_POST['units_from']=='dn') echo 'selected="selected"';?>>DN</option>
		<option value="Velocity"<?php if($_POST['units_from']=='kn') echo 'selected="selected"';?>>KN</option>!-->
	</select>
	
	<br>
	
	Value from: <input type="number" name="value">
	<br>
	Units from: 
	<select name="units_from">
		
		<option value="klbs"<?php if($_POST['units_from']=='klbs') echo 'selected="selected"';?>>Klbs</option>
		<option value="pound"<?php if($_POST['units_from']=='pound') echo 'selected="selected"';?>>Pound</option>
		<option value="ton"<?php if($_POST['units_from']=='ton') echo 'selected="selected"';?>>Ton</option>
		<option value="kg"<?php if($_POST['units_from']=='kg') echo 'selected="selected"';?>>Kg</option>
		<option value="newton"<?php if($_POST['units_from']=='newton') echo 'selected="selected"';?>>Newton</option>
		<option value="dn"<?php if($_POST['units_from']=='dn') echo 'selected="selected"';?>>DN</option>
		<option value="kn"<?php if($_POST['units_from']=='kn') echo 'selected="selected"';?>>KN</option>
	</select>
	
	<br>
	
	
	
	<br>
	Units to: 
	<select name="units_to">
		<option value="klbs"<?php if($_POST['units_to']=='klbs') echo 'selected="selected"';?>>Klbs</option>
		<option value="pound"<?php if($_POST['units_to']=='pound') echo 'selected="selected"';?>>Pound</option>
		<option value="ton"<?php if($_POST['units_to']=='ton') echo 'selected="selected"';?>>Ton</option>
		<option value="kg"<?php if($_POST['units_to']=='kg') echo 'selected="selected"';?>>Kg</option>
		<option value="newton"<?php if($_POST['units_to']=='newton') echo 'selected="selected"';?>>Newton</option>
		<option value="dn"<?php if($_POST['units_to']=='dn') echo 'selected="selected"';?>>DN</option>
		<option value="kn"<?php if($_POST['units_to']=='kn') echo 'selected="selected"';?>>KN</option>
	</select>
	
	<br>
	
	<output id="output_value">Result = <?php echo($answer.$units_to) ?> </output>
	
	<br>
	
	<input type="submit">
	
</form>