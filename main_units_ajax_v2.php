<?php
Session_start();
# *******************can't get ajax to write to post value- need to look at Ajax again, probably just go with non Ajax converter v4 for now
error_reporting(E_ALL);
ini_set('display_errors', 1);
	
	

$link = mysqli_connect("shareddb-g.hosting.stackcp.net","units-2019-373172b1", "Booboo111", "units-2019-373172b1");
	
	if (mysqli_connect_error()) {	
		die ("Database error");	
		} else {
			
			$error = "Database working";
		}
	echo $error;

	if(isset($_SESSION["units_cat"])){
		$units_cat=($_SESSION["units_cat"]);
		$units_cat=mysqli_real_escape_string($link,$_SESSION["units_cat"]);
		
		}else
		{
		$_SESSION['units_cat']="Mass";	
		$_POST["units_cat"]="Mass";
		$units_cat="Mass";
		}
	
	if(isset($_POST["units_from"])){
		$units_from=mysqli_real_escape_string($link,$_POST["units_from"]);
		}else
		{
			$_POST["units_from"]="Klbs";
			$_SESSION['units_from']="Klbs";
			
		}
	if(isset($_POST["units_to"])){
		$units_to=mysqli_real_escape_string($link,$_POST["units_to"]);
		}else
		{
			$_POST["units_to"]="Klbs";
			$_SESSION['units_to']="Klbs";
		}
	if(isset($_POST["value"])){
		$value=mysqli_real_escape_string($link,(int)$_POST["value"]);
		}else
		{
			$_POST["value"]=0;	
		}
		
		
	$units_cat=$_SESSION['units_cat'];
	$units_from=$_SESSION['units_from'];
	$units_to=$_SESSION['units_to'];
	print_r($units_cat);
	print_r($_SESSION['units_cat']);
	print_r($units_from);
	print_r($_POST['units_from']);
	print_r($_SESSION['units_from']);
	
	
# Describe table for selected units, to get column values
# select table row from SQL that matches '$units_cat' and '$units_from' selected in dropdown
	# can't prepare and bind from table, need to white-list tables
	
	$query= $link->prepare("SELECT * FROM ".mysqli_real_escape_string($link, $units_cat)." WHERE from_value = ?");
	$query->bind_param("s", $units_from);
	$query->execute();
	echo "<br>";
	
	# if query works assign array to $row variable, can't use mysqli_query with prepared statement
	if ($result = $query->get_result()) {
		echo nl2br (" \n Query success");
		echo nl2br (" \n ARRAY FOR CONVERSION FACTORS");
		
		$row = mysqli_fetch_array($result);
	} else {
		
		echo nl2br (" \n Query failed");
		
	}
	
	print_r($row);
	
	
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
	echo($answer);
	
	
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
	#print_r($col[2]);		
	# debug output to show array selected, if query worked, conversion factor
			
	} else {	
		echo nl2br(" \n Query failed");
	}

}

callCols($link,$units_cat);

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js_units.js"></script>
  </head>

<style>
</style>

<body onload="return updatex()">


<p id="msg"></p>
<form method="POST" id="con_form"  onchange="return updatex()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] );?>">
<!--<input type="text" id="units_cat2">
<input type="text" id="units_to2">
<input type="submit" value="submit" onclick="return updatex()">
!-->
Units Categoryx
<select id="units_cat" onchange="this.form.submit()">
	<option value="Mass"<?php if($_SESSION['units_cat']=='Mass') echo 'selected="selected"';?>>Mass</option>
	<option value="Flow"<?php if($_SESSION['units_cat']=='Flow') echo 'selected="selected"';?>>Flow</option>
	<option value="Pressure"<?php if($_SESSION['units_cat']=='Pressure') echo 'selected="selected"';?>>Pressure</option>
	<option value="Torque"<?php if($_SESSION['units_cat']=='Torque') echo 'selected="selected"';?>>Torque</option>
	<option value="Density"<?php if($_SESSION['units_cat']=='Density') echo 'selected="selected"';?>>Density</option>
</select>
<br>
Value from: <input type="number" name="value" id="input1" value="<?php echo $_POST['value'];?>">
	
<br>
Units Fromxy
<select id="units_from" onchange="return updatex()">
		<option value="<?php echo($col[2]) ?>"<?php if($_POST['units_from']==($col[2])) echo 'selected="selected"';?>><?php echo($col[2]) ?></option>
		<option value="<?php echo($col[3]) ?>"<?php if($_POST['units_from']==($col[3])) echo 'selected="selected"';?>><?php echo($col[3]) ?></option>
		<option value="<?php echo($col[4]) ?>"<?php if($_POST['units_from']==($col[4])) echo 'selected="selected"';?>><?php echo($col[4]) ?></option>
		<option value="<?php echo($col[5]) ?>"<?php if($_POST['units_from']==($col[5])) echo 'selected="selected"';?>><?php echo($col[5]) ?></option>
		<option value="<?php echo($col[6]) ?>"<?php if($_POST['units_from']==($col[6])) echo 'selected="selected"';?>><?php echo($col[6]) ?></option>
		<option value="<?php echo($col[7]) ?>"<?php if($_POST['units_from']==($col[7])) echo 'selected="selected"';?>><?php echo($col[7]) ?></option>
		<option value="<?php echo($col[8]) ?>"<?php if($_POST['units_from']==($col[8])) echo 'selected="selected"';?>><?php echo($col[8]) ?></option>
		<option value="<?php echo($col[9]) ?>"<?php if($_POST['units_from']==($col[9])) echo 'selected="selected"';?>><?php echo($col[9]) ?></option>
</select>
<br>
Units To
<select id="units_to" onchange="return updatex()">
		<option value="<?php echo($col[2]) ?>"<?php if($_POST['units_to']==($col[2])) echo 'selected="selected"';?>><?php echo($col[2]) ?></option>
		<option value="<?php echo($col[3]) ?>"<?php if($_POST['units_to']==($col[3])) echo 'selected="selected"';?>><?php echo($col[3]) ?></option>
		<option value="<?php echo($col[4]) ?>"<?php if($_POST['units_to']==($col[4])) echo 'selected="selected"';?>><?php echo($col[4]) ?></option>
		<option value="<?php echo($col[5]) ?>"<?php if($_POST['units_to']==($col[5])) echo 'selected="selected"';?>><?php echo($col[5]) ?></option>
		<option value="<?php echo($col[6]) ?>"<?php if($_POST['units_to']==($col[6])) echo 'selected="selected"';?>><?php echo($col[6]) ?></option>
		<option value="<?php echo($col[7]) ?>"<?php if($_POST['units_to']==($col[7])) echo 'selected="selected"';?>><?php echo($col[7]) ?></option>
		<option value="<?php echo($col[8]) ?>"<?php if($_POST['units_to']==($col[8])) echo 'selected="selected"';?>><?php echo($col[8]) ?></option>
		<option value="<?php echo($col[9]) ?>"<?php if($_POST['units_to']==($col[9])) echo 'selected="selected"';?>><?php echo($col[9]) ?></option>
</select>


<input type="submit" text="submit" onclick="this.form.submit()"> 

<p id="msg2"></p>

<?#= console_log($view_variable); ?>

</form>
</body>
</html>

