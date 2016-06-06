<?php
/*
=== Grid WUD ===
Contributors: wistudat.be
Plugin Name: Grid WUD
Donate Reason: Stand together to help those in need!
Donate link: https://www.icrc.org/eng/donations/
Description: Grid WUD adds responsive, customizable and dynamic grids to WordPress posts and pages.
Author: Danny WUD
Author URI: http://wistudat.be/
Plugin URI: http://wistudat.be/
Tags: grid, grids, youtube, vimeo, video, gallery, responsive, slug, shortcode, slugs, post grids, post grid, image grid, filter, display, list, page, pages, posts, post, query, custom post type
Requires at least: 3.6
Tested up to: 4.5
Stable tag: 1.0.4
Version: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: grid-wud
Domain Path: /languages
*/
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//==============================================================================//
$version='1.0.4';
// Store the latest version.
if (get_option('grid_wud_version')!=$version) {update_option('grid_wud_version', $version);}
//==============================================================================//
	
	define( 'GRID_WUD_DIR', plugin_dir_path( __FILE__ ) );
	define( 'WUD_GRID_URL', plugin_dir_url( __FILE__ ) );
// grid-wud Actions
	//Site
	add_shortcode( 'gridwud', 'grid_wud_comm' );
	add_action( 'wp_enqueue_scripts', 'grid_wud_styles' );
	add_action('plugins_loaded', 'grid_wud_languages');
	add_action( 'plugins_loaded', 'grid_wud_admin' );
	add_action( 'plugins_loaded', 'grid_wud_base' );
	add_action( 'template_redirect', 'grid_wud_go_to_my_url');
	add_action( 'init', 'grid_wud_funcs' );
	register_activation_hook( __FILE__, 'grid_wud_activate' );
	//Admin
	add_action('admin_enqueue_scripts', 'grid_wud_style_more');
	add_action('admin_menu', 'grid_wud_submenu_page');
	add_filter( 'plugin_action_links', 'grid_wud_action_links', 10, 5 );

	
// grid-wud style, called from short code
	function grid_wud_current_style() {
		global $gwfuncs;
		if($gwfuncs['grid_wud_my_css']=="grid-wud"){return $todo = 1;}
		if($gwfuncs['grid_wud_my_css']=="grid-wud-square"){return $todo = 2;}	
		if($gwfuncs['grid_wud_my_css']=="grid-wud-blocks"){return $todo = 3;}		
		if($gwfuncs['grid_wud_my_css']=="grid-wud-circle"){return $todo = 4;}		
		if($gwfuncs['grid_wud_my_css']=="grid-wud-photos"){return $todo = 5;}	
		if($gwfuncs['grid_wud_my_css']=="grid-wud-horizon"){return $todo = 6;}	
		if($gwfuncs['grid_wud_my_css']=="grid-wud-mixed"){return $todo = 7;}		
		else{return $todo = 1;}
	}
// grid-wud style
	function grid_wud_styles() {	
// Register default Style	
	global $gwfuncs;
	//Use the default style
	 wp_register_style( 'grid_wud_style', plugins_url('css/grid-wud.css', __FILE__ ), false, '1.0.3' );
	 wp_enqueue_style( 'grid_wud_style' );		 
	 wp_register_style( 'grid_wud_style_hover', plugins_url('css/grid-wud-base-hover.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_img_hover']=='1'){wp_enqueue_style( 'grid_wud_style_hover' );}
	 wp_register_style( 'grid_wud_style_grey', plugins_url('css/grid-wud-base-grey.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_img_grey']=='1'){wp_enqueue_style( 'grid_wud_style_grey' );}	 
// Javascript + extra page (read more page).
	  wp_enqueue_script('jquery');
	  wp_register_script('grid_wud_script', plugins_url( 'js/grid-wud.js', __FILE__ ), array('jquery'), '1.0.1', true );
	  wp_enqueue_script('grid_wud_script');
	// Fade out/in option	  
	if (get_option('grid_wud_fade_in')=='1'){
	  wp_register_script('grid_wud_fade', plugins_url( 'js/grid-wud-fade.js', __FILE__ ), array('jquery'), '1.0.1', true );
	  wp_enqueue_script('grid_wud_fade');
	} 	 
	//Extra grid button result
	  wp_localize_script('grid_wud_script', 'grid_wud_php', array('grid_wud_url' => plugins_url( 'pages/grid-wud-xtra.php', __FILE__ ),));
	}
// grid-wud languages
	function grid_wud_languages() {
			load_plugin_textdomain( 'grid-wud', false, dirname(plugin_basename( __FILE__ ) ) . '/languages' );
	}

