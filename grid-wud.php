<?php
/*
=== Grid WUD ===
Contributors: wistudat.be
Plugin Name: Grid WUD
Donate Reason: Stand together to help those in need!
Donate link: https://www.icrc.org/eng/donations/
Description: Grid WUD adds responsive, customizable and dynamic grids, tiles, galleries & widgets to WordPress posts and pages.
Author: Danny WUD
Author URI: http://wistudat.be/
Plugin URI: http://wistudat.be/
Tags: grid, grids, latest post, youtube, vimeo, video, gallery, responsive, slug, shortcode, slugs, post grids, post grid, image grid, filter, display, list, page, pages, posts, post, query, custom post type
Requires at least: 3.6
Tested up to: 4.5
Stable tag: 1.2.1
Version: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: grid-wud
Domain Path: /languages
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//==============================================================================//
$version='1.2.1';
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
	add_action( 'init', 'grid_wud_update' );
	add_action( 'init', 'grid_wud_funcs' );
	register_activation_hook( __FILE__, 'grid_wud_activate' );
	//Admin
	add_action('admin_enqueue_scripts', 'grid_wud_style_more');
	add_action('admin_menu', 'grid_wud_submenu_page');
	add_filter( 'plugin_action_links', 'grid_wud_action_links', 10, 5 );
	//Add short code to widgets
	add_filter( 'widget_text', 'wud_widget_text', 1, 2 );

	
// WUD GRID GALLERY 
	global $gwfuncs;
	grid_wud_funcs();
	if($gwfuncs['grid_wud_act_gallery']=='1'){
		add_action( 'plugins_loaded', 'grid_wud_gallery' );
		add_action( 'after_setup_theme', 'grid_wud_galleries' );
		}

//WUD GRID WIDGET STYLE		
    function wud_widget_text( $widget_text, $instance )
    {
		global $gwfuncs, $grid_wud_widget;
        $tag = 'gridwud';
        if ( has_shortcode( $instance['text'], $tag ) )
            $grid_wud_widget=1;
        else
            $grid_wud_widget=0;
        return $widget_text;
    }
	
// grid-wud-remove-original-wp-gallery, if WUD GRID GALLERY is activated
	function grid_wud_gallery() {
		remove_shortcode( 'gallery' );
		add_shortcode('gallery', 'wud_grid_gallery');  
	}
	
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
		global $gwfuncs, $color, $post;
		//Add short code to widgets
		if($gwfuncs['grid_wud_widgets']=='1'){
			add_filter( 'widget_text', 'shortcode_unautop');
			add_filter( 'widget_text', 'do_shortcode');
		}	
	
	//ONLY USED BY THE DEMO PAGE FROM WUD
	if($post){
		$post_slug=$post->post_name; $color=0;
		if ($post_slug=='wp-tiles-wud-with-sidebar' || $post_slug=='wud-gallery-sample'){
			$gwfuncs['grid_wud_img_split'] = 1;
			$gwfuncs['grid_wud_shadow'] = 1;
			$color=1;
		}
		else{
			$color=0;
		}	
	}
	
	//Use the grids or tiles
	wp_register_style( 'grid_wud_basic', plugins_url('css/grid-wud-base.css', __FILE__ ), false, '1.0.3' );
	
	if($gwfuncs['grid_wud_img_split'] == 0){
		wp_register_style( 'grid_wud_style', plugins_url('css/grid-wud.css', __FILE__ ), false, '1.0.3' );
	}
	else{
		wp_register_style( 'grid_wud_style', plugins_url('css/tiles-wud.css', __FILE__ ), false, '1.0.3' );	
	}
	 wp_enqueue_style( 'grid_wud_basic' );
	 wp_enqueue_style( 'grid_wud_style' );
	 
	 //Optional CSS 
	 wp_register_style( 'grid_wud_style_hover', plugins_url('css/grid-wud-base-hover.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_img_hover']=='1'){wp_enqueue_style( 'grid_wud_style_hover' );}
	 wp_register_style( 'grid_wud_style_center', plugins_url('css/grid-wud-title-center.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_title_pos']=='1'){wp_enqueue_style( 'grid_wud_style_center' );}	
	 wp_register_style( 'grid_wud_style_right', plugins_url('css/grid-wud-title-right.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_title_pos']=='2'){wp_enqueue_style( 'grid_wud_style_right' );}
	 wp_register_style( 'grid_wud_style_top', plugins_url('css/grid-wud-title-top.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_title_topmid']=='1'){wp_enqueue_style( 'grid_wud_style_top' );}
	 wp_register_style( 'grid_wud_style_mid', plugins_url('css/grid-wud-title-mid.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_title_topmid']=='2'){wp_enqueue_style( 'grid_wud_style_mid' );}
	 wp_register_style( 'grid_wud_style_over', plugins_url('css/grid-wud-title-over.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_title_topmid']=='3'){wp_enqueue_style( 'grid_wud_style_over' );}	 
	 wp_register_style( 'grid_wud_style_grey', plugins_url('css/grid-wud-base-grey.css', __FILE__ ), false, '1.0.3' );
	 if($gwfuncs['grid_wud_img_grey']=='1' && $color==0){wp_enqueue_style( 'grid_wud_style_grey' );}	 
	 
	// Javascript read more page.
	  wp_enqueue_script('jquery');
	  wp_register_script('grid_wud_script', plugins_url( 'js/grid-wud.js', __FILE__ ), array('jquery'), '1.0.1', true );
	  wp_enqueue_script('grid_wud_script');
	  
	// Fade out/in option	  
	if (get_option('grid_wud_fade_in')=='1'){
	  wp_register_script('grid_wud_fade', plugins_url( 'js/grid-wud-fade.js', __FILE__ ), array('jquery'), '1.0.1', true );
	  wp_enqueue_script('grid_wud_fade');
	} 
		  
	// WUD Light Box option	  
	if (get_option('grid_wud_lb_gallery')=='1'){
	  wp_register_script('grid_wud_light_box', plugins_url( 'js/grid-wud-lightbox.js', __FILE__ ), array('jquery'), '1.0.1', true );
	  wp_enqueue_script('grid_wud_light_box');
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

// Color picker and media uploader for admin
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

// Search the image in the database
function wud_get_image_id($image_url) {
	global $wpdb;
	$wud_attach = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $wud_attach[0]; 
}
	  	
//Load extra grid page  
	function grid_wud_admin() {require_once( GRID_WUD_DIR . '/pages/grid-wud-admin.php' );}
	
//Load base grid page
	function grid_wud_base() {require_once( GRID_WUD_DIR . '/pages/grid-wud-base.php' );}

//Load gallery grid page
	function grid_wud_galleries() {require_once( GRID_WUD_DIR . '/pages/grid-wud-gallery.php' );}
	


// New fields from version 1.0.5 on 
	function grid_wud_update(){
		if (get_option('grid_wud_round_img')=='') {update_option('grid_wud_round_img', 0);}
		if (get_option('grid_wud_round_button')=='') {update_option('grid_wud_round_button', 0);}
		if (get_option('grid_wud_font_header')=='') {update_option('grid_wud_font_header', 'inherit');}
		if (get_option('grid_wud_font_excerpt')=='') {update_option('grid_wud_font_excerpt', 'inherit');}
		if (get_option('grid_wud_font_button')=='') {update_option('grid_wud_font_button', 'inherit');}
		if (get_option('grid_wud_title_pos')=='') {update_option('grid_wud_title_pos', 0);}
		if (get_option('grid_wud_title_topmid')=='') {update_option('grid_wud_title_topmid', 0);}
		if (get_option('grid_wud_cat_url')=='') {update_option('grid_wud_cat_url', 0);}
		if (get_option('grid_wud_widgets')=='') {update_option('grid_wud_widgets', 1);}
		if (get_option('grid_wud_img_split')=='') {update_option('grid_wud_img_split', 0);}
		if (get_option('grid_wud_news_title')=='') {update_option('grid_wud_news_title', 'Latest News');}
		if (get_option('grid_wud_nourl')=='') {update_option('grid_wud_nourl', 0);}
		if (get_option('grid_wud_shadow')=='') {update_option('grid_wud_shadow', 0);}
		if (get_option('grid_wud_act_gallery')=='') {update_option('grid_wud_act_gallery', 0);}
		if (get_option('grid_wud_url_gallery')=='') {update_option('grid_wud_url_gallery', 1);}
		if (get_option('grid_wud_lb_gallery')=='') {update_option('grid_wud_lb_gallery', 0);}
		if (get_option('grid_wud_thumb_gallery')=='') {update_option('grid_wud_thumb_gallery', 0);}
		if (get_option('grid_wud_thumb_img')=='') {update_option('grid_wud_thumb_img', 0);}
		if (get_option('grid_wud_width')=='') {update_option('grid_wud_width', 100);}
	}
	
//Declare once all Grid WUD settings 	
	function grid_wud_funcs(){
		//Set it global
		global $gwfuncs;
		//Remember the settings (output=$gwfuncs['grid_wud_my_css'];)
		//gwcss is used to switch the grid style
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
			'grid_wud_img_grey' => get_option('grid_wud_img_grey'),
			'grid_wud_img_split' => get_option('grid_wud_img_split'),
			'grid_wud_round_img' => get_option('grid_wud_round_img'),
			'grid_wud_round_button' => get_option('grid_wud_round_button'),
			'grid_wud_font_header' => get_option('grid_wud_font_header'),
			'grid_wud_font_excerpt' => get_option('grid_wud_font_excerpt'),
			'grid_wud_font_button' => get_option('grid_wud_font_button'),
			'grid_wud_title_pos' => get_option('grid_wud_title_pos'),
			'grid_wud_title_topmid' => get_option('grid_wud_title_topmid'),
			'grid_wud_cat_url' => get_option('grid_wud_cat_url'),
			'grid_wud_widgets' => get_option('grid_wud_widgets'),
			'grid_wud_news_title' => get_option('grid_wud_news_title'),
			'grid_wud_nourl' => get_option('grid_wud_nourl'),
			'grid_wud_shadow' => get_option('grid_wud_shadow'),
			'grid_wud_act_gallery' => get_option('grid_wud_act_gallery'),
			'grid_wud_url_gallery' => get_option('grid_wud_url_gallery'),
			'grid_wud_lb_gallery' => get_option('grid_wud_lb_gallery'),
			'grid_wud_thumb_gallery' => get_option('grid_wud_thumb_gallery'),
			'grid_wud_thumb_img' => get_option('grid_wud_thumb_img'),
			'grid_wud_width' => get_option('grid_wud_width')
			);
			return $gwfuncs;
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
		if (get_option('grid_wud_img_split')=='') {update_option('grid_wud_img_split', 0);}
		if (get_option('grid_wud_round_img')=='') {update_option('grid_wud_round_img', 0);}
		if (get_option('grid_wud_round_button')=='') {update_option('grid_wud_round_button', 0);}
		if (get_option('grid_wud_font_header')=='') {update_option('grid_wud_font_header', 'inherit');}
		if (get_option('grid_wud_font_excerpt')=='') {update_option('grid_wud_font_excerpt', 'inherit');}
		if (get_option('grid_wud_font_button')=='') {update_option('grid_wud_font_button', 'inherit');}
		if (get_option('grid_wud_title_pos')=='') {update_option('grid_wud_title_pos', 0);}
		if (get_option('grid_wud_cat_url')=='') {update_option('grid_wud_cat_url', 0);}
		if (get_option('grid_wud_widgets')=='') {update_option('grid_wud_widgets', 1);}
		if (get_option('grid_wud_news_title')=='') {update_option('grid_wud_news_title', 'Latest News');}
		if (get_option('grid_wud_nourl')=='') {update_option('grid_wud_nourl', 0);}
		if (get_option('grid_wud_shadow')=='') {update_option('grid_wud_shadow', 0);}
		if (get_option('grid_wud_act_gallery')=='') {update_option('grid_wud_act_gallery', 0);}
		if (get_option('grid_wud_url_gallery')=='') {update_option('grid_wud_url_gallery', 1);}
		if (get_option('grid_wud_lb_gallery')=='') {update_option('grid_wud_lb_gallery', 0);}
		if (get_option('grid_wud_thumb_gallery')=='') {update_option('grid_wud_thumb_gallery', 0);}
		if (get_option('grid_wud_thumb_img')=='') {update_option('grid_wud_thumb_img', 0);}
		if (get_option('grid_wud_width')=='') {update_option('grid_wud_width', 100);}
	}
	
?>