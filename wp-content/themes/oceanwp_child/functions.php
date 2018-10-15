<?php
function wpm_enqueue_styles(){
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/../oceanwp_child/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );

// add search script

add_action( 'wp_ajax_nopriv_taxons_search', 'taxons_search' );
add_action( 'wp_ajax_taxons_search', 'taxons_search' );

/*  add bootstrap  */
wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/../oceanwp_child/res/bootstrap.min.js', array('jquery'), null, true);
wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/../oceanwp_child/res/bootstrap.min.css' );

/*  add swiper  */
wp_enqueue_script( 'swiper', get_template_directory_uri() . '/../oceanwp_child/res/swiper.jquery.min.js', array('jquery'), null, true);
wp_enqueue_style( 'swiper', get_template_directory_uri() . '/../oceanwp_child/res/swiper.min.css' );

function add_js_scripts() {
	wp_enqueue_script( 'taxonsSearch', get_template_directory_uri().'/../oceanwp_child/js/script.js', array('jquery'), '1.0', true );

	// pass Ajax Url to script.js
	wp_localize_script('taxonsSearch', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

	wp_enqueue_script( 'jquery-ui-autocomplete' );
    wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui-styles' );
    wp_localize_script( 'jquery-ui-autocomplete', 'adminAjax', admin_url( 'admin-ajax.php' ) );
}
add_action('wp_enqueue_scripts', 'add_js_scripts');


function taxons_search() {
    // get the submitted parameters
	$params = $_POST['params'];
	//var_dump($params);
    //$search = $_POST['search'];
	$args = get_args($params);

	$wp_query = new WP_Query($args);
	$lang=get_bloginfo("language");
	$output = array();
	$posts_per_page = -1;
	$path = get_site_url().'/wp-content/uploads/photos/'; 
	
	if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
		 global $post;
		 //$class = get_post_meta($post->ID, "Class", true);
		 //print($class);
		 
		 $content = array();
		 $content["lang"] = $lang;
		 $content["Name_FR"] = get_post_meta($post->ID, "Common_Name_FR", true);
		 $content["Picture"] = get_post_meta($post->ID, "Picture");
		 $content["Picture_1_File_Name"] =get_post_meta($post->ID, "Picture_1_File_Name", true);
		 $content["scName"]  = get_post_meta($post->ID, "Scientific Name", true);
		 $content["Name_EN"] =get_post_meta($post->ID, "Common_Name_EN", true);
		 $content["lien"] = get_permalink($post->ID);
		 $content["rank"] = get_post_meta($post->ID, "Rank", true);
		 $content["CITES"] = get_post_meta($post->ID, "CITES", true);
		 $content["path"] = $path.$content["Picture_1_File_Name"];
		 $output[] = $content;
		 /*
		 if($lang == 'fr-FR'){
			get_template_part( 'partials\single\taxon' ); 
		 } else {
			get_template_part( 'partials\single\taxon_en' );  
		 }*/
	endwhile;

     //posts_nav_link(); 

	endif;
	

    echo json_encode($output);

	
	//$count = $wp_query->post_count ;

	//$response = $ajax_query ;
		//echo ($count);
    // response output
    //header( "Content-Type: application/json" );
    //var_dump $response;

    die();
}

function get_args($params){
	global $wpdb;

	$type = $params['type'];
	$scName = $params['scName'];
	$nameFr = $params['nameFr'];
	$origin = $params['origin'];
	$body = $params['body'];
	$caract = $params['caract'];
	$lang = $params['language'];


	//$resultats = $wpdb->get_results("SELECT label_fr FROM traduction WHERE champ = 'All_DistributionFullNames' AND label_en = 'Albania'", OBJECT_K);

	//print($resultats);


	$meta_query = array();

	//if ($type =='simple'){
		$search = $params['search'];

		if(!empty($origin)){
			$meta_query[] = array( 'key' => 'All_DistributionFullNames', 'value' => $origin, 'compare' => 'LIKE' );
		}
		if( !empty( $body) ){
			$meta_query[] = array( 'key' => 'Body', 'value' => $body, 'compare' => 'LIKE' );
		}
		/*if( !empty( $caract) ){
			$meta_query[] = array( 'key' => 'Caracteristics', 'value' => $caract, 'compare' => 'LIKE' );
		}*/


		$nbCaract = count($caract);
		
		if($nbCaract >0 ){
			if($nbCaract == 1) {
				$meta_query[]= array(
					'key'     => 'Caracteristics',
					'value'   => $caract[0],
					'compare' => 'LIKE',
				);
			} else {
				$arr = array();

				for($i=0; $i<$nbCaract ; $i++) { 
					$arr[]= array(
						'key'     => 'Caracteristics',
						'value'   => $caract[$i],
						'compare' => 'LIKE',
					);
				} 
				$arr['relation'] = 'AND';
				$meta_query[]= $arr;

			}
			
		}

		if( count( $meta_query ) > 1 ){
			$meta_query['relation'] = 'AND';

		}
		
		//$args = array(
			//'post_type' => 'taxon',
			//'posts_per_page' => 1,
		if($search ) {
			$meta_query[]=  array(
				
				'relation' => 'OR',
				
				array(
					'key'     => 'Kingdom',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				
				array(
					'key'     => 'Phylum',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Class',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Order',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Family',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Genus',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Species',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Subspecies',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Scientific Name',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Common_Name_FR',
					'value'   => $search,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'Common_Name_EN',
					'value'   => $search,
					'compare' => 'LIKE',
				)
				);

		}	


			//var_dump($meta_query);




		
	//} else {
		
		//$meta_query = array();

		/*if( count( $meta_query ) > 0 ){
			$query->set( 'meta_query', $meta_query );
		}*/
		
		$args = array(
			'post_type' => 'taxon',
			'meta_query' => $meta_query,
			'posts_per_page' => -1 
		);
	//}
	
	return $args ;
	
	
	
}

add_filter('acf/load_field', 'test_load_field');
function test_load_field($field) {
	$field['disabled'] = 0;
	return $field;
}























?>