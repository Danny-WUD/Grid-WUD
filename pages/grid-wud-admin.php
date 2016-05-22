<?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 */
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// ************** OPTIONS PAGE ********************
	function grid_wud_options_notice() {	
		echo '<div class="grid-wud-admin-table">';
		echo '<h2 class="grid-wud-admin-h2">'.__("Grid WUD Options", "grid-wud").' - '.__("More than just grid", "grid-wud").'!</h2>';
		echo '<img src="' . plugins_url( '../images/logo-grid-wud.png', __FILE__ ) . '">';
		echo '<a id="grid-rate-it" href="https://wordpress.org/support/plugin/grid-wud" target="_blank" title="100% FREE PRO SUPPORT" ><img src="' . plugins_url( '../images/wud-support.png', __FILE__ ) . '"></a>';
		echo '<p></p>';
		
		//SAVE THE VALUES TO WP_OPTIONS
	if ( isset($_POST['wud_opt_hidden']) && $_POST['wud_opt_hidden'] == 'Y' ) {
			
		// CSS choice $grid_wud_my_css = get_option('grid_wud_my_css');
		$grid_wud_my_css = $_POST['grid_wud_my_css'];
		update_option('grid_wud_my_css', $grid_wud_my_css);
		
		//Button back 		
		if ( isset($_POST['grid_wud_but_bcolor']) && !$_POST['grid_wud_but_bcolor']=='') {$grid_wud_but_bcolor = filter_var($_POST['grid_wud_but_bcolor'], FILTER_SANITIZE_STRING);} else{$grid_wud_but_bcolor ="#F73535";}
		update_option('grid_wud_but_bcolor', $grid_wud_but_bcolor);
		
		//Button text
		if ( isset($_POST['grid_wud_but_fcolor']) && !$_POST['grid_wud_but_fcolor']=='') {$grid_wud_but_fcolor = filter_var($_POST['grid_wud_but_fcolor'], FILTER_SANITIZE_STRING);} else{$grid_wud_but_fcolor ="#FFFFFF";}
		update_option('grid_wud_but_fcolor', $grid_wud_but_fcolor);	
		
		//Titles Font Size
		$grid_wud_but_font_size = filter_var($_POST['grid_wud_but_font_size'], FILTER_SANITIZE_STRING);
		if($grid_wud_but_font_size==''){$grid_wud_but_font_size='16';}
		update_option('grid_wud_but_font_size', ($grid_wud_but_font_size/10));
					
		//Category back 
		if ( isset($_POST['grid_wud_cat_bcolor']) && !$_POST['grid_wud_cat_bcolor']=='') {$grid_wud_cat_bcolor = filter_var($_POST['grid_wud_cat_bcolor'], FILTER_SANITIZE_STRING);} else{$grid_wud_cat_bcolor ="#F73535";}
		update_option('grid_wud_cat_bcolor', $grid_wud_cat_bcolor);
		
		//Category text
		if ( isset($_POST['grid_wud_cat_fcolor']) && !$_POST['grid_wud_cat_fcolor']=='') {$grid_wud_cat_fcolor = filter_var($_POST['grid_wud_cat_fcolor'], FILTER_SANITIZE_STRING);} else{$grid_wud_cat_fcolor ="#FFFFFF";}
		update_option('grid_wud_cat_fcolor', $grid_wud_cat_fcolor);		

		//Titles Font Size
		$grid_wud_h1_font_size = filter_var($_POST['grid_wud_h1_font_size'], FILTER_SANITIZE_STRING);
		if($grid_wud_h1_font_size==''){$grid_wud_h1_font_size='21';}
		update_option('grid_wud_h1_font_size', ($grid_wud_h1_font_size/10));

		//Hide Category or Tag Title		
		if ( isset($_POST['grid_wud_hide_cat_tag_header'])) {$grid_wud_hide_cat_tag_header = filter_var($_POST['grid_wud_hide_cat_tag_header'], FILTER_SANITIZE_STRING);} else{$grid_wud_hide_cat_tag_header =0;}
		update_option('grid_wud_hide_cat_tag_header', $grid_wud_hide_cat_tag_header);	

		//Hide Category Title
		if ( isset($_POST['grid_wud_hide_grid_cat'])) {$grid_wud_hide_grid_cat = filter_var($_POST['grid_wud_hide_grid_cat'], FILTER_SANITIZE_STRING);} else{$grid_wud_hide_grid_cat =0;}
		update_option('grid_wud_hide_grid_cat', $grid_wud_hide_grid_cat);
		
		//Order grid
		if ( isset($_POST['grid_wud_set_order_grid'])) {$grid_wud_set_order_grid = filter_var($_POST['grid_wud_set_order_grid'], FILTER_SANITIZE_STRING);} else{$grid_wud_set_order_grid =0;}
		update_option('grid_wud_set_order_grid', $grid_wud_set_order_grid);
		
		//Sort order grid
		$grid_wud_set_dir_grid = filter_var($_POST['grid_wud_set_dir_grid'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_set_dir_grid', $grid_wud_set_dir_grid);	
		
		//Featured image as default
		if ( isset($_POST['grid_wud_set_featured_img'])) {$grid_wud_set_featured_img = filter_var($_POST['grid_wud_set_featured_img'], FILTER_SANITIZE_STRING);} else{$grid_wud_set_featured_img =0;}
		update_option('grid_wud_set_featured_img', $grid_wud_set_featured_img);	
		
		//Zoom image on hoover
		if ( isset($_POST['grid_wud_img_hover'])) {$grid_wud_img_hover = filter_var($_POST['grid_wud_img_hover'], FILTER_SANITIZE_STRING);} else{$grid_wud_img_hover =0;}
		update_option('grid_wud_img_hover', $grid_wud_img_hover);	
		
		//Grey image
		if ( isset($_POST['grid_wud_img_grey'])) {$grid_wud_img_grey = filter_var($_POST['grid_wud_img_grey'], FILTER_SANITIZE_STRING);} else{$grid_wud_img_grey =0;}
		update_option('grid_wud_img_grey', $grid_wud_img_grey);	

		//grid instead archive pages
		if ( isset($_POST['grid_wud_no_archives'])) {$grid_wud_no_archives = filter_var($_POST['grid_wud_no_archives'], FILTER_SANITIZE_STRING);} else{$grid_wud_no_archives =0;}
		update_option('grid_wud_no_archives', $grid_wud_no_archives);	
		
		//Max grid to show
		$grid_wud_set_max_grid = filter_var($_POST['grid_wud_set_max_grid'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_set_max_grid', $grid_wud_set_max_grid);
			
		//More grid to show
		$grid_wud_set_more_grid = filter_var($_POST['grid_wud_set_more_grid'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_set_more_grid', $grid_wud_set_more_grid);
			
		//Skip x posts
		$grid_wud_skip_post = filter_var($_POST['grid_wud_skip_post'], FILTER_SANITIZE_STRING);
		if($grid_wud_skip_post==''){$grid_wud_skip_post='0';}
		update_option('grid_wud_skip_post', $grid_wud_skip_post);
		
		//Featured image as default
		$grid_wud_show_excerpt = filter_var($_POST['grid_wud_show_excerpt'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_show_excerpt', $grid_wud_show_excerpt);

		// Choice text or button = ARCHIVE;
		$grid_wud_show_arch_button = filter_var($_POST['grid_wud_show_arch_button'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_show_arch_button', sanitize_text_field($grid_wud_show_arch_button));

		// Choice text or button = grid;
		$grid_wud_show_grid_button = filter_var($_POST['grid_wud_show_grid_button'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_show_grid_button', sanitize_text_field($grid_wud_show_grid_button));
	
		//Show read more: archives or grid
		$grid_wud_show_arch_grid = filter_var($_POST['grid_wud_show_arch_grid'], FILTER_SANITIZE_STRING);
		update_option('grid_wud_show_arch_grid', $grid_wud_show_arch_grid);

		//Maximum words excerpt
		$grid_wud_excerpt_words = filter_var($_POST['grid_wud_excerpt_words'], FILTER_SANITIZE_STRING);
		if($grid_wud_excerpt_words==''){$grid_wud_excerpt_words=25;}
		update_option('grid_wud_excerpt_words', sanitize_text_field($grid_wud_excerpt_words));
		
		//Fade in grid
		if ( isset($_POST['grid_wud_fade_in'])) {$grid_wud_fade_in = filter_var($_POST['grid_wud_fade_in'], FILTER_SANITIZE_STRING);} else{$grid_wud_fade_in =0;}
		update_option('grid_wud_fade_in', $grid_wud_fade_in);	
		
		//Custom Post Type 01
		$grid_wud_cpt01 = filter_var($_POST['grid_wud_cpt01'], FILTER_SANITIZE_STRING);
		if(empty($grid_wud_cpt01)){$grid_wud_cpt01="Custom Post Type 1";}
		update_option('grid_wud_cpt01', sanitize_text_field($grid_wud_cpt01));
		
		//Custom Post Type 02
		$grid_wud_cpt02 = filter_var($_POST['grid_wud_cpt02'], FILTER_SANITIZE_STRING);
		if(empty($grid_wud_cpt02)){$grid_wud_cpt02="Custom Post Type 2";}
		update_option('grid_wud_cpt02', sanitize_text_field($grid_wud_cpt02));
		
		//Custom Post Type 02
		$grid_wud_def_img = filter_var($_POST['grid_wud_def_img'], FILTER_SANITIZE_STRING);
		if(empty($grid_wud_def_img)){$grid_wud_def_img=WUD_GRID_URL.'/images/empty-grid.png';}
		update_option('grid_wud_def_img', sanitize_text_field($grid_wud_def_img));

		
		if( empty($error) ){
		echo '<div class="updated"><p><strong>'.__("Settings saved", "grid-wud").'</strong></p></div>';
		}else{
		echo "<div class='error'><p><strong>";
			foreach ( $error as $key=>$val ) {
				_e($val, 'wud'); 
				echo "<br/>";
			}
		echo "</strong></p></div>";
		    }
	} 
	else {
		
		//If read the first time when opening this page, declare variables
		$grid_wud_my_css = $GLOBALS['gwfuncs']['grid_wud_my_css'];
		$grid_wud_cat_bcolor = $GLOBALS['gwfuncs']['grid_wud_cat_bcolor'];
		$grid_wud_cat_fcolor = $GLOBALS['gwfuncs']['grid_wud_cat_fcolor'];
		$grid_wud_h1_font_size = ($GLOBALS['gwfuncs']['grid_wud_h1_font_size']*10);
		$grid_wud_set_featured_img = $GLOBALS['gwfuncs']['grid_wud_set_featured_img'];
		$grid_wud_set_max_grid = $GLOBALS['gwfuncs']['grid_wud_set_max_grid'];
		$grid_wud_set_more_grid = $GLOBALS['gwfuncs']['grid_wud_set_more_grid'];
		$grid_wud_hide_cat_tag_header = $GLOBALS['gwfuncs']['grid_wud_hide_cat_tag_header'];
		$grid_wud_hide_grid_cat = $GLOBALS['gwfuncs']['grid_wud_hide_grid_cat'];	
		$grid_wud_show_excerpt = $GLOBALS['gwfuncs']['grid_wud_show_excerpt'];
		$grid_wud_show_arch_button = $GLOBALS['gwfuncs']['grid_wud_show_arch_button'];
		$grid_wud_show_grid_button = $GLOBALS['gwfuncs']['grid_wud_show_grid_button'];
		$grid_wud_show_arch_grid = $GLOBALS['gwfuncs']['grid_wud_show_arch_grid'];
		$grid_wud_set_order_grid = $GLOBALS['gwfuncs']['grid_wud_set_order_grid'];
		$grid_wud_set_dir_grid = $GLOBALS['gwfuncs']['grid_wud_set_dir_grid'];
		$grid_wud_but_bcolor = $GLOBALS['gwfuncs']['grid_wud_but_bcolor'];
		$grid_wud_but_fcolor = $GLOBALS['gwfuncs']['grid_wud_but_fcolor'];
		$grid_wud_but_font_size = ($GLOBALS['gwfuncs']['grid_wud_but_font_size']*10);
		$grid_wud_excerpt_words = $GLOBALS['gwfuncs']['grid_wud_excerpt_words'];
		$grid_wud_no_archives = $GLOBALS['gwfuncs']['grid_wud_no_archives'];
		$grid_wud_skip_post = $GLOBALS['gwfuncs']['grid_wud_skip_post'];
		$grid_wud_fade_in = $GLOBALS['gwfuncs']['grid_wud_fade_in'];
		$grid_wud_cpt01 = $GLOBALS['gwfuncs']['grid_wud_cpt01'];
		$grid_wud_cpt02 = $GLOBALS['gwfuncs']['grid_wud_cpt02'];
		$grid_wud_def_img = $GLOBALS['gwfuncs']['grid_wud_def_img'];
		$grid_wud_img_hover = $GLOBALS['gwfuncs']['grid_wud_img_hover'];
		$grid_wud_img_grey = $GLOBALS['gwfuncs']['grid_wud_img_grey'];
	}

//LEFT ADMIN 
// echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("tips, help, support and others2", "grid-wud").'</div></div>';

		//Form start
	    echo "<form name='grid_wud_form' method='post' action=".admin_url('options-general.php')."?page=grid-wud>";
		echo "<div class='grid-wud-wrap'>";
		
		echo "<input type='hidden' name='wud_opt_hidden' value='Y'>";
		
		echo '<b class="grid-wud-admin-title">'.__("Category or Tag Title", "grid-wud").'</b>';
		echo '<i class="cs-wp-color" >'.__("Background", "grid-wud").': </i><input type="hidden" class="cs-wp-color-picker" name="grid_wud_cat_bcolor" value="'. $grid_wud_cat_bcolor. '" data-rgba="false"><br><br>';
		echo '<i class="cs-wp-color" >'.__("Text", "grid-wud").': </i><input type="hidden" class="cs-wp-color-picker" name="grid_wud_cat_fcolor" value="'. $grid_wud_cat_fcolor. '" data-rgba="false"><br><br>';

		echo '<dl><dt><label for="wud_box1">'.__("Font size", "grid-wud").'</label>&nbsp;&nbsp;</dt>
		<dd><input size="2" id="wud_box1" type="text" style="font-weight:bolder;" value="'.$grid_wud_h1_font_size.'" readonly/></dd>
		<dt><label for="wud_sizer1"></label></dt>
		<dd><input class="grid-wud-right" id="wud_sizer1" type="range" min="12" max="34" step="1" value="'.$grid_wud_h1_font_size.'" name="grid_wud_h1_font_size" onchange="wud_box1.value = wud_sizer1.value" oninput="wud_box1.value = wud_sizer1.value" /></dd></dl><br>';
	
		echo '<i>'.__("Hide", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_hide_cat_tag_header" type="checkbox" value="1" '. checked( $grid_wud_hide_cat_tag_header, "1", false ) .'/><br><hr>';

		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("If selected the Category/Tag is visible in the right top grid corner.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Show Category/Tag on the grid", "grid-wud").'</b><br>';
		echo '<i>'.__("Show", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_hide_grid_cat" type="checkbox" value="1" '. checked( $grid_wud_hide_grid_cat, "1", false ) .'/><br><br>';
	
		echo '<b class="grid-wud-admin-title">'.__("Featured image", "grid-wud").'</b>';
		echo '<i>'.__("Set as primary to display", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_set_featured_img" type="checkbox" value="1" '. checked( $grid_wud_set_featured_img, "1", false ) .'/><br><hr>';
			
		echo '<b class="grid-wud-admin-title">'.__("Image on hoover", "grid-wud").'</b>';
		echo '<i>'.__("Zoom the grid image on hoover", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_img_hover" type="checkbox" value="1" '. checked( $grid_wud_img_hover, "1", false ) .'/><br><br>';
			
		echo '<b class="grid-wud-admin-title">'.__("Grey images", "grid-wud").'</b>';
		echo '<i>'.__("Show the grid in grey and on hoover in colors", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_img_grey" type="checkbox" value="1" '. checked( $grid_wud_img_grey, "1", false ) .'/><br><hr>';
		
		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("If no image was found, use this pre-defined image.<br>You can select any image from the media library, or use the default one.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Default grid image", "grid-wud").'</b><br>';
		echo '<img src="'.$grid_wud_def_img.'" id="image-src" width="150px" height="150px" style="box-shadow: 4px 5px 5px #888888;"/><br>';
		echo '<input id="image-url" type="hidden" name="grid_wud_def_img" value="'.$grid_wud_def_img.'" /><br>';
		echo '<input id="upload-button" type="button" class="button" value="'.__("Upload Image", "grid-wud").'" />  <input id="clear-button" type="button"  class="button" value="'.__("Use the Default Image", "grid-wud").'" onclick="javascript: ClearText();" ><br><hr>';
		
		//Warning if they want to change this value!
		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("If selected, <b>all</b> Wordpress category's and Tags pages will be displayed as grid!<br>Remove the selection to de-activate it.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title" style="color: red;">'.__("Activate grid Pages", "grid-wud").'</b><br>';
		echo '<i>'.__("Active", "grid-wud").': </i><input class="grid-trigger" name="grid_wud_no_archives" type="checkbox" value="1" '. checked( $grid_wud_no_archives, "1", false ) .'/><hr>';

		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Changes the Custom Post Type Title 1 into this text. <br>Usage: short code: cp=\"1\"", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Custom Post Type Title", "grid-wud").' 1</b><br>';		
		echo '<i>'.__("Text", "grid-wud").' : </i><input type="text" class="grid-wud-right" name="grid_wud_cpt01" value="'.$grid_wud_cpt01.'" /><br><br><br>';
		
		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Changes the Custom Post Type Title 2 into this text. <br>Usage: short code: cp=\"2\"", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Custom Post Type Title", "grid-wud").' 2</b><br>';
		echo '<i>'.__("Text", "grid-wud").' : </i><input type="text" class="grid-wud-right" name="grid_wud_cpt02" value="'.$grid_wud_cpt02.'" /><br><br><hr>';

		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Fade in the picture of the grid by a mouse on hoover action.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Fade in grid", "grid-wud").'</b><br>';
		echo '<i>'.__("Active", "grid-wud").': </i><input class="grid-wud-right" name="grid_wud_fade_in" type="checkbox" value="1" '. checked( $grid_wud_fade_in, "1", false ) .'/><br>';
		
		echo '</div>';
//RIGHT ADMIN		
		echo "<div class='grid-wud-wrap-2'>";

		echo '<b class="grid-wud-admin-title">'.__("Buttons", "grid-wud").'</b>';
		echo '<i class="cs-wp-color" >'.__("Background", "grid-wud").': </i><input type="hidden" class="cs-wp-color-picker" name="grid_wud_but_bcolor" value="'. $grid_wud_but_bcolor. '" data-rgba="false"><br><br>';
		echo '<i class="cs-wp-color" >'.__("Text", "grid-wud").': </i><input type="hidden" class="cs-wp-color-picker" name="grid_wud_but_fcolor" value="'. $grid_wud_but_fcolor. '" data-rgba="false"><br><br>';

		echo '<dl><dt><label for="wud_box3">'.__("Font size", "grid-wud").'</label>&nbsp;&nbsp;</dt>
		<dd><input size="2" id="wud_box3" type="text" style="font-weight:bolder;" value="'.$grid_wud_but_font_size.'" readonly/></dd>
		<dt><label for="wud_sizer3"></label></dt>
		<dd><input class="grid-wud-right" id="wud_sizer3" type="range" min="10" max="30" step="1" value="'.$grid_wud_but_font_size.'" name="grid_wud_but_font_size" onchange="wud_box3.value = wud_sizer3.value" oninput="wud_box3.value = wud_sizer3.value" /></dd></dl><br>';
				
		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Text for the read more button on archive, category, tags pages (See: <b>Activate grid Pages</b>).<br>If empty we show a [+] sign, otherwise the text you entered here. ", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Archive: read more button or text", "grid-wud").'</b><br>';
		echo '<i>'.__("Empty = button", "grid-wud").' </i><b>[+]</b>  : <input type="text" class="grid-wud-right" name="grid_wud_show_arch_button" value="'.$grid_wud_show_arch_button.'" /><br><br><br>';

		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Text for the read more button on pages containing our short code.<br>If empty we show a [+] sign, otherwise the text you entered here. ", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("grid: read more button or text", "grid-wud").'</b><br>';
		echo '<i>'.__("Empty = button", "grid-wud").' </i><b>[+]</b> : <input type="text" class="grid-wud-right" name="grid_wud_show_grid_button" value="'.$grid_wud_show_grid_button.'" /><br><br><hr>';
		
		echo '<select name="grid_wud_my_css" class="grid-wud-right" >';
		echo     '<option value="grid-wud"'; if ( $grid_wud_my_css == "grid-wud" ){echo 'selected="selected"';} echo '>Standard</option>';
		echo     '<option value="grid-wud-square"'; if ( $grid_wud_my_css == "grid-wud-square" ){echo 'selected="selected"';} echo '>Square</option>';
		echo     '<option value="grid-wud-blocks"'; if ( $grid_wud_my_css == "grid-wud-blocks" ){echo 'selected="selected"';} echo '>Blocks</option>';
		echo     '<option value="grid-wud-circle"'; if ( $grid_wud_my_css == "grid-wud-circle" ){echo 'selected="selected"';} echo '>Circle</option>';
		echo     '<option value="grid-wud-photos"'; if ( $grid_wud_my_css == "grid-wud-photos" ){echo 'selected="selected"';} echo '>Photo\'s</option>';
		echo     '<option value="grid-wud-horizon"'; if ( $grid_wud_my_css == "grid-wud-horizon" ){echo 'selected="selected"';} echo '>Horizon</option>';
		echo     '<option value="grid-wud-mixed"'; if ( $grid_wud_my_css == "grid-wud-mixed" ){echo 'selected="selected"';} echo '>Mixed</option>';
		echo '</select>';		
		echo '<b class="grid-wud-admin-title">'.__("Lay-out grid/grids", "grid-wud").'</b>';
		echo '<i>'.__("Choose lay-out", "grid-wud").': </i>';		
		echo '<br><br>';


		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Enter the number of grid to be displayed , for each entered short code.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Number of grid to show", "grid-wud").'</b>
		<dl><dt><label for="wud_box4">'.__("Maximum", "grid-wud").'</label>&nbsp;&nbsp;</dt>
		<dd><input size="2" id="wud_box4" type="text" style="font-weight:bolder;" value="'.$grid_wud_set_max_grid.'" readonly/></dd>
		<dt><label for="wud_sizer4"></label></dt>
		<dd><input class="grid-wud-right" id="wud_sizer4" type="range" min="4" max="20" step="1" value="'.$grid_wud_set_max_grid.'" name="grid_wud_set_max_grid" onchange="wud_box4.value = wud_sizer4.value" oninput="wud_box4.value = wud_sizer4.value" /></dd></dl><br>';


		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Enter the number of extra grid to be displayed , after clicking on the read more button.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Show more grid button", "grid-wud").'</b>
		<label for="wud_box5">'.__("Number of extra grid to show", "grid-wud").'</label>&nbsp;&nbsp;<br>
		<dl><dd><input size="2" id="wud_box5" type="text" style="font-weight:bolder;" value="'.$grid_wud_set_more_grid.'" readonly/></dd>
		<dt><label for="wud_sizer5"></label></dt>
		<dd><input class="grid-wud-right" id="wud_sizer5" type="range" min="2" max="10" step="2" value="'.$grid_wud_set_more_grid.'" name="grid_wud_set_more_grid" onchange="wud_box5.value = wud_sizer5.value" oninput="wud_box5.value = wud_sizer5.value" /></dd></dl><hr>';

			
		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("If <b>Activate grid Pages</b> is not activated, show the read more result as archive pages (standard) or as grid.", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Target: read more button", "grid-wud").'</b><br>';
		echo '<select name="grid_wud_show_arch_grid" class="grid-wud-right" >';
		echo     '<option value="0"'; if ( $grid_wud_show_arch_grid == "0" ){echo 'selected="selected"';} echo '>'.__("Archive", "grid-wud").'</option>';
		echo     '<option value="1"'; if ( $grid_wud_show_arch_grid == "1" ){echo 'selected="selected"';} echo '>'.__("grid", "grid-wud").'</option>';
		echo '</select>';		
		echo '<i>'.__("Archive or grid", "grid-wud").': </i>';	
		echo '<br><br><br>';

		echo '<select name="grid_wud_set_order_grid" class="grid-wud-right" >';
		echo     '<option value="date"'; if ( $grid_wud_set_order_grid == "date" ){echo 'selected="selected"';} echo '>'.__("Date", "grid-wud").'</option>';
		echo     '<option value="name"'; if ( $grid_wud_set_order_grid == "name" ){echo 'selected="selected"';} echo '>'.__("Name", "grid-wud").'</option>';
		echo     '<option value="ID"'; if ( $grid_wud_set_order_grid == "ID" ){echo 'selected="selected"';} echo '>'.__("Post ID", "grid-wud").'</option>';
		echo '</select>';		
		echo '<b class="grid-wud-admin-title">'.__("Order by", "grid-wud").'</b>';
		echo '<i>'.__("Order grid by", "grid-wud").': </i>';		
		echo '<br><br><br>';
		
		echo '<select name="grid_wud_set_dir_grid" class="grid-wud-right" >';
		echo     '<option value="ASC"'; if ( $grid_wud_set_dir_grid == "ASC" ){echo 'selected="selected"';} echo '>'.__("Ascending", "grid-wud").'</option>';
		echo     '<option value="DESC"'; if ( $grid_wud_set_dir_grid == "DESC" ){echo 'selected="selected"';} echo '>'.__("Descending", "grid-wud").'</option>';;
		echo '</select>';		
		echo '<b class="grid-wud-admin-title">'.__("Order direction", "grid-wud").'</b>';
		echo '<i>'.__("Sort order grid", "grid-wud").': </i>';		
		echo '<br><br><hr>';

		echo '<select name="grid_wud_show_excerpt" class="grid-wud-right" >';
		echo     '<option value="0"'; if ( $grid_wud_show_excerpt == "0" ){echo 'selected="selected"';} echo '>'.__("Show not", "grid-wud").'</option>';
		echo     '<option value="1"'; if ( $grid_wud_show_excerpt == "1" ){echo 'selected="selected"';} echo '>'.__("Without title", "grid-wud").'</option>';
		echo     '<option value="2"'; if ( $grid_wud_show_excerpt == "2" ){echo 'selected="selected"';} echo '>'.__("With title", "grid-wud").'</option>';
		echo     '<option value="3"'; if ( $grid_wud_show_excerpt == "3" ){echo 'selected="selected"';} echo '>'.__("Show always", "grid-wud").'</option>';
		echo '</select>';		
		echo '<b class="grid-wud-admin-title">'.__("The excerpt", "grid-wud").'</b>';
		echo '<i>'.__("Show/Hide ...", "grid-wud").': </i>';	
		echo '<br><br>';

		echo '<i>'.__("Maximum words", "grid-wud").' (10 -> 50) : </i><input type="number" min="10" step="1" max="50" size="8" class="grid-wud-right" name="grid_wud_excerpt_words" value="'.$grid_wud_excerpt_words.'" /><br><br><hr>';


		echo'<div id="grid-wud-tip"><b class="grid-trigger" style="float:right; background:#3A6779; color: white;">&nbsp;?&nbsp;</b><div class="tooltip">'.__("Depending the order of grid, skip X posts/pages.<br>Sample: order by: date, direction: descending = skip X newest posts/pages. ", "grid-wud").'</div></div>';
		echo '<b class="grid-wud-admin-title">'.__("Skip x posts", "grid-wud").'</b><br>
		<label for="wud_box6">'.__("Quantity post to skip", "grid-wud").'</label>&nbsp;&nbsp;<br>
		<dl><dd><input size="2" id="wud_box6" type="text" style="font-weight:bolder;" value="'.$grid_wud_skip_post.'" readonly/></dd>
		<dt><label for="wud_sizer6"></label></dt>
		<dd><input class="grid-wud-right" id="wud_sizer6" type="range" min="0" max="20" step="1" value="'.$grid_wud_skip_post.'" name="grid_wud_skip_post" onchange="wud_box6.value = wud_sizer6.value" oninput="wud_box6.value = wud_sizer6.value" /></dd></dl><br>';

		
		echo '</div><div class="clear"></div>';
		echo '<div><br>';	
		echo '<input type="submit" name="Submit" class="button-primary" id="grid-wud-adm-subm" value="'.__("Save Changes", "grid-wud").'" />';
		//Form send
		echo "</form>";
		echo '<a href="http://wistudat.be" class="button-primary" id="grid-adm-wud" target="_blank">'.__("Visit our website", "grid-wud").'</a>  <a href="https://wordpress.org/support/plugin/grid-wud" class="button-primary" id="grid-adm-wud" target="_blank">'.__("Get FREE Support", "grid-wud").'</a>';
		echo '</div></div>';		
}
?>