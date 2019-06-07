<?php
include 'units_test.php';
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
<?php #$view_variable = $units_from; ?>
<?php #$view_variable = $units_to; ?>

<!-- need to look at PHP security issues !-->
<form method="POST" id="con_form"  onchange="update()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] );?>">
	
	Units categoryx: 
	<select name="units_cat" id="units_cat" onchange="this.form.submit()"  class="myForms">
	<!--php is there to make selected DD stick not sure how it works from stack overflow- need to look at it!-->	
		<option value="Mass"<?php if($_POST['units_cat']=='Mass') echo 'selected="selected"';?>>Mass</option>
		<option value="Flow"<?php if($_POST['units_cat']=='Flow') echo 'selected="selected"';?>>Flow</option>
		<option value="Pressure"<?php if($_POST['units_cat']=='Pressure') echo 'selected="selected"';?>>Pressure</option>
		<option value="Torque"<?php if($_POST['units_cat']=='Torque') echo 'selected="selected"';?>>Torque</option>
		<option value="Density"<?php if($_POST['units_cat']=='Density') echo 'selected="selected"';?>>Density</option>
		<!--
		<option value="Temperature"<?php if($_POST['units_cat']=='dn') echo 'selected="selected"';?>>Temperature</option>
		<option value="Velocity"<?php if($_POST['units_from']=='kn') echo 'selected="selected"';?>>KN</option>!-->
	</select>
	
	<br>
	
	Value from: <input type="number" name="value" id="input1" value="<?php echo $_POST['value'];?>">
	<br>
	Units from: 
	<select name="units_from" id="units_from" onchange="this.form.submit()" class="myForms"> 
	
		<option value="<?php echo($col[2]) ?>"<?php if($_POST['units_from']==($col[2])) echo 'selected="selected"';?>><?php echo($col[2]) ?></option>
		<option value="<?php echo($col[3]) ?>"<?php if($_POST['units_from']==($col[3])) echo 'selected="selected"';?>><?php echo($col[3]) ?></option>
		<option value="<?php echo($col[4]) ?>"<?php if($_POST['units_from']==($col[4])) echo 'selected="selected"';?>><?php echo($col[4]) ?></option>
		<option value="<?php echo($col[5]) ?>"<?php if($_POST['units_from']==($col[5])) echo 'selected="selected"';?>><?php echo($col[5]) ?></option>
		<option value="<?php echo($col[6]) ?>"<?php if($_POST['units_from']==($col[6])) echo 'selected="selected"';?>><?php echo($col[6]) ?></option>
		<option value="<?php echo($col[7]) ?>"<?php if($_POST['units_from']==($col[7])) echo 'selected="selected"';?>><?php echo($col[7]) ?></option>
		<option value="<?php echo($col[8]) ?>"<?php if($_POST['units_from']==($col[8])) echo 'selected="selected"';?>><?php echo($col[8]) ?></option>
		<option value="<?php echo($col[9]) ?>"<?php if($_POST['units_from']==($col[9])) echo 'selected="selected"';?>><?php echo($col[9]) ?></option>
		
	</select>
	
	Units to: 
	<select name="units_to" id="units_to" onchange="this.form.submit() "class="myForms">
	
		<option value="<?php echo($col[2]) ?>"<?php if($_POST['units_to']==($col[2])) echo 'selected="selected"';?>><?php echo($col[2]) ?></option>
		<option value="<?php echo($col[3]) ?>"<?php if($_POST['units_to']==($col[3])) echo 'selected="selected"';?>><?php echo($col[3]) ?></option>
		<option value="<?php echo($col[4]) ?>"<?php if($_POST['units_to']==($col[4])) echo 'selected="selected"';?>><?php echo($col[4]) ?></option>
		<option value="<?php echo($col[5]) ?>"<?php if($_POST['units_to']==($col[5])) echo 'selected="selected"';?>><?php echo($col[5]) ?></option>
		<option value="<?php echo($col[6]) ?>"<?php if($_POST['units_to']==($col[6])) echo 'selected="selected"';?>><?php echo($col[6]) ?></option>
		<option value="<?php echo($col[7]) ?>"<?php if($_POST['units_to']==($col[7])) echo 'selected="selected"';?>><?php echo($col[7]) ?></option>
		<option value="<?php echo($col[8]) ?>"<?php if($_POST['units_to']==($col[8])) echo 'selected="selected"';?>><?php echo($col[8]) ?></option>
		<option value="<?php echo($col[9]) ?>"<?php if($_POST['units_to']==($col[9])) echo 'selected="selected"';?>><?php echo($col[9]) ?></option>
	
	</select>
	
	<br>
	
	<output id="output_value">Result = <?php echo($answer." ".$units_to) ?> </output>
	
	<br>
	
	<input type="submit" id="clickMe">
	
</form>

<p id="msg"></p>

<?#= console_log($view_variable); ?>
</body>
</html>

<script>

	$(window).load(function(){
		
		jQuery("#u_from option:contains('Blank')").remove();
		jQuery("#u_to option:contains('Blank')").remove();
	});
	
	function unitsPost() {
		
		alert ("<?php echo($col[2]) ?>");
		$_POST['units_to']=$col[3];
	}

	function update()
	
	{	alert("Hi");
		var units_to=document.getElementById('units_to').value;
		var dataString ='units_to='+ units_to;
		$.ajax({
			type:"post",
			url:"units_from.php",
			cache: false,
			success:function(html){
				$('#msg').html(html);
				
			}
			
		});
		
		return false;	
	}
	
</script>