<?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 */
get_header(); ?>
<div id="primary" class="content-area">
<div id="primary" class="site-content">
<div id="content" class="site-main"  role="main">
<main id="main" class="site-main" role="main">
<?php
	//Declare variables
	global $cats_id, $tags_id, $wud_quantity;
	$cats_id=$catid;
	$tags_id=$tagid;
	//Quantity from URL
	if (isset( $_GET['g'] ) && !empty( $_GET['g'] )){$wud_quantity=filter_var($_GET['g'], FILTER_SANITIZE_STRING);}
	
		    if (!empty( $catid )){$wud_cat_or_term_name = get_the_category_by_ID($cats_id );}
		elseif (!empty( $tagid )){$wud_cat_or_term_name = get_term_by('term_id', $tags_id, 'post_tag')->name;}
		  else {$wud_cat_or_term_name = "No title was found ...";}
		  $lineheight=$GLOBALS['gwfuncs']['grid_wud_h1_font_size']+1;
		echo "<div class='grid-wud-container'>";
			if($GLOBALS['gwfuncs']['grid_wud_hide_cat_tag_header']==0 || !$GLOBALS['gwfuncs']['grid_wud_hide_cat_tag_header'] || $GLOBALS['gwfuncs']['grid_wud_hide_cat_tag_header']==''){
			echo "<div class='grid-wud-h1' style='line-height:".$lineheight."vw; font-size:".$GLOBALS['gwfuncs']['grid_wud_h1_font_size']."vw; background-color:".$GLOBALS['gwfuncs']['grid_wud_cat_bcolor']."; color:".$GLOBALS['gwfuncs']['grid_wud_cat_fcolor'].";'>".$wud_cat_or_term_name."</div>";
			}
		echo "<div id='wud_fade'>".wud_grid_wud_post2()."</div><div id='WudPoss'>".wud_content_nav2()."</div>";
?>
</main><!-- #WUD site-main -->
</div><!-- #WUD site-main -->
</div><!-- #WUD site-content -->
</div><!-- #WUD content-area -->
<?php 
	get_sidebar();
	get_footer();
?>

