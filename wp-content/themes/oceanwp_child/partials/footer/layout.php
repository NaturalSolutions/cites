<?php
/**
 * Footer layout
 *
 * @package OceanWP WordPress theme
 */
$lang=get_bloginfo("language");

$annexeI = "Endangered. International trade is illegal";
$annexeII = "Vulnerable. International trade is regulated";
$annexeIII = "Vulnerable for at least one country. International trade is regulated";
$helpTitle = "<a href='https://cites.org'>CITES</a> species classification";
    
if ($lang == 'fr-FR'){    
    $annexeI = "Menacée d’extinction. Commerce international illégal";
    $annexeII = "Vulnérable. Commerce international réglementé";
    $annexeIII = "Vulnérable pour au moins un pays. Commerce international réglementé";
    $helpTitle = "Classement <a href='https://cites.org/fra'>CITES</a> des espèces";
}
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<footer id="footer" class="<?php echo esc_attr( oceanwp_footer_classes() ); ?>"<?php oceanwp_schema_markup( 'footer' ); ?>>

    <?php do_action( 'ocean_before_footer_inner' ); ?>

    <div id="footer-inner" class="">

        <!-- status Cites -->
        

			<div class="citesHelp">
				<span class="title"><?php echo($helpTitle); ?></span>
			<div class="row">
                <div class="col-md-4"> 
                <div class="row">
                    <div class="col-md-1 pict helpStatus">
                        <div class="cites_appendix a_I"><span class="spnCitesI">I</span> </div>
                    </div>
                    <div class="col-md-10 pict">
                        <p><?php echo($annexeI); ?></p>
                    </div>	
                </div>
                </div> <!-- fin col 1 -->
                <div class="col-md-4">  
                    <div class="row">
                        <div class="col-md-1 pict helpStatus">
					            <div class="cites_appendix a_II"><span class="spnCitesII">II</span> </div>
				        </div>
				        <div class="col-md-10 pict">
					        <p><?php echo($annexeII); ?></p>
				        </div>
                    </div>
                </div> <!-- fin col 2 --> 
                <div class="col-md-4">  
                    <div class="row">
                    <div class="col-md-1 pict helpStatus">
					<div class="cites_appendix a_III"><span class="spnCitesIII">III</span> </div>
				</div>
				<div class="col-md-10 pict">
					<p><?php echo($annexeIII); ?></p>
				</div>	

                    </div>
                </div> <!-- fin col 3 --> 



			</div>

            </div>

			
			

        
        <?php
        // Display the footer widgets if enabled
        /*if ( oceanwp_display_footer_widgets() ) {
        	get_template_part( 'partials/footer/widgets' );
        }*/

        // Display the footer bottom if enabled
        if ( oceanwp_display_footer_bottom() ) {
        	get_template_part( 'partials/footer/copyright' );
        } ?>
        
    </div><!-- #footer-inner -->

    <?php do_action( 'ocean_after_footer_inner' ); ?>

</footer><!-- #footer -->