// grid-wud options page (settings menu option)
	function grid_wud_submenu_page() {
		add_options_page( 'Grid WUD', 'Grid WUD', 'manage_options', 'grid-wud', 'grid_wud_options_notice' );
	}

// grid-wud options page (menu options by plugins)
	function grid_wud_action_links( $actions, $grid_wud_set ) 
	{
		static $plugin;
		if (!isset($plugin))
			$plugin = plugin_basename(__FILE__);
		if ($plugin == $grid_wud_set) {
				$settings_page = array('settings' => '<a href="options-general.php?page=grid-wud">' . __('Settings', 'General') . '</a>');
				$support_link = array('support' => '<a href="https://wordpress.org/support/plugin/grid-wud" target="_blank">Support</a>');				
					$actions = array_merge($support_link, $actions);
					$actions = array_merge($settings_page, $actions);
			}			
			return $actions;
	}

	function grid_wud_style_more($hook) {
	if   ( $hook == "settings_page_grid-wud" ) {
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style( 'cs-wp-color-picker', plugins_url( 'css/cs-wp-color-picker.css', __FILE__ ), array( 'wp-color-picker' ), '1.0.1', 'all' );
		wp_enqueue_style( 'grid_wud_style' );
		wp_enqueue_style( 'grid_wud_style', plugins_url('css/admin.css', __FILE__ ), false, '1.0.3' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'cs-wp-color-picker', plugins_url( 'js/cs-wp-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), '1.0.1', true );	
		wp_enqueue_media();
		wp_register_script( 'media-grid-uploader-js', plugins_url( 'js/admin_script.js' , __FILE__ ), array('jquery') );
		wp_enqueue_script( 'media-grid-uploader-js' );
     }
	}

	  	
//Load extra grid page  
	function grid_wud_admin() {require_once( GRID_WUD_DIR . '/pages/grid-wud-admin.php' );}
	
//Load base grid page
	function grid_wud_base() {require_once( GRID_WUD_DIR . '/pages/grid-wud-base.php' );}

//Declare once all Grid WUD settings 	
	function grid_wud_funcs(){
		//Set it global
		global $gwfuncs;
		//Remember the settings (output=$gwfuncs['grid_wud_my_css'];)
		$gwfuncs = array(
			'gwcss' => '0',
			'grid_wud_my_css' => get_option('grid_wud_my_css'),
			'grid_wud_cat_bcolor' => get_option('grid_wud_cat_bcolor'),
			'grid_wud_cat_fcolor' => get_option('grid_wud_cat_fcolor'),
			'grid_wud_h1_font_size' => get_option('grid_wud_h1_font_size'),
			'grid_wud_set_featured_img' => get_option('grid_wud_set_featured_img'),
			'grid_wud_set_max_grid' => get_option('grid_wud_set_max_grid'),
			'grid_wud_set_more_grid' => get_option('grid_wud_set_more_grid'),
			'grid_wud_hide_cat_tag_header' => get_option('grid_wud_hide_cat_tag_header'),
			'grid_wud_hide_grid_cat' => get_option('grid_wud_hide_grid_cat'),
			'grid_wud_show_excerpt' => get_option('grid_wud_show_excerpt'),
			'grid_wud_show_arch_button' => get_option('grid_wud_show_arch_button'),
			'grid_wud_show_grid_button' => get_option('grid_wud_show_grid_button'),
			'grid_wud_show_arch_grid' => get_option('grid_wud_show_arch_grid'),
			'grid_wud_set_order_grid' => get_option('grid_wud_set_order_grid'),
			'grid_wud_set_dir_grid' => get_option('grid_wud_set_dir_grid'),
			'grid_wud_but_bcolor' => get_option('grid_wud_but_bcolor'),
			'grid_wud_but_fcolor' => get_option('grid_wud_but_fcolor'),
			'grid_wud_but_font_size' => get_option('grid_wud_but_font_size'),
			'grid_wud_excerpt_words' => get_option('grid_wud_excerpt_words'),
			'grid_wud_fade_in' => get_option('grid_wud_fade_in'),
			'grid_wud_skip_post' => get_option('grid_wud_skip_post'),
			'grid_wud_version' => get_option('grid_wud_version'),
			'grid_wud_cpt01' => get_option('grid_wud_cpt01'),
			'grid_wud_cpt02' => get_option('grid_wud_cpt02'),
			'grid_wud_def_img' => get_option('grid_wud_def_img'),
			'grid_wud_img_hover' => get_option('grid_wud_img_hover'),
			'grid_wud_img_grey' => get_option('grid_wud_img_grey')
			);
			return $gwfuncs;
		}

 
//Include /grid-wud-content.php instead using the Wordpress default: /tag/ or /category/
	function grid_wud_go_to_my_url(){
		global $catid, $tagid, $gwfuncs;
		//Redirect only if parameter 'grid_wud_show_arch_grid' is set to 1
		if(($gwfuncs['grid_wud_show_arch_grid']==1 && isset( $_GET['g'] ) && !empty( $_GET['g'] ))){

				if( is_category() && (is_archive() || !is_front_page() || !is_home() || !is_single() || !is_singular() )){
					$catid = get_query_var('cat');
					$tagid = '';
					include (GRID_WUD_DIR . 'pages/grid-wud-content.php');
					exit();				
				}

				if( is_tag()  && (is_archive() || !is_front_page() || !is_home() || !is_single() || !is_singular() )){
					$tags = single_tag_title("", false);
					$tagid = get_term_by('slug', $tags, 'post_tag');
					$tagid = $tagid->term_id;
					$catid = '';
					include (GRID_WUD_DIR . 'pages/grid-wud-content.php');
					exit();
				}	 
		}
	}		
	
		
	
//Standard values only inserted on activation.
	function grid_wud_activate() {		
		if (get_option('grid_wud_my_css')=='') {update_option('grid_wud_my_css', 'grid-wud');}
		if (get_option('grid_wud_cat_bcolor')=='') {update_option('grid_wud_cat_bcolor', '#FFFFFF');}
		if (get_option('grid_wud_cat_fcolor')=='') {update_option('grid_wud_cat_fcolor', '#CCCCCC');}
		if (get_option('grid_wud_h1_font_size')=='') {update_option('grid_wud_h1_font_size', '1.4');}
		if (get_option('grid_wud_set_featured_img')=='') {update_option('grid_wud_set_featured_img', 1);}
		if (get_option('grid_wud_set_max_grid')=='') {update_option('grid_wud_set_max_grid', 5);}
		if (get_option('grid_wud_set_more_grid')=='') {update_option('grid_wud_set_more_grid', 2);}
		if (get_option('grid_wud_hide_cat_tag_header')=='') {update_option('grid_wud_hide_cat_tag_header', 0);}
		if (get_option('grid_wud_hide_grid_cat')=='') {update_option('grid_wud_hide_grid_cat', 0);}
		if (get_option('grid_wud_show_excerpt')=='') {update_option('grid_wud_show_excerpt', 3);}
		if (get_option('grid_wud_show_arch_button')=='') {update_option('grid_wud_show_arch_button', 'Read More ...');}
		if (get_option('grid_wud_show_grid_button')=='') {update_option('grid_wud_show_grid_button', 'Read More ...');}
		if (get_option('grid_wud_show_arch_grid')=='') {update_option('grid_wud_show_arch_grid', 1);}
		if (get_option('grid_wud_set_order_grid')=='') {update_option('grid_wud_set_order_grid', 'date');}
		if (get_option('grid_wud_set_dir_grid')=='') {update_option('grid_wud_set_dir_grid', 'DESC');}
		if (get_option('grid_wud_but_bcolor')=='') {update_option('grid_wud_but_bcolor', '#FFFFFF');}
		if (get_option('grid_wud_but_fcolor')=='') {update_option('grid_wud_but_fcolor', '#CCCCCC');}
		if (get_option('grid_wud_but_font_size')=='') {update_option('grid_wud_but_font_size', '1.4');}
		if (get_option('grid_wud_excerpt_words')=='') {update_option('grid_wud_excerpt_words', 25);}
		if (get_option('grid_wud_skip_post')=='') {update_option('grid_wud_skip_post', 0);}
		if (get_option('grid_wud_fade_in')=='') {update_option('grid_wud_fade_in', 1);}
		if (get_option('grid_wud_cpt01')=='') {update_option('grid_wud_cpt01', 'Custom Post Type 01');}
		if (get_option('grid_wud_cpt02')=='') {update_option('grid_wud_cpt02', 'Custom Post Type 02');}
		if (get_option('grid_wud_def_img')=='') {update_option('grid_wud_def_img', plugins_url('images/empty-grid.png', __FILE__ ));}
		if (get_option('grid_wud_img_hover')=='') {update_option('grid_wud_img_hover', 1);}
		if (get_option('grid_wud_img_grey')=='') {update_option('grid_wud_img_grey', 1);}
	}
	
?>