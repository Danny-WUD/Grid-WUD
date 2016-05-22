/**
=== Grid WUD ===
Contributors: wistudat.be
Plugin Name: Grid WUD
Description: Adds 100% responsive, customizable and dynamic grids to WordPress posts and pages.
Author: Danny WUD
Author URI: http://wistudat.be/
 */
//<![CDATA[
(function($) { 
$(document).ready(function(e)
{
	var GridWudIncDir = grid_wud_php.grid_wud_url;
	var count = 0 ;

	/* CLICK grid-wud-base */
	$("#grid_wud_base").click(function(e){	 
		var pos = $(window).scrollTop();
		/* Remember pos untill loading grid_wud_button */
		localStorage.setItem("pos", pos);
	});	
	
	/* SUBMIT grid-wud-page */
	$(document).on('submit', '#grid_wud_form', function()
	{			
		var pmore = document.getElementById("grid_wud_set_more_grid").value;
		var ptags = document.getElementById("grid_wud_tags").value;
		var pcats = document.getElementById("grid_wud_cats").value;
		var ids = document.getElementById("grid_wud_ids").value;
		var tnr = document.getElementById("grid_wud_grid_nr").value;
		var ptotal = $("#grid_wud_set_max_grid").val();
		count++;
		if(count==1)
		{
			ptotal = parseInt(pmore);
			document.getElementById("grid_wud_set_max_grid").value = ptotal;		 
		}
		else{
			ptotal = parseInt(ptotal) + parseInt(pmore);
			document.getElementById("grid_wud_set_max_grid").value = ptotal;	
		}	
		var dataString = 'grid_wud_set_max_grid='+ ptotal +'& grid_wud_tags='+ ptags +'& grid_wud_cats='+ pcats +'& grid_wud_ids='+ ids+'& grid_wud_grid_nr='+ tnr;
		
		/* Load in div grid_wud_result data with structure from grid-wud-xtra*/
		$.ajax({
		type : 'POST',
		url  : GridWudIncDir,
		data : dataString,
		cache: false,
		success :  function(data){$("#grid_wud_result").html(data);}
		});	
		return false;
	});
	/* GO TO once grid-wud-page */
	if (document.getElementById("grid_wud_button")) {
		var pos = localStorage.getItem("pos");
		$('html, body').animate({scrollTop : pos},0);
		localStorage.removeItem(pos);
    }	
});
})(jQuery);
//]]> 
