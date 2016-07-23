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

	var GridWudIncDir = grid_wud_php.grid_wud_url;
	var count = 0 ;
    var cct = 0 ;
	
	/* Get and remember the form and elements id */
    $("button[ClickResult]").click(function() {
        cct = $(this).attr("ClickResult") ;
    });	
	
	/* SUBMIT grid-wud-page */
	$(document).on('submit', '#grid_wud_form', function()
	{		
		var pmore = document.getElementById("grid_wud_set_more_grid_"+cct).value;
		var ptags = document.getElementById("grid_wud_tags_"+cct).value;
		var pcats = document.getElementById("grid_wud_cats_"+cct).value;
		var ids = document.getElementById("grid_wud_ids_"+cct).value;
		var tnr = document.getElementById("grid_wud_grid_nr_"+cct).value;
		var snr = document.getElementById("grid_wud_shape_"+cct).value;
		var lp = document.getElementById("grid_wud_latest_"+cct).value;
		var sh = document.getElementById("grid_wud_shadow"+cct).value;
		var ptotal = $("#grid_wud_set_max_grid_"+cct).val();
		count++;
		if(count==1)
		{
			ptotal = parseInt(pmore);
			document.getElementById("grid_wud_set_max_grid_"+cct).value = ptotal;		 
		}
		else{
			ptotal = parseInt(ptotal) + parseInt(pmore);
			document.getElementById("grid_wud_set_max_grid_"+cct).value = ptotal;	
		}	
		var dataString = 'grid_wud_set_max_grid='+ ptotal +'& grid_wud_tags='+ ptags +'& grid_wud_cats='+ pcats +'& grid_wud_ids='+ ids+'& grid_wud_grid_nr='+ tnr+'& grid_wud_shape='+ snr+'& grid_wud_latest='+ lp+'& grid_wud_shadow='+ sh;
		
		/* Load in div grid_wud_result data with structure from grid-wud-xtra*/
		$.ajax({
		type : 'POST',
		url  : GridWudIncDir,
		data : dataString,
		cache: false,
		success :  function(data){$("#grid_wud_result_"+cct).html(data);}
		});	
		return false;
	});
	
	/* GO TO once grid-wud-page */
	if (document.getElementById("grid_wud_button")) {
		var pos = localStorage.getItem("pos");
		$('html, body').animate({scrollTop : pos},0);
		localStorage.removeItem(pos);
    }
	
})(jQuery);
//]]> 
