<?php
/*
Template Name: template home
Template Post Type:  page
*/
 
	get_header();
	$lang=get_bloginfo("language");
	$search = 'search';
	$adv = 'advanced';
	$placeholder = "Specie name";
	$origin_label ="Geographic distribution";
	$body_label = "Body";
	$body_scales = "Scales";
	$body_hair = "Hair or fur";
	$body_features = "Feathers";
	$body_other = "Other";
	$searchResultMsg = "Select your search criterias.";
	$subTitle = "Identify a species and verify whether its trade is illegal or regulated at international level";

	


	
	$caract_label = "Caracteristics";
	$caract_wings = "Wings"; 
	$caract_tail = "Tail";
	$caract_beak = "Beak";
	$caract_shell = "Shell";

	$hide = 'hide';
	if ($lang == 'fr-FR'){
		$search = 'rechercher';
		$adv = 'avancée';
		$hide = 'masquer';
		$placeholder = "Nom de l'espèce";
		$origin_label ="Provient de";
		$body_label = "Couvert de";
		$caract_label = "Possède";
		$body_scales = "Écailles";
		$body_hair = "Poils ou fourrure";
		$body_features = "Plumes";
		$body_other = "Autre";
		$caract_wings = "Ailes"; 
		$caract_tail = "Queue";
		$caract_beak = "Bec";
		$caract_shell = "Coquille";
		$searchResultMsg = "Sélectionnez vos critères de recherche.";
		$subTitle = "Identifier une espèce et vérifier si son commerce international est illégal ou réglementé";
		
		
		
	}
 ?>
<div class="subTitle"><?php  echo($subTitle) ?></div>
<div class="wrap">
	

	<div class="searchContainer">
		<div class="filter">
			<div class="generalSearch row">
				<div class="col-md-12">
				<input  id="searchVal" class="simpleInput form-control" placeholder="<?php echo($placeholder) ?>">
				<button id="advsearchBtn" class="search-btn"><?php echo($search) ?></button>
				<!--<input type="submit" class="search-submit" id="searchBtn">-->
				</div>
				<!--<div class="col-md-4">
				<button id="searchBtn"><?php echo($search) ?></button>
				
				<button id="advShowBtn"><?php echo($adv) ?></button>
				</div>  -->
				
			</div>
			<hr/>
			<div class="advancedSearch  row">
				<div class="col-md-4">
					<label><?php echo($origin_label) ?> :</label>
					<input  id="origin" class="advInput form-control">
				</div>
				<div class="col-md-4">
					<label><?php echo($body_label) ?> :</label>
					<!--<input  id="body" class="advInput form-control">  -->
					<select id="body">
					<option></option>
						<option value="Scales"><?php echo($body_scales) ?> </option>
						<option value="Hair or fur"><?php echo($body_hair) ?></option>
						<option value="Feathers"><?php echo($body_features) ?></option>
						<option value="Other"><?php echo($body_other) ?></option>


					</select>

				</div>
				<div class="col-md-4">
					<label><?php echo($caract_label) ?> :</label>
					<!--<input  id="caract" class="advInput form-control">-->
					<div class="">
						<div class=" inputFilterCheckbox">
							<input type="checkbox" id="Ailes" name="caract"  class="chbox"  
								value="Wings"   />
							<label for="Ailes"><?php echo($caract_wings) ?> </label>
						</div>
						<div  class=" inputFilterCheckbox">
							<input type="checkbox" id="Queue" name="caract"   class="chbox" 
								value="Tail"   />
							<label for="Queue"><?php echo($caract_tail) ?></label>
						</div>
						<div  class=" inputFilterCheckbox">
							<input type="checkbox" id="Bec" name="caract"   class="chbox"   
								value="Beak"   />
							<label for="Bec"><?php echo($caract_beak) ?></label>
						</div>
						<div  class="">
							<input type="checkbox" id="Coquille" name="caract"    class="chbox" 
								value="Shell"   />
							<label for="Coquille"><?php echo($caract_shell) ?></label>
						</div>
						<input class="hidden" id="language" value="<?php echo($lang) ?>">
					</div>
				</div>
				<br/>
				
				<!--<button id="advsearchMaskBtn"><?php echo($hide) ?></button>  -->
			</div>
			
			</div>
		</div>


	


	<div id="primary" class="">
	<div class="row">
		<div id="results" class="col-md-12">
		<p class="textResults"><?php echo($searchResultMsg) ?></p>
		</div>
	</div>
		<!--<main id="main" class="site-main" role="main">

			<?php
			//while ( have_posts() ) : the_post();

				//get_template_part( 'templates/content-page' );

				// If comments are open or we have at least one comment, load up the comment template.
				//if ( comments_open() || get_comments_number() ) :
				//	comments_template();
				//endif;

			//endwhile; // End of the loop.
			//?>

		</main><!-- #main -->  
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();?>

<script type="text/javascript">
var lang = '<?php echo(get_bloginfo("language")); ?>' ; 
//console.log(lang);
localStorage.setItem('lang', lang);

</script>