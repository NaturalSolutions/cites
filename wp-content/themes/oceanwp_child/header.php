<?php
/**
 * The Header for our theme.
 * 
 *
 * @package OceanWP WordPress theme
 * 
 * 
 */ 
$lang=get_bloginfo("language");
$title = 'Threatened species';
if ($lang == 'fr-FR'){
	$title = "Espèces menacées";
}

 ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?><?php oceanwp_schema_markup( 'html' ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--<link rel="profile" href="http://gmpg.org/xfn/11">-->
	<LINK REL="SHORTCUT ICON" href="<?php 
				$url=get_site_url().'/wp-content/uploads/cites-favicon/favicon-32x32.png'; 
				echo $url ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'ocean_before_outer_wrap' ); ?>

	<div id="outer-wrap" class="site clr">

		<?php do_action( 'ocean_before_wrap' ); ?>

		<div id="wrap" class="clr">

			<?php //do_action( 'ocean_top_bar' ); ?>
			<div class="headerContainer">
			
			<div class="navLang">
			
			<a class="linkAbout" href="<?php 	
				$lien = '/about';
				$display = 'About';
				if ($lang == 'fr-FR'){
					$lien = '/a-propos';
					$display = 'A propos';
				}
				$url=get_site_url().$lien; 

				echo $url ?> ">  
			<span><?php echo $display ?></span></a>|
			<?php pll_the_languages(array('show_names'=>1));  ?>
			
			</div>   <!-- fin  .navLang -->
			<div class="logo">
				<a href="<?php 	echo bloginfo('url');?> ">
				<img src="<?php 
				$url=get_site_url().'/wp-content/uploads/photos/logocites2.png'; 
				echo $url ?>"><span class="siteTitle"><?php echo($title) ?></span></a>
				
				
			</div>
			</div> <!-- fin headerContainer -->
			
			

			<?php //do_action( 'ocean_header' ); ?>

			<?php do_action( 'ocean_before_main' ); ?>
			
			<main id="main" class="site-main clr"<?php oceanwp_schema_markup( 'main' ); ?>>

				<?php //do_action( 'ocean_page_header' ); ?>