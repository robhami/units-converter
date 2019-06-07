<?php
Session_start();
	 $units_cat=$_POST['units_cat'];
	$_SESSION['units_cat']=$units_cat;
		echo nl2br (" \n Units_Cat: ".$units_cat);
	
	 $units_from=$_POST['units_from'];
	
		echo nl2br (" \n Units_From: ".$units_from);	
	
	 $units_to=$_POST['units_to'];
	$_SESSION['units_to']=$units_to;
		echo nl2br (" \n Units_To: ".$units_to);
		
	
?>