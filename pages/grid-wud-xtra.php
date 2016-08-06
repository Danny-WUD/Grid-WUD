 <?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 * This file needs to load 'wp-load.php' again, there it's called from a Java script
 */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( filter_var($parse_uri[0] . 'wp-load.php', FILTER_SANITIZE_STRING) );	
//Let's start again from here!
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	if($_POST)
	{
		$grid_wud_set_max_grid = trim(filter_var($_POST['grid_wud_set_max_grid'], FILTER_SANITIZE_STRING));
		$tags = trim(filter_var($_POST['grid_wud_tags'], FILTER_SANITIZE_STRING));
		$cats = trim(filter_var($_POST['grid_wud_cats'], FILTER_SANITIZE_STRING));
		$ids = unserialize(filter_var($_POST['grid_wud_ids'], FILTER_SANITIZE_STRING));
		$wud_grid_nr = trim(filter_var($_POST['grid_wud_grid_nr'], FILTER_SANITIZE_STRING));
		$wud_grid_shape = trim(filter_var($_POST['grid_wud_shape'], FILTER_SANITIZE_STRING));
		$wud_grid_latest = trim(filter_var($_POST['grid_wud_latest'], FILTER_SANITIZE_STRING));
		$grid_wud_shadow = trim(filter_var($_POST['grid_wud_shadow'], FILTER_SANITIZE_STRING));
		echo wud_grid_wud__more_post();
		echo '</div>';
	}


