<?php
/**
 * The default template for displaying the footer copyright
 *
 * @package OceanWP WordPress theme
 */

$lang=get_bloginfo("language");
if( $lang == "en-GB") {
	$copyrightText1 = 'Developed by <a href="https://fr.okfn.org/">Open Knowledge France</a> and  <a href="http://www.natural-solutions.eu/">Natural Solutions</a>, with support from  <a href="https://www.diplomatie.gouv.fr/">Ministère de l’Europe et des Affaires Étrangères</a> and Muséum national d’Histoire naturelle.';
	$copyrightText2 = 'Data sources: <a href="https://www.speciesplus.net/">Species+</a> database according to the Convention on International Trade of Endangered Species, (CITES),  <a href="http://eol.org/">Encyclopedia of Life</a> and <a href="https://commons.wikimedia.org/wiki/Main_Page">Wikimedia Commons.</a> ';
} else {
	$copyrightText1 = 'Réalisé par <a href="https://fr.okfn.org/">Open Knowledge France</a> et <a href="http://www.natural-solutions.eu/">Natural Solutions</a>, avec le soutien du <a href="https://www.diplomatie.gouv.fr/">Ministère de l’Europe et des Affaires Étrangères</a>';
	$copyrightText2 = 'Sources des données:<a href="https://www.speciesplus.net/"> Species+</a> issues de la convention sur le commerce international des espèces de faune et de flore sauvages menacées d’extinction (CITES), <a href="http://eol.org/">Encyclopedia of Life</a> et <a href="https://commons.wikimedia.org/wiki/Main_Page">Wikimedia Commons</a>.';
}

 // Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get copyright text
$copy = get_theme_mod( 'ocean_footer_copyright_text', 'Copyright - OceanWP Theme by Nick' );
$copy = oceanwp_tm_translation( 'ocean_footer_copyright_text', $copy );

// Get footer menu location and apply filters for child theming
$menu_location = 'footer_menu';
$menu_location = apply_filters( 'ocean_footer_menu_location', $menu_location);

// Visibility
$visibility = get_theme_mod( 'ocean_bottom_footer_visibility', 'all-devices' );

// Inner classes
$wrap_classes = array( 'clr' );
if ( ! has_nav_menu( $menu_location ) ) {
	$wrap_classes[] = 'no-footer-nav';
}
if ( 'all-devices' != $visibility ) {
	$wrap_classes[] = $visibility;
}
$wrap_classes = implode( ' ', $wrap_classes ); ?>

<?php do_action( 'ocean_before_footer_bottom' ); ?>

<div id="footer-bottom" class="<?php echo esc_attr( $wrap_classes ); ?>">

	<?php do_action( 'ocean_before_footer_bottom_inner' ); ?>

	<div id="footer-bottom-inner" class="container clr">

		<?php
		// Display footer bottom menu if location is defined
		if ( has_nav_menu( $menu_location ) ) : ?>

			<div id="footer-bottom-menu" class="navigation clr">
				<?php
				// Display footer menu
				wp_nav_menu( array(
					'theme_location' => $menu_location,
					'sort_column'    => 'menu_order',
					'fallback_cb'    => false,
				) ); ?>

			</div><!-- #footer-bottom-menu -->

		<?php endif; ?>

		<?php
		// Display copyright info
		
		if ( $copy ) : ?>

			<div id="copyright" class="clr" role="contentinfo">
				<?php //echo wp_kses_post( do_shortcode( $copy ) ); ?>
				<?php echo ($copyrightText1); ?>
				<br/>
				<?php echo ($copyrightText2); ?>
			</div><!-- #copyright -->

		<?php endif; ?>
		

	</div><!-- #footer-bottom-inner -->

	<?php do_action( 'ocean_after_footer_bottom_inner' ); ?>

</div><!-- #footer-bottom -->

<?php do_action( 'ocean_after_footer_bottom' ); ?>