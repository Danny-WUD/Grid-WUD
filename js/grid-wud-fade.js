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

	/* GO TO once grid-wud-page */
	if (document.getElementById("grid_wud_button")) {
		$("#wud_fade").hide();
		$('#wud_fade').fadeIn(1400);
		var pos = localStorage.getItem("pos");
		$('html, body').animate({scrollTop : pos},0);
		localStorage.removeItem(pos);
    }

	/* GO TO once grid-wud-page */
	if (document.getElementById("grid_wud_fade_home")) {	
		$("#grid_wud_fade_home").hide();
		$('#grid_wud_fade_home').fadeIn(1400);
    }
	
});
})(jQuery);
//]]> 