// Get the 'see more' image
	function wud_grid_wud__more_post(){
		global $result, $args, $grid_wud_set_max_grid, $tags, $cats, $ids, $wud_grid_nr, $gwfuncs, $wud_grid_shape, $wud_grid_latest, $grid_wud_shadow ;

		
		//Get the category or tag by name
		$wud_cat_or_term_name ='';
		if (!empty( $cats )){$wud_cat_or_term_name = get_the_category_by_ID($cats );}
		elseif (!empty( $tags )){$wud_cat_or_term_name = get_term_by('term_id', $tags, 'post_tag')->name;}
		
		if (!empty( $cats )){$args = array( 'posts_per_page' => $grid_wud_set_max_grid , 'category' => $cats, 'post__not_in'=>$ids, 'orderby'=> $gwfuncs['grid_wud_set_order_grid'], 'order'=> $gwfuncs['grid_wud_set_dir_grid'] );}
		if (!empty( $tags )){$args = array( 'posts_per_page' => $grid_wud_set_max_grid , 'tag_id' => $tags, 'post__not_in'=>$ids, 'orderby'=> $gwfuncs['grid_wud_set_order_grid'], 'order'=> $gwfuncs['grid_wud_set_dir_grid'] );}
		if (empty( $tags ) && empty( $cats ) && $wud_grid_latest == 1){$args = array( 'posts_per_page' => $grid_wud_set_max_grid , 'post__not_in'=>$ids, 'orderby'=> 'date', 'order'=> 'DESC' );}
		
			$myposts = get_posts( $args );
			if(isset($myposts)){	
			foreach ( $myposts as $post ) : setup_postdata( $post );
				if ($wud_grid_nr>20){$wud_grid_nr=1;}
				$wud_link = get_post_permalink($post->ID);
				$wud_title = $post->post_title;
					//If the real WP excerpt exist (fil in with your own content)
					if(!empty($post->post_excerpt)){$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_excerpt, $gwfuncs['grid_wud_excerpt_words'] ) );}
					//Else we make our own excerpt from the content
					else{$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_content, $gwfuncs['grid_wud_excerpt_words'] ) );}
						//Remove http and https URLS from the excerpt
						$pattern = '~http(s)?://[^\s]*~i';
						$wud_excerpt= preg_replace($pattern, '', $wud_excerpt);	
						
			$wud_feat_image=NULL;

				// Parameter set featured image as primary
				if($gwfuncs['grid_wud_set_featured_img']=='1'){
					if($gwfuncs['grid_wud_thumb_img']==1){
						$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
					}
					elseif($gwfuncs['grid_wud_thumb_img']==2){
						$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'medium');
					}
					else{
						$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
					}
					if (!empty($image_thumb)){$wud_feat_image=$image_thumb[0];}
					//START Nelio External Featured Image
						if ( function_exists( 'uses_nelioefi' ) && 	uses_nelioefi( $post->ID )) {  
						$image_thumb = array( nelioefi_get_thumbnail_src( $post->ID ) );
						$wud_feat_image=$image_thumb[0];}
					//END Nelio External Featured Image					
				}
				
				
				// If no featured image, try first post image
				if (empty($wud_feat_image)){
					$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
					$wud_feat_img = $matches [1];
						// If images found in post, take the first one // ???? the_post_thumbnail_url( 'thumbnail' ); ????
						if (!empty($wud_feat_img)){
							if($gwfuncs['grid_wud_thumb_img']==1 || $gwfuncs['grid_wud_thumb_img']==2){
								$image_url = $wud_feat_img[0];
								$image_id = wud_get_image_id($image_url);
								
								if($gwfuncs['grid_wud_thumb_img']==1)
									{$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');}
								elseif($gwfuncs['grid_wud_thumb_img']==2)
									{$image_thumb = wp_get_attachment_image_src($image_id, 'medium');}
									
								$wud_feat_image = $image_thumb[0];
							}
							else{$wud_feat_image = $wud_feat_img[0];}
							} 
						// If no images, place empty one
						else{					
							//If there are GALLERY images
							$gallery = get_post_gallery( $post, false );
							$gids = explode( ",", $gallery['ids'] );
									 
							foreach( $gids as $gid ) {
								//if found, just pick the first one only
								if($gid){
									if($gwfuncs['grid_wud_thumb_img']==1){
										$image_thumb   = wp_get_attachment_image_src( $gid, 'thumbnail' );
									}
									elseif($gwfuncs['grid_wud_thumb_img']==2){
										$image_thumb   = wp_get_attachment_image_src( $gid, 'medium' );
									}
									else{
										$image_thumb   = wp_get_attachment_image_src( $gid, 'large' );
									}
									$wud_feat_image = $image_thumb[0];
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
					
					$result .= "<!-- Grid WUD Version ".$gwfuncs['grid_wud_version']."-->";
					$result .= "<div class='wud-url'><a href='".$wud_link."' title='' alt=''>";				
		

			//-> Wrapper-start
			
		// ###### CIRCLE ###### ($grid_wud_shadow is DEMO variable from: grid-wud-base.php --> grid-wud.js --> HERE) ######
			if($wud_grid_shape == "4" ){
				//GRIDS  
				if($gwfuncs['grid_wud_img_split'] == 0 && $grid_wud_shadow == 0){
					$result .= "<div class='grid-wud-wrapper' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 			
				}
				//TILES
				else{
					// shadow
					if($gwfuncs['grid_wud_shadow']==1 || $grid_wud_shadow == 1){
					$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 			
					}
					//no shadow
					else{
					$result .= "<div class='grid-wud-wrapper' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 			
					}					
				}				
			}
		// ###### SQUARE ###### ($grid_wud_shadow is DEMO variable from: grid-wud-base.php --> grid-wud.js --> HERE) ######
			else{
				//GRIDS
				if($gwfuncs['grid_wud_img_split'] == 0 && $grid_wud_shadow == 0){
					$result .= "<div class='grid-wud-wrapper' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 			
				}
				//TILES
				else{ 
					// shadow
					if($gwfuncs['grid_wud_shadow']==1 || $grid_wud_shadow == 1){
					$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 			
					}
					// no shadow
					else{
					$result .= "<div class='grid-wud-wrapper' id='grid-".$wud_grid_shape."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 			
					}					
				}			
			}	
			
			//-> Image-start & end
			if($wud_grid_shape == "4" ){
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; '></div>";
			}
			else{
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); '></div>";
			}			
						
			//Show the category on the grid
					if($gwfuncs['grid_wud_hide_grid_cat']==0 || !$gwfuncs['grid_wud_hide_grid_cat'] || $gwfuncs['grid_wud_hide_grid_cat']==''){}
					else{ //show is value 1
						if ($wud_grid_shape <> "4"){
								$result .= "<div id='grid-wud-h4-top' class='grid-wud-h4' style='font-size:".$h4font."vw; height:".$h4height."vw;'>".$wud_cat_or_term_name."</div>";
						}
					}
			//-> The excerpt text
			if ($wud_grid_shape <> "4" ){
				// Show excerpt text
				if($gwfuncs['grid_wud_show_excerpt']=='1'){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']."; !important; '>".$wud_excerpt."</div>";	
				}
				// Show excerpt text and title
				elseif ($gwfuncs['grid_wud_show_excerpt']==2 ){
					$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; '><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";					
				}
				// Show excerpt text and title allways
				elseif ($gwfuncs['grid_wud_show_excerpt']==3 ){
					$result .= "<div class='grid-wud-excerpt-2' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; '><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";						
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
						$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";					
					}
					// Show excerpt text and title allways
					elseif ($gwfuncs['grid_wud_show_excerpt']==3 ){
						$result .= "<div class='grid-wud-excerpt-2' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";						
					}
					// Show excerpt title
					elseif ($gwfuncs['grid_wud_show_excerpt']==4 ){
						if($gwfuncs['grid_wud_title_topmid']<>4){
						$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important; padding-top: 20px; padding-bottom: 20px; text-align: center !important; '><b>".$post->post_title."</b></div>";						
						}
						else{
						$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b></div>";							
						}
					}					
				}			
		//-> Wrapper-end
					$result .= "</div>"; 
				$result .= "</a></div>";	
				$wud_grid_nr++; 
			endforeach; 
			wp_reset_postdata();
			}
		return $result;
	}	
	
?>