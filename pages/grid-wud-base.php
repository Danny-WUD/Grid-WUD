<?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 */
function grid_wud_comm( $atts ) {	
	// Attributes
	extract( shortcode_atts(array('slug' => '','grid' => '','button' => '','cp' => '','shape' => ''), $atts ));
	//Remember the CSS ...
    
	$result = NULL; 
	global $gwfuncs;


		//Show the style
		if(isset($atts["shape"]) && $atts["shape"]!='' ){
			if(is_numeric($atts["shape"]) && $atts["shape"] > 0 && $atts["shape"] == round($atts["shape"], 0)){
				$gwfuncs['gwcss'] = $atts["shape"];
				if($gwfuncs['gwcss'] > 7){$gwfuncs['gwcss'] = 1;}
			}
			//If EMPTY shape is entered: use the global default value
			else{
				$gwfuncs['gwcss'] = grid_wud_current_style();
			}
		}
		//If shape is NOT USED: use the global default value
		else{
			$gwfuncs['gwcss'] = grid_wud_current_style();
		}
			
// Read the Array data (Category or Tag)
	if(isset($atts["slug"]) && $atts["slug"]!='' ){
		//Make var empty
		$wud_quantity=0; 
		$grid_wud_skip_post=$gwfuncs['grid_wud_skip_post'];
		$grid_wud_button=0; 
		$wud_post_type=0;
		
		//Show the button (yes/no)
		if(isset($atts["button"]) && $atts["button"]!='' ){
			if(is_numeric($atts["button"]) && $atts["button"] > 0 && $atts["button"] == round($atts["button"], 0)){
				$grid_wud_button = $atts["button"];
				if($grid_wud_button > 1){$grid_wud_button = 1;}
			}
			//Else use the global default value
			else{
				$grid_wud_button = 0;
			}
		}
		else{
			$wud_quantity = $gwfuncs['grid_wud_set_max_grid'];
		}		
		//grid quantity given by shortcode
		if(isset($atts["grid"]) && $atts["grid"]!='' ){
			if(is_numeric($atts["grid"]) && $atts["grid"] > 0 && $atts["grid"] == round($atts["grid"], 0)){
				$wud_quantity = $atts["grid"];
				if($wud_quantity > 50){$wud_quantity = 50;}
			}
			//Else use the global default value
			else{
				$wud_quantity = $gwfuncs['grid_wud_set_max_grid'];
			}
		}
		else{
			$wud_quantity = $gwfuncs['grid_wud_set_max_grid'];
		}
	  $posts = null;

		//Custom Post
		if (isset($atts["cp"]) && ($atts["cp"]=="1" || $atts["cp"]=="2")){
		$term = post_type_exists($atts["slug"]);
		if ($term !== 0 && $term !== null) {
			$wud_post_type=1;
			$args = array(
				'posts_per_page'   => -1,
				'offset'   => $grid_wud_skip_post,
				'showposts'       => $wud_quantity,
				'post_type'		   => $atts["slug"],
				'orderby'          => $gwfuncs['grid_wud_set_order_grid'],
				'order'            => $gwfuncs['grid_wud_set_dir_grid']
			);
			$posts = get_posts( $args );
			} 
		}
		
		//Category
		$term = term_exists($atts["slug"], 'category');
		if ($term !== 0 && $term !== null) {
			$args = array(
				'posts_per_page'   => -1,
				'offset'   => $grid_wud_skip_post,
				'showposts'       => $wud_quantity,
				'post_type'		   => 'post',
				'tax_query'		   => array(array('taxonomy' => 'category', 'field' => 'slug', 'terms' => array($atts["slug"]))),
				'orderby'          => $gwfuncs['grid_wud_set_order_grid'],
				'order'            => $gwfuncs['grid_wud_set_dir_grid']
			);
			$posts = get_posts( $args );
			} 
			

		//Tag
			$term = term_exists($atts["slug"], 'post_tag');
			if ($term !== 0 && $term !== null) {	
				$args = array(
				'posts_per_page'   => -1,
				'offset'   => $grid_wud_skip_post,
				'showposts'       => $wud_quantity,
				'post_type'		   => 'post',
				'tax_query'		   => array(array('taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => array($atts["slug"]))),
				'orderby'          => $gwfuncs['grid_wud_set_order_grid'],
				'order'            => $gwfuncs['grid_wud_set_dir_grid']
			);
			$posts = get_posts( $args );
			}

		
//-> Show the grid !

		//if(isset($posts) && 'page' == get_option( 'show_on_front' )){
		if(isset($posts)){
		
		// Remember current slug (cat_or_tag)
		$slugs = $atts["slug"]; 
		$CatIdObj = get_category_by_slug($slugs);  
		$TagIdObj = get_term_by('slug', $slugs, 'post_tag');
	    // Category or Tag Name
			$wud_cat_or_term_name = NULL; // Make the variable empty	
			if (!empty($CatIdObj)){$wud_cat_or_term_name = $CatIdObj->name;}
			if (!empty($TagIdObj)){$wud_cat_or_term_name = $TagIdObj->name;}
			if (empty($wud_cat_or_term_name)){
				if ($atts["cp"]=="1"){$wud_cat_or_term_name=$gwfuncs['grid_wud_cpt01'];}	
				elseif ($atts["cp"]=="2"){$wud_cat_or_term_name=$gwfuncs['grid_wud_cpt02'];}
				else {$wud_cat_or_term_name="No title was found ...";}
			}
		// Category or Tag URL
				if (!empty($CatIdObj)){$cat_id = $CatIdObj->cat_ID; $wud_cat_or_term_url = get_category_link( $cat_id);}
				if (!empty($TagIdObj)){$tag_id = $TagIdObj->term_id; $wud_cat_or_term_url = get_term_link( $tag_id);}
				if (empty($wud_cat_or_term_url)){$wud_cat_or_term_url='#';}
				
		//-> Container-start
			$result .= "<!-- Grid WUD Version ".$gwfuncs['grid_wud_version']."-->";
			$result .= "<div id='grid_wud_fade_home' class='no-js' ><div class='grid-wud-container' style='font-family:".$gwfuncs['grid_wud_font_header']." !important;'>"; 
			
			//Parameter hide category/tag title + back and font color
			$lineheight=$gwfuncs['grid_wud_h1_font_size']+1;
			if($gwfuncs['grid_wud_hide_cat_tag_header']==0 || !$gwfuncs['grid_wud_hide_cat_tag_header'] || $gwfuncs['grid_wud_hide_cat_tag_header']=='')
			{$result .= "<div class='grid-wud-h1' style='line-height:".$lineheight."vw; font-size:".$gwfuncs['grid_wud_h1_font_size']."vw; background-color:".$gwfuncs['grid_wud_cat_bcolor']."; color:".$gwfuncs['grid_wud_cat_fcolor'].";'>".$wud_cat_or_term_name."</div>";}
			$wud_grid_nr = 1; //1-> one grid, 2-> four grid, 3-> five grid (total 20 grid)
			
			  foreach ($posts as $post) {
				  
				$wud_feat_image=NULL; // Make the variable empty
				// CSS variable (size, a.o.)
				if ($wud_grid_nr>20){$wud_grid_nr=1;}
				$post_title = str_replace("'", " ", $post->post_title);
				
				// WP excerpt
				if($gwfuncs['grid_wud_show_excerpt']=='1' || $gwfuncs['grid_wud_show_excerpt']=='2' || $gwfuncs['grid_wud_show_excerpt']=='3' || $gwfuncs['grid_wud_show_excerpt']=='4'){
					//If the real WP excerpt exist (fil in with your own content)
					if(!empty($post->post_excerpt)){$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_excerpt ) );}
					//Else we make our own excerpt from the content
					else{$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_content, $gwfuncs['grid_wud_excerpt_words'] ) );}
						//Remove http and https URLS from the excerpt
						$pattern = '~http(s)?://[^\s]*~i';
						$wud_excerpt= preg_replace($pattern, '', $wud_excerpt);
				}

				// Parameter set featured image as primary
				if($gwfuncs['grid_wud_set_featured_img']=='1'){$wud_feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
				//START EXTRA USER INPUTS
					if ( function_exists( 'uses_nelioefi' ) && 	uses_nelioefi( $post->ID ) ) 
					{  $wud_feat_image = array( nelioefi_get_thumbnail_src( $post->ID ) );}
				//END EXTRA USER INPUT	
				$wud_feat_image=$wud_feat_image[0];
				}
				
				// If no featured image, try first post image
				if (empty($wud_feat_image)){
					$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
					$wud_feat_img = $matches [1];
						// If images found in post, take the first one
						if (!empty($wud_feat_img)){$wud_feat_image = $wud_feat_img[0];} 
						// If no images, place empty one
						else{					
							//If there are GALLERY images
							$gallery = get_post_gallery( $post, false );
							$gids = explode( ",", $gallery['ids'] );
									 
							foreach( $gids as $gid ) {
								//if found, just pick the first one only
								if($gid){
								$wud_feat_image   = wp_get_attachment_url( $gid );
								break;
								}
							}
							
							//Try to get the Youtube picture
							if (empty($wud_feat_image)){
							$output=preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $post->post_content, $matches);
								if($output){
									$wud_feat_image= "http://img.youtube.com/vi/".$matches [1]."/0.jpg";
									}	
							}
							
							//Try to get the Vimeo picture
							if (empty($wud_feat_image)){
								$output=preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $post->post_content, $id);
									if($output){
									$xml_data=simplexml_load_file('https://vimeo.com/api/oembed.xml?url=https://vimeo.com/'.$id[5]);								
									$wud_feat_image = $xml_data->thumbnail_url;									
									}
							}												
						
							//Still empty ... no picture is found
							if (empty($wud_feat_image)){$wud_feat_image= $gwfuncs['grid_wud_def_img'];}							
							
						}
				}

				
				$result .= "<a href='".get_post_permalink($post->ID)."' title='' alt='' >";

				//Category font/line height on a grid
				$h4font=1;
				$h4height=1.1;
				
	//-> If lay-out IS Circle
		if($gwfuncs['gwcss'] == "4" ){
			//-> Wrapper-start
					$result .= "<div class='grid-4-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."'>";
			//-> Image-start & end
					$result .= "<div class='grid-4-wud-image' style='background-image:url(".$wud_feat_image.")'></div>";
			//-> The excerpt text			
					$result .= "<div class='grid-wud-excerpt-4'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";	
		}
	//-> If lay-out is NOT Circle
		else {
			//-> Wrapper-start
					$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; z-index:1; }' >"; 
			//-> Image-start & end
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image.")'></div>";	
			//Show the category on the grid
					if($gwfuncs['grid_wud_hide_grid_cat']==0 || !$gwfuncs['grid_wud_hide_grid_cat'] || $gwfuncs['grid_wud_hide_grid_cat']==''){}
					else{ //show is value 1
								$result .= "<div id='grid-wud-h4-top' class='grid-wud-h4' style='font-size:".$h4font."vw; height:".$h4height."vw;'>".$wud_cat_or_term_name."</div>";
					}
			//-> The excerpt text
				// Show excerpt text
				if($gwfuncs['grid_wud_show_excerpt']=='1'){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;'>".$wud_excerpt."</div>";	
				}
				// Show excerpt text and title
				elseif ($gwfuncs['grid_wud_show_excerpt']==2 ){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";					
				}
				// Show excerpt text and title allways
				elseif ($gwfuncs['grid_wud_show_excerpt']==3 ){
					$result .= "<div class='grid-wud-excerpt-2' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";						
				}
				// Show excerpt title
				elseif ($gwfuncs['grid_wud_show_excerpt']==4 ){
					$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;'><b>".$post->post_title."</b></div>";						
				}				
		}

			
		//-> Wrapper-end
					$result .= "</div>"; 
				$result .= "</a>";		
					$wud_grid_nr++; 		
			  }
			  wp_reset_postdata();
		 //-> Container-end
			$result .= "<div class='clear'></div>"; 
		//-> Read more-start & end
			$result .= "</div>";

			// Is $GET used ?				
			if(strpos($_SERVER['REQUEST_URI'].esc_url( get_category_link(1)),'?') !== false){$koppel="&";} else{$koppel="?";}
			// Read more + see more grid
			$readmore = ($wud_quantity + $gwfuncs['grid_wud_set_more_grid']);
			
			$buttonheight=$gwfuncs['grid_wud_but_font_size']+1;
			//--> Archives (0)
			if($gwfuncs['grid_wud_show_arch_grid']==0){
				//Without archive text
				if($gwfuncs['grid_wud_show_arch_button']==''){
				if ($grid_wud_button == 0 && $wud_post_type!=1){
				$result .= "<div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".$wud_cat_or_term_url.$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div class='grid-wud-h3' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw; line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";'  role='button'> + </div></a>";	
				}
				else{
				$result .= "<div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div class='grid-wud-h3' style='margin:0; padding:0;'></div>";		
				}
				}
				//With archive text
				else{
				if ($grid_wud_button == 0 && $wud_post_type!=1){
				$result .= "<br><div class='grid-wud-bottom'style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".$wud_cat_or_term_url.$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div id='grid_wud_base' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";' role='button'> ".$gwfuncs['grid_wud_show_arch_button']." </div></a>";			
				}
				else{
				$result .= "<div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div class='grid-wud-h3-txt' style='margin:0; padding:0;'></div>";		
				}				
				}
			}	
			//--> grid (1)
			else{		
				//Without grid text
				if($gwfuncs['grid_wud_show_grid_button']==''){
				if ($grid_wud_button == 0 && $wud_post_type!=1){
					if ( isset( $cat_id) && !empty( $cat_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".esc_url( get_category_link( $cat_id ) ).$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div id='grid_wud_base' class='grid-wud-h3' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";'> + </div></a>";}			
					if ( isset( $tag_id) && !empty( $tag_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".esc_url( get_term_link( $tag_id ) ).$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div id='grid_wud_base' class='grid-wud-h3' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";'> + </div></a>";}	
				}
				else{
					if ( isset( $cat_id) && !empty( $cat_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div id='grid_wud_base' class='grid-wud-h3' style='margin:0; padding:0;'></div></a>";}			
					if ( isset( $tag_id) && !empty( $tag_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div id='grid_wud_base' class='grid-wud-h3' style='margin:0; padding:0;'></div></a>";}					
				}
				}
				//With grid text
				else{
				if ($grid_wud_button == 0 && $wud_post_type!=1){
				if ( isset( $cat_id) && !empty( $cat_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".esc_url( get_category_link( $cat_id ) ).$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div id='grid_wud_base' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";'> ".$gwfuncs['grid_wud_show_grid_button']." </div></a>";}			
				if ( isset( $tag_id) && !empty( $tag_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; '><a href='".esc_url( get_term_link( $tag_id ) ).$koppel."g=".$readmore."&s=".$gwfuncs['gwcss']."'><div id='grid_wud_base' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";'> ".$gwfuncs['grid_wud_show_grid_button']." </div></a>";}					
				}
				else{
					if ( isset( $cat_id) && !empty( $cat_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div id='grid_wud_base' class='grid-wud-h3' style='margin:0; padding:0;'></div></a>";}			
					if ( isset( $tag_id) && !empty( $tag_id) ){$result .= "<br><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important; margin:0; padding:0;'><div id='grid_wud_base' class='grid-wud-h3' style='margin:0; padding:0;'></div></a>";}					
				}
				}
			}
			
			if ($wud_post_type==1){$result .= "<div class='grid-wud-bottom'><div id='grid_wud_base' class='grid-wud-h3'></div>";}
			
			$result .= "</div></div>";
		}
		else{
			$result = '<font color="red">Something went wrong, no post to display ...</font>';
		}
		
	}
		
	return $result;
}
 ?>