<?php
// Navigation in 'see more' page
	function wud_content_nav2() {
		global $cats_id, $tags_id, $ids,$wud_quantity, $wud_grid_nr;
		
		        $more = "<div id='grid_wud_result'></div>";
		$more = $more . "<form method='post' id='grid_wud_form'>";
		// # extra post by button
		$more = $more . "<input type='hidden' name='grid_wud_set_more_grid' id='grid_wud_set_more_grid' value='".$GLOBALS['gwfuncs']['grid_wud_set_more_grid']."'/>";
		// # post if page called
		$more = $more . "<input type='hidden' name='grid_wud_set_max_grid' id='grid_wud_set_max_grid'  value='".$wud_quantity."'/>";
		$more = $more . "<input type='hidden' name='grid_wud_grid_nr' id='grid_wud_grid_nr'  value='".$wud_grid_nr."'/>";
		$more = $more . "<input type='hidden' name='grid_wud_tags' id='grid_wud_tags'  value='".$tags_id."'/>";
		$more = $more . "<input type='hidden' name='grid_wud_cats' id='grid_wud_cats'  value='".$cats_id."'/>";
		// post id's to deny
		$more = $more . "<input type='hidden' name='grid_wud_ids' id='grid_wud_ids'  value='".serialize($ids)."'/>";
		$buttonheight=$GLOBALS['gwfuncs']['grid_wud_but_font_size']+1;
		if($GLOBALS['gwfuncs']['grid_wud_show_grid_button']==''){$more = $more . "</div><div class='grid-wud-bottom'><button id='grid_wud_button' class='grid-wud-h3-txt' style='font-size:".$GLOBALS['gwfuncs']['grid_wud_but_font_size']."vw; line-height:".$buttonheight."vw;  background-color:".$GLOBALS['gwfuncs']['grid_wud_but_bcolor']."; color:".$GLOBALS['gwfuncs']['grid_wud_but_fcolor'].";' type='submit'> + </button></div></form>";}
								 else{$more = $more . "</div><div class='grid-wud-bottom'><button id='grid_wud_button' class='grid-wud-h3-txt' style='font-size:".$GLOBALS['gwfuncs']['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$GLOBALS['gwfuncs']['grid_wud_but_bcolor']."; color:".$GLOBALS['gwfuncs']['grid_wud_but_fcolor'].";' type='submit'>".$GLOBALS['gwfuncs']['grid_wud_show_grid_button']."</button></div></form>";}
				
	return $more;
	}	
// Get the 'see more' image
	function wud_grid_wud_post2(){
		global  $result,$cats_id, $tags_id, $ids, $wud_quantity,$wud_grid_nr ;
		
		//Get the category or tag by name
		$wud_cat_or_term_name ='';
		if (!empty( $cats_id )){$wud_cat_or_term_name = get_the_category_by_ID($cats_id );}
		elseif (!empty( $tags_id )){$wud_cat_or_term_name = get_term_by('term_id', $tags_id, 'post_tag')->name;}
		
		//If shortcode is used for quantity, else use the variable grid_wud_set_max_grid
		if (isset( $_GET['g'] ) && !empty( $_GET['g'] )){$wud_quantity=$_GET['g'];} else{$wud_quantity=$GLOBALS['gwfuncs']['grid_wud_set_max_grid'];}
		
		//Check or variable is a number
		if(is_numeric($wud_quantity) && $wud_quantity > 0 && $wud_quantity == round($wud_quantity, 0)){}else{$wud_quantity=$GLOBALS['gwfuncs']['grid_wud_set_max_grid'];}
		if($wud_quantity > 50){$wud_quantity = 50;}

		//Get all the values for the posts to show
		if (!empty( $cats_id)){$args = array( 'posts_per_page' => $wud_quantity , 'category' => $cats_id, 'orderby'=> $GLOBALS['gwfuncs']['grid_wud_set_order_grid'], 'order'=> $GLOBALS['gwfuncs']['grid_wud_set_dir_grid']);}
		if (!empty( $tags_id)){$args = array( 'posts_per_page' => $wud_quantity , 'tag_id' => $tags_id, 'orderby'=> $GLOBALS['gwfuncs']['grid_wud_set_order_grid'], 'order'=> $GLOBALS['gwfuncs']['grid_wud_set_dir_grid']);}
		$wud_grid_nr = 1; //1-> one grid, 2-> four grid, 3-> five grid (total 20 grid)
			$myposts = get_posts( $args );
			if(isset($myposts)){	
			foreach ( $myposts as $post ) : setup_postdata( $post );
				$wud_feat_image=NULL; // Make the variable empty
				$ids[] = $post->ID;
				if ($wud_grid_nr>20){$wud_grid_nr=1;}
				$wud_link = get_post_permalink($post->ID);
				$wud_title = $post->post_title;
					//If the real WP excerpt exist (fil in with your own content)
					if(!empty($post->post_excerpt)){$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_excerpt ) );}
					//Else we make our own excerpt from the content
					else{$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_content, $GLOBALS['gwfuncs']['grid_wud_excerpt_words'] ) );}
						//Remove http and https URLS from the excerpt
						$pattern = '~http(s)?://[^\s]*~i';
						$wud_excerpt= preg_replace($pattern, '', $wud_excerpt);						
				if($GLOBALS['gwfuncs']['grid_wud_set_featured_img']=='1'){$wud_feat_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');} 
				$wud_feat_image=$wud_feat_image[0];
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
								if (empty($wud_feat_image)){$wud_feat_image= $GLOBALS['gwfuncs']['grid_wud_def_img'];}							
							}
					}
					
					$result .= "<!-- Grid WUD Version ".$GLOBALS['gwfuncs']['grid_wud_version']."-->";					
					$result .= "<div class='wud-url'><a href='".$wud_link."' title='' alt=''>";				
		//-> Wrapper-start

					$result .= "<div class='grid-wud-wrapper' id='grid-wud-wrapper-".$wud_grid_nr."' >";	

		//-> Image-start & end
						$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image.")'></div>";	
						
				//Parameter hide page/post title
				$h4font=1;
				$h4height=1.1;
				if($GLOBALS['gwfuncs']['grid_wud_my_css']<>"grid-wud-circle"){
					//Show the category on the grid
					if($GLOBALS['gwfuncs']['grid_wud_hide_grid_cat']==0 || !$GLOBALS['gwfuncs']['grid_wud_hide_grid_cat'] || $GLOBALS['gwfuncs']['grid_wud_hide_grid_cat']==''){}
					else{ //show is value 1
								$result .= "<div id='grid-wud-h4-top' class='grid-wud-h4' style='font-size:".$h4font."vw; height:".$h4height."vw;'>".$wud_cat_or_term_name."</div>";
					}
					
				}
				

		//-> The excerpt text
				// Show excerpt text
				if($GLOBALS['gwfuncs']['grid_wud_show_excerpt']=='1'){
					$result .= "<div class='grid-wud-excerpt'>".$wud_excerpt."</div>";	
				}
				// Show excerpt text and title
				elseif ($GLOBALS['gwfuncs']['grid_wud_show_excerpt']==2 ){
					$result .= "<div class='grid-wud-excerpt'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";				
				}
				// Show excerpt text and title
				elseif ($GLOBALS['gwfuncs']['grid_wud_show_excerpt']==3 ){
					$result .= "<div class='grid-wud-excerpt-2'><b>".$post->post_title."</b><br>".$wud_excerpt."</div>";						
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
