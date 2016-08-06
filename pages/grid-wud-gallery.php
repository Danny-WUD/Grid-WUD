<?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	function wud_grid_gallery($attr) {		
		global $gwfuncs;
		$post = get_post();
		$result = NULL;
		//No post data? Return!
		if (!$post){return;}
		
		$gwfuncs['gwcss'] = grid_wud_current_style();
		
		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		// Allow plugins/themes to override the default gallery template.
		$result = apply_filters('post_gallery', '', $attr);
		if ( $result != '' )
			return $result;

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}


		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr));

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';


		$float = is_rtl() ? 'right' : 'left';

		$result .= "<!-- Grid WUD Version ".$gwfuncs['grid_wud_version']."-->";
		$result .= "<div id='grid_wud_fade_home' class='no-js' ><div class='grid-wud-container' style='width:".$gwfuncs['grid_wud_width']."% !important; font-family:".$gwfuncs['grid_wud_font_header']." !important;'>";
			
		$wud_feat_image=NULL;
		
		$i = 0;
		$wud_grid_nr = 1; //1-> one grid, 2-> four grid, 3-> five grid (total 20 grid)
		foreach ( $attachments as $id => $attachment ) {
			if ($wud_grid_nr>20){$wud_grid_nr=1;}
			if ($wud_grid_nr>50){break;}
				if($gwfuncs['grid_wud_thumb_gallery']==1){$image_thumb   = wp_get_attachment_image_src( $id, 'thumbnail' );}
				elseif($gwfuncs['grid_wud_thumb_gallery']==2){$image_thumb   = wp_get_attachment_image_src( $id, 'medium' );}
				else{$image_thumb   = wp_get_attachment_image_src( $id, 'large' );}
				$wud_feat_image = $image_thumb[0];
				$wud_feat_imagefat   = wp_get_attachment_url( $id );
			
		if (trim($attachment->post_excerpt) ) {
			$wud_excerpt= wptexturize($attachment->post_excerpt);
		}
		else{
			$wud_excerpt= $post->post_title;
		}
	//URL START	

    if($gwfuncs['grid_wud_url_gallery']==1 || $gwfuncs['grid_wud_lb_gallery']==1){	
	  $result .= "<a href='".get_attachment_link( $id )."' wud-lb='".$wud_feat_imagefat."' title='' alt='' >";
	}
	
				//Category font/line height on a grid grid_wud_img_split
				$h4font=1;
				$h4height=1.1;
			
			//-> Wrapper-start
			
			//CIRCLE ***
			if($gwfuncs['gwcss'] == "4" ){
						//shadow
						if($gwfuncs['grid_wud_shadow']==1){
						$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
						}
						//no shadow
						else{
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
						}						
			}
			
			//SQUARE ***
			else{
						if($gwfuncs['grid_wud_shadow']==1){
						$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 	
						}
						//no shadow
						else{
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 	
						}						
				}					
				

			
			//-> Image-start & end
			if($gwfuncs['gwcss'] == "4" ){
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; '></div>";
			}
			else{
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); '></div>";
			}			
						

			//-> The excerpt text
			if ($gwfuncs['gwcss'] <> "4" ){
				// Show excerpt text
				if($gwfuncs['grid_wud_show_excerpt']=='1'){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']."; !important; '>".$wud_excerpt."</div>";	
				}
				// Show excerpt text and title
				elseif ($gwfuncs['grid_wud_show_excerpt']==2 ){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; '>".$wud_excerpt."</div>";					
				}
				// Show excerpt text and title allways
				elseif ($gwfuncs['grid_wud_show_excerpt']==3 ){
					$result .= "<div class='grid-wud-excerpt-2' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; '>".$wud_excerpt."</div>";						
				}
				// Show excerpt title
				elseif ($gwfuncs['grid_wud_show_excerpt']==4 ){
					$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; '><b>".$post->post_title."</b></div>";						
				}				
			}
			else{
					if($gwfuncs['grid_wud_show_excerpt']=='1'){
						$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'>".$wud_excerpt."</div>";	
					}
					// Show excerpt text and title
					elseif ($gwfuncs['grid_wud_show_excerpt']==2 ){
						$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'>".$wud_excerpt."</div>";					
					}
					// Show excerpt text and title allways
					elseif ($gwfuncs['grid_wud_show_excerpt']==3 ){
						$result .= "<div class='grid-wud-excerpt-2' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'>".$wud_excerpt."</div>";						
					}
					// Show excerpt title
					elseif ($gwfuncs['grid_wud_show_excerpt']==4 ){
						if($gwfuncs['grid_wud_title_topmid']<>4){
						$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b></div>";						
						}
						else{
						$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b></div>";							
						}
					}					
				}
			
		//-> Wrapper-end
					$result .= "</div>"; 
					$wud_grid_nr++; 
					
		}
		
		$result .= "</div><div>\n";
	//URL END
	if($gwfuncs['grid_wud_url_gallery']==1 || $gwfuncs['grid_wud_lb_gallery']==1){
      $result .= "</a>";
	}
	if($gwfuncs['grid_wud_lb_gallery']==1){
      $result .= "<script src='http://code.jquery.com/jquery-latest.min.js'></script>";
	}	
	$result .= "<div class='clear'></div>"; 
	$result .= "<div class='grid-wud-bottom'></div></div></div>";
		return $result;
}	
	
?>	