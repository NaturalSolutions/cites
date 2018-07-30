<?php 
$search = isset($_GET['search']);

print($search);
// args
$args = array(
	'numberposts'	=> -1,
	'post_type'		=> 'taxon',
	'meta_query'	=> array(
		'relation'		=> 'OR',
		array(
			'key'		=> 'espece_type',
			'value'		=> $search,
			'compare'	=> 'LIKE'
		)
		/*,
		array(
			'key'		=> 'location',
			'value'		=> 'Sydney',
			'compare'	=> 'LIKE'
		)*/
	)
);


// query
//$the_query = new WP_Query( $args );
$the_query = new \WP_Query($args);

?>


<?php if( $the_query->have_posts() ): ?>
	<ul>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

<?php wp_reset_query();	 // Restore global post data stomped by the_post(). ?>

