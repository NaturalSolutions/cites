
	<div class="taxon-hierarchy">
    
    <span class="taxon-hierarchy-label">Rang du taxon </span>: <span  class="taxon-hierarchy-kigdom">Règne</span> / <span  class="taxon-hierarchy-phylum">Embranchement</span> / <span class="taxon-hierarchy-class">Classe</span> / <span  class="taxon-hierarchy-order">Ordre</span> / <span class="taxon-hierarchy-family">Famille</span> / <span class="taxon-hierarchy-genus">Genre</span> / <span class="taxon-hierarchy-species">Espèce</span> / <span class="taxon-hierarchy-subspecies">Sous-espèce</span>
    
    
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
		<h2 class="taxon-title"><?php echo get_post_meta($post->ID, 'Common_Name_FR', true); ?> <span class="details-titleFamily"></span></h2>
		<div class="taxon-scName"><label>Nom scientifique: </label> <span>  <?php echo get_post_meta($post->ID, 'Scientific Name', true); ?></span></div>
		<div class="taxon-geo"><label>Répartition géographique : </label> <span>  <?php echo get_post_meta($post->ID, 'All_distributionfullnames', true); ?></span></div>
		<div class="taxon-cites-container"></div>

	</div>
	