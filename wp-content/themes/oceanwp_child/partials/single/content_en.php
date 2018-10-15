    <div class="taxon-hierarchy">
    
    <span class="taxon-hierarchy-label">Taxon rank</span>: <span  class="taxon-hierarchy-kigdom">Kigdom</span> / <span  class="taxon-hierarchy-phylum">Phylum</span> / <span class="taxon-hierarchy-class">Class</span> / <span  class="taxon-hierarchy-order">Order</span> / <span class="taxon-hierarchy-family">Family</span> / <span class="taxon-hierarchy-genus">Genus</span> / <span class="taxon-hierarchy-species">Species</span> / <span class="taxon-hierarchy-subspecies">Subspecies</span>
    </div>
	<div class="row taxon-details">
	<div class="col-md-6">
		<div class="swiperDiv"> <!--  -->
		<div class="swiper-container">
				<div class="swiper-wrapper" style="width: 500px!important;">

							
				</div> <!-- end of swiper-wrapper -->

		</div> <!-- end of swiper-container -->
		</div>
			<!-- If we need navigation buttons -->
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
	<div class="col-md-6">
    <h2 class="taxon-title"><?php echo get_post_meta($post->ID, 'Common_Name_EN', true); ?> <span class="details-titleFamily"></span></h2>
        
        <div class="taxon-scName"><label>Scientific name: </label> <span>  <?php echo get_post_meta($post->ID, 'Scientific Name', true); ?></span></div>
		<div class="taxon-geo"><label>Geographic Repartition : </label> <span>  <?php echo get_post_meta($post->ID, 'All_distributionfullnames', true); ?></span></div>

		<div class="taxon-cites-container"></div>


	</div>

