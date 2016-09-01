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
	$.fn.wudLB = function(WUDopt) {
		if(!this.length){return this;}
		var WUD = $.extend( $.fn.wudLB.defaults, WUDopt );
		return this.each(function() {

			var $this = $(this), wudImgLg = $this.attr(WUD.target), isCssLb = function(wudImgLg) {return (typeof wudImgLg !== "undefined");};
			if ( isCssLb(wudImgLg) ){$this.wrap("<a class='" + WUD.WudWrapClass + "' href='" + wudImgLg + "'></a>");}

			$("a." + WUD.WudWrapClass).click(function(e) {
				e.preventDefault();
				var CssLb,
				lbImageHref = $(this).attr( "href" );
				if ( $("#CssLb").length ) {$("#CssLb-img").html("<img src='" + lbImageHref + "' /><div class='text-box'> <h4>&#10754;</h4></div>");	$("#CssLb").show();} 
				else {CssLb ="<div id='CssLb'>" + "<div id='CssLb-img'>" + "<img src='" + lbImageHref + "' />" + "</div>" + "</div>"; $( "body" ).append(CssLb);}
			});
			
			$( document ).on("click touchend mouseup touchcancel", "#CssLb", function() {$( "#CssLb" ).hide(); });
			$(this).keydown(function(e) { e.preventDefault(); if(e.keyCode == 27 || e.keyCode == 13) { $( "#CssLb" ).hide(); } });
			
		});
	};

	$.fn.wudLB.defaults = {target: "wud-lb",WudWrapClass: "CssLb"};
	
$("a").wudLB();

})(jQuery);



//]]>