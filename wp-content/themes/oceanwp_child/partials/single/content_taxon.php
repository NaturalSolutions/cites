<?php
/**
 * Post single content
 *
 * @package OceanWP WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 
$rank = get_post_meta($post->ID, 'Rank', true); 
$cites = get_post_meta($post->ID, 'CITES', true); 
$type = get_post_type();
$imgfiles = array();
$url=get_site_url().'/wp-content/uploads/photos/'; 

for ($i = 1; $i <= 10; $i++) {

    $fieldName = 'Picture_'.$i.'_File_Name';
    $pictureName = 'Picture_'.$i.'_Name';
    $pictureLicenceName = 'Picture_'.$i.'_License_Name';
    $pictureLicenceUrl = 'Picture_'.$i.'_License_Url';
    $pictureSourceUrl  = 'Picture_'.$i.'_Source_Url';

    $file = get_post_meta($post->ID, $fieldName , true); 

    if ($file){
        $img = array();
        $img[0] = get_post_meta($post->ID, $pictureName , true);  
        $img[1]= $file;  
        $img[2]= get_post_meta($post->ID, $pictureLicenceName , true);  
        $img[3]= get_post_meta($post->ID, $pictureLicenceUrl , true);  
        $img[4]= get_post_meta($post->ID, $pictureSourceUrl , true);  

        $imgfiles[] = $img;
    } 
}
$tab = json_encode($imgfiles);
//var_dump($imgfiles);


if (isset($_GET['lang'])) {
    $lg = $_GET['lang'];
  } else {

    $lg = 'fr';
  }

?>

<?php do_action( 'ocean_before_single_post_content' ); ?>

<div class="entry-content clr"<?php oceanwp_schema_markup( 'entry_content' ); ?>>
    <?php //the_content(); 
    
    
    if($lg== 'fr') {
        get_template_part( 'partials/single/content_fr' );
    } else {
        get_template_part( 'partials/single/content_en' );

    }
    
    
    ?>
    
    
	<?php 
	

	wp_link_pages( array(
		'before'      => '<div class="page-links">' . __( 'Pages:', 'oceanwp' ),
		'after'       => '</div>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	) ); ?>
</div><!-- .entry -->

<?php do_action( 'ocean_after_single_post_content' ); ?>

<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function() {
    var $ = jQuery.noConflict();
    var rank = '<?php echo($rank); ?>' ; 
    var lang =    '<?php echo($lg); ?>' ; 
    var cites =   '<?php echo($cites); ?>' ; 
    var imgFiles = '<?php echo($tab); ?>'; 
    var imgObj = JSON.parse(imgFiles);
    var url = '<?php echo($url); ?>' ; 

   
    var ranklabel = '';
    rank = rank.toUpperCase();
    switch(rank) {
        case "FAMILY":
            $('.taxon-hierarchy-family').addClass('marked');
            if(lang=='fr') {ranklabel= '(famille)';} else {ranklabel= '(family)';}
            break;
        case  "ORDER":
        $('.taxon-hierarchy-order').addClass('marked');
        if(lang=='fr') {ranklabel= '(ordre)';} else {ranklabel= '(order)';}
            break;
            case  "GENUS":
        $('.taxon-hierarchy-genus').addClass('marked');
        if(lang=='fr') {ranklabel= '(genre)';} else {ranklabel= '(genus)';}
            break;
            case  "SUB-FAMILY":
        $('.taxon-hierarchy-family').addClass('marked');
            break;


        default:
            break;
    }
    $('.details-titleFamily').text(ranklabel);

    var cites = getCitesElement(cites, lang, rank);
    $(".taxon-cites-container").html(cites);

    // init swiper

    window.mySwiper = new Swiper ('.swiper-container', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        resizeReInit: true,
    });

    // populate swiper
    for (var i=0; i<imgObj.length;i++) {
        var elem = imgObj[i];
        var pictureName = elem[0];
        var fileName = elem[1];
        var pictureLicenceName = elem[2];
        var pictureLicenceUrl = elem[3];
        var pictureSourceUrl  = elem[4];

        console.log( pictureName + ',' + fileName + ',' +pictureLicenceName + ',' +pictureLicenceUrl + ',' +pictureSourceUrl   );


                    
                    var swiperElem = '<div class="swiper-slide"><img src="';
                    swiperElem  += url + fileName ; 
                    swiperElem  +='"/><div class="swiper-slide-copyright"><span class="imageName"><b>'+ pictureName +'</b></span><br/><span clas=""><a href="'+ pictureLicenceUrl +'" target="_blank">' + pictureLicenceName +'</a></span><span>/ <a href="'+ pictureSourceUrl + '" target="_blank"> source</a></span></div></div>';

                    $('.swiper-wrapper').append(swiperElem);
                    
    }
    window.mySwiper.update(true);



});


</script>