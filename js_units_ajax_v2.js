
	
	
	
	window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
	
	
	
	
	
	
	
	function updatex()
	
	{
			/*assign variables that get values from DD's in html*/
		var units_cat=document.getElementById('units_cat').value;
		var units_from=document.getElementById('units_from').value;
		var units_to=document.getElementById('units_to').value;
		var dataString='units_cat='+ units_cat+'&units_from='+ units_from+'&units_to='+ units_to;
		/* use ajax to autoupdate POSTED values in other php file*/
		$.ajax({
			type:"post",
			url:"ajax_php.php",
		/*use var data string above to add values*/
			data:dataString,
			cache: false,
		/* return values in HTML #msg*/
			success:function(html){
				$('#msg').html(html);	
			
			
			
			
			}
		});
		/* is this like an else */
		return false;	
	};