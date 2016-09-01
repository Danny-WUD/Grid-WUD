<?php
 /*
=== Grid WUD ===
 * Contributors: wistudatbe
 * Author: Danny WUD
 */
function grid_wud_comm( $atts ) {	
	extract( shortcode_atts(array('slug' => '','grid' => '','button' => '','cp' => '','pods' => '','shape' => '','nowidget' => '','title' => ''), $atts ));

    // slug: category or tag
	// grid: quantity to display
	// button: display/hide the button
	// cp: custom post type
	// pods: Pods - Custom Content Types and Fields
	// shape: number of shape to show
	// nowidget: display real tiles on widget pages
	
	$result = NULL; 
	$grid_ids = NULL;
	$posttype = NULL ;
	$tax_name = NULL ;
	$posts = null ;
	$term = NULL ;
	$pods_cat = array() ;
	$wp_cat = array();
	$cat_id = "0";
	$tag_id = "0";
	$PodsIdObj=NULL;
	$pods_is_used="0";
	$wud_latest_post="0";
	$is_numbers=0;
	$postids = array() ;
	$custom_title=NULL;
	
	global $gwfuncs, $grid_wud_widget, $pods;
		
		//If pods is used
		if(isset($atts["pods"]) && $atts["pods"]!='' && class_exists( 'PodsInit' )){
			if(is_numeric($atts["pods"]) && $atts["pods"] > 0 && $atts["pods"] == round($atts["pods"], 0)){
				if($atts["pods"] > 2){$atts["pods"] = 1;}
				$pods_is_used="1";
			}
			else{
				$atts["pods"] = 1;
				$pods_is_used="1";
				}
		}
		
		//If custom post is used
		if(isset($atts["cp"]) && $atts["cp"]!='' ){
			if(is_numeric($atts["cp"]) && $atts["cp"] > 0 && $atts["cp"] == round($atts["cp"], 0)){
				if($atts["cp"] > 2){$atts["cp"] = 1;}
			}
			else{$atts["cp"] = 1;}
		}	
		
		//If custom post is used
		if(isset($atts["title"]) && $atts["title"]!='' ){
				$custom_title = trim(filter_var($atts["title"], FILTER_SANITIZE_STRING));
		}
		
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
	if((isset($atts["slug"]) && $atts["slug"]!='' ) || (isset($atts["ids"]) && $atts["ids"]!='' )){
		//Make var empty
		$wud_quantity=0; 
		$grid_wud_skip_post=$gwfuncs['grid_wud_skip_post'];
		$grid_wud_button=0; 
		$widgetfront=0;

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
	
		
		//grid quantity given by shortcode
		if(isset($atts["grid"]) && $atts["grid"]!='' ){
			if(is_numeric($atts["grid"]) && $atts["grid"] > 0 && $atts["grid"] == round($atts["grid"], 0)){
				$wud_quantity = $atts["grid"];
				if($wud_quantity > 50){$wud_quantity = 50;}
			}
		}
			//Else use the global default value
		else{
				$wud_quantity = $gwfuncs['grid_wud_set_max_grid'];
		}		
		
		
		//nowidget = if widget on page (not widget zone) force page layout
		if(isset($atts["nowidget"]) && $atts["nowidget"]!='' ){
			if(is_numeric($atts["nowidget"]) && $atts["nowidget"] > 0 && $atts["nowidget"] == round($atts["nowidget"], 0)){
				$widgetfront = $atts["nowidget"];
				if($widgetfront > 1){$widgetfront = 1;}
			}
			//Else use the global default value
			else{
				$widgetfront = 0;
			}
		}		

 	//If slug with ID's is used
		if($posts == null && isset($atts["slug"]) && $atts["slug"]!='' ){
			$postids = ctoarray($atts["slug"]);
				foreach ($postids as $postid) {	
					if(is_numeric($postid) && $postid > 0 && $postid == round($postid, 0)){
						$is_numbers=1;
					if(!get_post_status( $postid ) || get_post_type( $postid )!='post'){echo "<font color='red'>The ID: <b>".$postid."</b> given in <b>[gridwud slug=\"xx, xx\"]</b> is invalid!<br>Please check this.</font>";return;}
					}
				else{$is_numbers=0; break;}				
				wp_reset_postdata();
				}
			$args = array(
				'posts_per_page'   => -1,
				'showposts'       => $wud_quantity,
				'post_type'		   => 'post',
				'post__in' => $postids,
				'orderby' => 'post__in'
			);
			if ($is_numbers==1){$posts = get_posts( $args );} 	
			if ($posts == null && $is_numbers==1){echo "<font color='red'>Some ID given in <b>[gridwud slug=\"xx, xx\"]</b> is invalid!<br>Please check this.</font>";return;}				
		}	 

	//Custom Post Type
		if ($posts == null && isset($atts["cp"]) && $is_numbers==0 && ($atts["cp"]=="1" || $atts["cp"]=="2")){
		$term = post_type_exists($atts["slug"]);
		if ($term !== 0 && $term !== null) {
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
		 
		
	//Post type Pods (Projects)
		if (isset($atts["pods"]) &&  $pods_is_used=="1" && $is_numbers==0  ) {	
		$post_typ= post_type_exists($atts["slug"]); //'project'
		}
		
		if ($posts == null && $pods_is_used=="1"  && $is_numbers==0 && !empty($post_typ )  && $post_typ !== null && get_post_type( get_the_ID() ) == $post_typ) {			
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
		//Taxonomy Pods (Project Types (all categories from the Taxonomy))
		if ($posts == null &&  $pods_is_used=="1" && $is_numbers==0 ) {
		$taxono = get_terms( $atts["slug"], array(  'orderby'    => 'count') );
				foreach ($taxono as $taxonos) {	
				if(isset($taxonos->slug)){
					$tax_name = $atts["slug"];
					array_push($pods_cat, $taxonos->slug);
					}
				}		
			wp_reset_postdata();	
		}	
		//Category Pods (search by Taxonomy -> category)
		if ($posts == null &&  $pods_is_used=="1"  && $is_numbers==0 && empty($tax_name )  && $tax_name == null) {
			$args = array('posts_per_page'   => -1,	'post_type'   => '_pods_pod',);
			$podstype = get_posts( $args );
				foreach ($podstype as $pods_type) {	
					$tax=$pods_type->post_name;				
						if(term_exists($atts["slug"], $tax)){
							$tax_name=$pods_type->post_name;
						}
				}		
			wp_reset_postdata();
		}
		//Search and order the requested Pods
		if ($posts == null &&  $pods_is_used=="1"  && $is_numbers==0 && !empty($tax_name )  && $tax_name !== null) {	
			//$pods_cat is used by Taxonomy or category search
			if(empty($pods_cat)){$pods_cat = array($atts["slug"]);}
			$args = array(
				'posts_per_page'   => -1,
				'offset'   => $grid_wud_skip_post,
				'showposts'       => $wud_quantity,
				'post_type'		   => $post_typ,
				'tax_query'		   => array(array('taxonomy' => $tax_name, 'field' => 'slug', 'terms' => $pods_cat)),
				'orderby'          => $gwfuncs['grid_wud_set_order_grid'],
				'order'            => $gwfuncs['grid_wud_set_dir_grid']
			);
			$posts = get_posts( $args );
			} 			
		
	//Category
		if ($posts == null) {$term = term_exists($atts["slug"], 'category');}
		if ($posts == null && !empty($term )  && $term !== null) {
			$wp_cat = array($atts["slug"]);
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
		if ($posts == null) {$term = term_exists($atts["slug"], 'post_tag');}
		if ($posts == null && !empty($term )  && $term !== null) {	
			    $wp_cat = array($atts["slug"]);
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
			
			
	//Latest post (all)
		if($posts == null && isset($atts["slug"]) && $atts["slug"]=='wud-latest' ){
				$args = array(
				'posts_per_page'   => -1,
				'offset'   => $grid_wud_skip_post,
				'showposts'       => $wud_quantity,
				'post_type'		   => 'post',
				'orderby'          => 'date',
				'order'            => 'DESC'
			);
			$posts = get_posts( $args );
			}
		
//-> Show the grid !
		if(isset($posts)){	
		$count_cats_tags= substr(round(microtime(true) * 1000),10,3);
		// Remember current slug (cat_or_tag)
		if(isset($atts["slug"])){$slugs = $atts["slug"];} else{$slugs="No slug given";} 
		$CatIdObj = get_category_by_slug($slugs);		
		$TagIdObj = get_term_by('slug', $slugs, 'post_tag');
		//If Pods Taxonomy or category is used
		if(!empty($pods_cat) && $tax_name!=$slugs){$PodsIdObj = get_term_by('slug', $slugs, $tax_name);}
	    // Category or Tag Name
			$wud_cat_or_term_name = NULL; // Make the variable empty	
			if (!empty($CatIdObj)){$wud_cat_or_term_name = $CatIdObj->name;}
			if (!empty($TagIdObj)){$wud_cat_or_term_name = $TagIdObj->name;}
			if (!empty($PodsIdObj)){$wud_cat_or_term_name = $PodsIdObj->name;}
			if (empty($wud_cat_or_term_name)){
			  if($slugs<>'wud-latest' ){	
				if ((isset($atts["cp"]) && $atts["cp"]=="1") || (isset($atts["pods"]) && $atts["pods"]=="1")){$wud_cat_or_term_name=$gwfuncs['grid_wud_cpt01'];}	
				elseif ((isset($atts["cp"]) && $atts["cp"]=="2") || (isset($atts["pods"]) && $atts["pods"]=="2")){$wud_cat_or_term_name=$gwfuncs['grid_wud_cpt02'];}
				else {$wud_cat_or_term_name="";}
			  }
			  else{
				// Latest post is active
				$wud_latest_post="1";
				$wud_cat_or_term_name= $gwfuncs['grid_wud_news_title'];  
			  }
			}
			if(!empty($custom_title)){$wud_cat_or_term_name=$custom_title;}
		// Category or Tag URL
				if(!empty($pods_cat) && $tax_name!==$slugs){$cat_id = $PodsIdObj->term_id; $wud_cat_or_term_url = get_category_link( $cat_id);}
				elseif (!empty($CatIdObj)){$cat_id = $CatIdObj->cat_ID; $wud_cat_or_term_url = get_category_link( $cat_id);}
				elseif (!empty($TagIdObj)){$tag_id = $TagIdObj->term_id; $wud_cat_or_term_url = get_term_link( $tag_id);}
				else{
					//$result .= " -> Grids without category";
					}
				if (empty($wud_cat_or_term_url)){$wud_cat_or_term_url='#_';}
				
		//-> Container-start
			$result .= "<!-- Grid WUD Version ".$gwfuncs['grid_wud_version']."-->";
			
			if($grid_wud_widget==0 ||  $widgetfront==1){
				$result .= "<div id='grid_wud_fade_home' class='no-js' ><div class='grid-wud-container' style='width:".$gwfuncs['grid_wud_width']."% !important; font-family:".$gwfuncs['grid_wud_font_header']." !important;'>";
				}
				else{
					$result .= "<div id='grid_wud_fade_home' class='no-js' ><div class='grid-wud-widget' style='font-family:".$gwfuncs['grid_wud_font_header']." !important;'>";
				}
			
			$lineheight=$gwfuncs['grid_wud_h1_font_size']+1;
			//Parameter hide category/tag title + back and font color
			if($gwfuncs['grid_wud_hide_cat_tag_header']==0 || !$gwfuncs['grid_wud_hide_cat_tag_header'] || $gwfuncs['grid_wud_hide_cat_tag_header']==''){
			  if ($grid_wud_widget==0 ||  $widgetfront==1){
				if($gwfuncs['grid_wud_cat_url']==1 && $wud_cat_or_term_url<>"#"){
					$result .= "<div class='grid-wud-h1' style='line-height:".$lineheight."vw; font-size:".$gwfuncs['grid_wud_h1_font_size']."vw; background-color:".$gwfuncs['grid_wud_cat_bcolor']."; color:".$gwfuncs['grid_wud_cat_fcolor'].";'><a href='".$wud_cat_or_term_url."' style='text-decoration: none;'>".$wud_cat_or_term_name."</a></div>";
				}
				else{
					$result .= "<div class='grid-wud-h1' style='line-height:".$lineheight."vw; font-size:".$gwfuncs['grid_wud_h1_font_size']."vw; background-color:".$gwfuncs['grid_wud_cat_bcolor']."; color:".$gwfuncs['grid_wud_cat_fcolor'].";'><a href='#_' style='text-decoration: none;'>".$wud_cat_or_term_name."</a></div>";
				}
			  }
			  else{
				if($gwfuncs['grid_wud_cat_url']==1 && $wud_cat_or_term_url<>"#"){
					$result .= "<div class='grid-wud-h1' style='font-size:1.1vw; background-color:".$gwfuncs['grid_wud_cat_bcolor']."; color:".$gwfuncs['grid_wud_cat_fcolor'].";'><a href='".$wud_cat_or_term_url."' style='text-decoration: none;'>".$wud_cat_or_term_name."</a></div>";
				}
				else{
					$result .= "<div class='grid-wud-h1' style='font-size:1.1vw; background-color:".$gwfuncs['grid_wud_cat_bcolor']."; color:".$gwfuncs['grid_wud_cat_fcolor'].";'><a href='#_' style='text-decoration: none;'>".$wud_cat_or_term_name."</a></div>";
				}				  
			  }
			}
				
			$wud_grid_nr = 1; //1-> one grid, 2-> four grid, 3-> five grid (total 20 grid)
			
			  foreach ($posts as $post) {
				  $posttype = get_post_type( $post->ID );
				 $grid_ids[] = $post->ID; 
				$wud_feat_image=NULL; // Make the variable empty
				// CSS variable (size, a.o.)
				if ($wud_grid_nr>20){$wud_grid_nr=1;}
				$post_title = str_replace("'", " ", $post->post_title);
				
				// WP excerpt
				if($gwfuncs['grid_wud_show_excerpt']=='1' || $gwfuncs['grid_wud_show_excerpt']=='2' || $gwfuncs['grid_wud_show_excerpt']=='3' || $gwfuncs['grid_wud_show_excerpt']=='4'){
					//If the real WP excerpt exist (fil in with your own content)
					if(!empty($post->post_excerpt)){$wud_excerpt = strip_shortcodes ( wp_trim_words ( $post->post_excerpt, $gwfuncs['grid_wud_excerpt_words'] ) );}
					//Else we make our own excerpt from the content
					else{$wud_excerpt = 						   strip_shortcodes ( wp_trim_words ( $post->post_content, $gwfuncs['grid_wud_excerpt_words'] ) );}
						//Remove http and https URLS from the excerpt
						$pattern = '~http(s)?://[^\s]*~i';
						$wud_excerpt= preg_replace($pattern, '', $wud_excerpt);
				}

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
									
								if($image_id==0){$image_thumb = $wud_feat_img;}	
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

	//URL START	
         if($gwfuncs['grid_wud_nourl']==0 && post_type_exists( $posttype )){	$result .= "<a href='".@get_post_permalink($post->ID)."' title='' alt='' >"; }
	else{if($gwfuncs['grid_wud_nourl']==0){	$result .= "<a href='#_' title='' alt='' >"; }}
         if($gwfuncs['grid_wud_nourl']==2 && post_type_exists( $posttype )){	$result .= "<a href='".@get_permalink($post->ID)."' title='' alt='' >"; }
	else{if($gwfuncs['grid_wud_nourl']==2){	$result .= "<a href='#_' title='' alt='' >"; }}
	
				//Category font/line height on a grid grid_wud_img_split
				$h4font=1;
				$h4height=1.1;
			
			//-> Wrapper-start
			
			//CIRCLE ***
			if($gwfuncs['gwcss'] == "4" ){
				if ($grid_wud_widget==0 ||  $widgetfront==1){
					//GRIDS
					if($gwfuncs['grid_wud_img_split'] == 0){
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
					}
					//TILES
					else{
						//shadow
						if($gwfuncs['grid_wud_shadow']==1){
						$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
						}
						//no shadow
						else{
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
						}						
					}					
				}
				//WIDGET
				else{
					$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='width: 100% !important;	height: 0; padding-bottom: 100% !important;	margin: 0.5%; border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; ' >"; 
				}
			}
			
			//SQUARE ***
			else{
				if ($grid_wud_widget==0 ||  $widgetfront==1){
					//GRIDS
					if($gwfuncs['grid_wud_img_split'] == 0){
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 				
					}
					//TILES
					else{
						//shadow
						if($gwfuncs['grid_wud_shadow']==1){
						$result .= "<div class='grid-wud-wrapper grid-wud-wrapper-box' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 	
						}
						//no shadow
						else{
						$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 	
						}						
					}					
				}
				//WIDGETS
				else{
					$result .= "<div class='grid-wud-wrapper' id='grid-".$gwfuncs['gwcss']."-wud-wrapper-".$wud_grid_nr."' style='width: 100% !important;	height: 0; padding-bottom: 100% !important;	margin: 0.5%; border-radius:".$gwfuncs['grid_wud_round_img']."px; }' >"; 
				}
			}	

			
			//-> Image-start & end
			if($gwfuncs['gwcss'] == "4" ){
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); border-radius: 50% !important;-webkit-border-radius: 50% !important;	-moz-border-radius: 50% !important; '></div>";
			}
			else{
					$result .= "<div class='grid-wud-image' style='background-image:url(".$wud_feat_image."); '></div>";
			}			
						
			//Show the category on the grid
					if($gwfuncs['grid_wud_hide_grid_cat']==0 || !$gwfuncs['grid_wud_hide_grid_cat'] || $gwfuncs['grid_wud_hide_grid_cat']==''){}
					else{ //show is value 1
						if ($gwfuncs['gwcss'] <> "4"){
								$result .= "<div id='grid-wud-h4-top' class='grid-wud-h4' style='font-size:".$h4font."vw; height:".$h4height."vw;'>".$wud_cat_or_term_name."</div>";
						}
					}
			//-> The excerpt text
			if ($gwfuncs['gwcss'] <> "4" ){
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
						$result .= "<div class='grid-wud-excerpt' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b></div>";						
						}
						else{
						$result .= "<div class='grid-wud-excerpt-3' style='font-family:".$gwfuncs['grid_wud_font_excerpt']." !important;padding: 3% 2% 3% 4%; border-radius: 10%;-webkit-border-radius: 10%;-moz-border-radius: 10%;margin-left: 17%;font-size: 16px;font-size: 0.8vw;width: 60%;bottom: 20%;height: auto;max-height: 25% !important;'><b>".$post->post_title."</b></div>";							
						}
					}					
				}
			
		//-> Wrapper-end
					$result .= "</div>"; 
	//URL END
	if($gwfuncs['grid_wud_nourl']==0 || $gwfuncs['grid_wud_nourl']==2){
      $result .= "</a>";
	}	
					$wud_grid_nr++; 		
			  }
			  wp_reset_postdata();
		 //-> Container-end
			$result .= "<div id='grid_wud_result_".$count_cats_tags."'></div>";
			$result .= "<div class='clear'></div>"; 
		//-> Read more-start & end
			$result .= "</div>";
			//New since 1.08 read more button

			if( ($grid_wud_widget==0 && $grid_wud_button == 0)  ||  $widgetfront==1){
				// Form value transfered to JQuery --> grid-wud-xtra
				$result .= "<form method='post' id='grid_wud_form'>";
				// # extra post by button
				$result .= "<input type='hidden' name='grid_wud_set_more_grid' id='grid_wud_set_more_grid_".$count_cats_tags."' value='".$gwfuncs['grid_wud_set_more_grid']."'/>";
				// # post if page called
				$result .= "<input type='hidden' name='grid_wud_set_max_grid' id='grid_wud_set_max_grid_".$count_cats_tags."'  value='".$wud_quantity."'/>";
				$result .= "<input type='hidden' name='grid_wud_grid_nr' id='grid_wud_grid_nr_".$count_cats_tags."'  value='".$wud_grid_nr."'/>";
				$result .= "<input type='hidden' name='grid_wud_tags' id='grid_wud_tags_".$count_cats_tags."'  value='".$tag_id."'/>";
				$result .= "<input type='hidden' name='grid_wud_cats' id='grid_wud_cats_".$count_cats_tags."'  value='".$cat_id."'/>";
				$result .= "<input type='hidden' name='grid_wud_shape' id='grid_wud_shape_".$count_cats_tags."'  value='".$gwfuncs['gwcss']."'/>";
				$result .= "<input type='hidden' name='grid_wud_latest' id='grid_wud_latest_".$count_cats_tags."'  value='".$wud_latest_post."'/>";
				// post id's to deny
				$result .= "<input type='hidden' name='grid_wud_ids' id='grid_wud_ids_".$count_cats_tags."'  value='".serialize($grid_ids)."'/>";
				if($gwfuncs['grid_wud_shadow'] ==1){
					$result .= "<input type='hidden' name='grid_wud_shadow' id='grid_wud_shadow".$count_cats_tags."'  value='1'/>";
				}
				else{
					$result .= "<input type='hidden' name='grid_wud_shadow' id='grid_wud_shadow".$count_cats_tags."'  value='0/>";
				}
				$result .= "<input type='hidden' name='count_cats_tags' id='count_cats_tags'  value='".$count_cats_tags."'/>";
				$result .= "<input type='hidden' name='posttype' id='posttype".$count_cats_tags."'  value='".$posttype."'/>";
				//Pods
				$result .= "<input type='hidden' name='tax_name' id='tax_name".$count_cats_tags."'  value='".$tax_name."'/>";
				if(!empty($pods_cat)){$result .= "<input type='hidden' name='pods_cat' id='pods_cat".$count_cats_tags."'  value='".implode(" ",$pods_cat)."'/>";}
				else{$result .= "<input type='hidden' name='pods_cat' id='pods_cat".$count_cats_tags."'  value='".implode(" ",$wp_cat)."'/>";}
				$result .= "<input type='hidden' name='pods_is_used' id='pods_is_used".$count_cats_tags."'  value='".$pods_is_used."'/>";
				$result .= "<input type='hidden' name='is_numbers' id='is_numbers".$count_cats_tags."'  value='".$is_numbers."'/>";
				$result .= "<input type='hidden' name='postids' id='postids".$count_cats_tags."'  value='".implode(" ",$postids)."'/>";
//				
				$buttonheight=$gwfuncs['grid_wud_but_font_size']+1;
				
				  //Show GRIDS
				  if($gwfuncs['grid_wud_show_arch_grid']==0 ){
					//Show text or + sign
					if($gwfuncs['grid_wud_show_grid_button']=='')
						{$result .= "</div><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important;'><button ClickResult='".$count_cats_tags."' id='grid_wud_button' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw; line-height:".$buttonheight."vw;  background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";' type='submit'> + </button></div>";}
					else
						{$result .= "</div><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important;'><button ClickResult='".$count_cats_tags."' id='grid_wud_button' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";' type='submit'>".$gwfuncs['grid_wud_show_grid_button']."</button></div>";}
				  }
				$result .= "</form>";
				
				  //SHOW ARCHIVES
				  if($gwfuncs['grid_wud_show_arch_grid']==1 && $slugs <>'wud-latest'){
					//Show text or + sign
					if($gwfuncs['grid_wud_show_grid_button']=='')
						{$result .= "</div><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important;'><a href='".$wud_cat_or_term_url."' style='text-decoration: none;'><button id='grid_wud_button' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw; line-height:".$buttonheight."vw;  background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";' type='submit'> + </button></a></div>";}
					else
						{$result .= "</div><div class='grid-wud-bottom' style='font-family:".$gwfuncs['grid_wud_font_button']." !important;'><a href='".$wud_cat_or_term_url."' style='text-decoration: none;'><button id='grid_wud_button' class='grid-wud-h3-txt' style='border-radius:".$gwfuncs['grid_wud_round_button']."px; font-size:".$gwfuncs['grid_wud_but_font_size']."vw;  line-height:".$buttonheight."vw; background-color:".$gwfuncs['grid_wud_but_bcolor']."; color:".$gwfuncs['grid_wud_but_fcolor'].";' type='submit'>".$gwfuncs['grid_wud_show_grid_button']."</button></a></div>";}
				 					  
				  }
				
			}
			// if button=1 (no button to display)
			else{$result .= "</div><div class='grid-wud-bottom'></div>";}
			
		}
		else{$result = '<br><font color="red">Something went wrong.</font><br>No post to display for: slug="'.$atts["slug"] .'"';}
		
	}
		
	return $result;
}

?>