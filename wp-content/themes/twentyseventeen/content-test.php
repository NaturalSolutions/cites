<?php
/*
Template Name: template test
Template Post Type: post, page
*/
 
// Votre code ici


get_header(); ?>

<div class="wrap">


	<input  id="searchVal" value="advanced">
	<input type="submit" class="search-submit" id="searchBtn">


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();?>

<script type="text/javascript">

	var $ = jQuery.noConflict();

	$( document ).ready(function() {
		
		/*$( "#searchBtn" ).click(function() {
			var serach = $('#searchVal').val();
			alert(serach);

			
			jQuery.post(
			// see tip #1 for how we declare global javascript variables
			MyAjax.ajaxurl,
			{
				// here we declare the parameters to send along with the request
				// this means the following action hooks will be fired:
				// wp_ajax_nopriv_myajax-submit and wp_ajax_myajax-submit
				action : 'taxons_search',

				// other parameters can be added along with "action"
				serach : serach
			},
			function( response ) {
				alert( response );
			}
		);
		});*/
		
		
	});
	
	
</script>