<?php get_header(); ?>
<?php 
/* Template Name: Custom Search */

//get search name and tax string

//search_tax is the select element in search form and is to be used and submitted into WP search

$search_tax = (isset($_GET["search_tax"]) && $_GET["search_tax"] != "")? $_GET["search_tax"] : "";

$search_name = (isset($_GET["search_name"]) && $_GET["search_name"] != "")? $_GET["search_name"] : "";

$srch = (isset($_GET["srch"]) && $_GET["srch"] != "")? $_GET["srch"] : "";

?>

<script type="text/javascript">
function clearForm() {	
	/* window.location.search += '?srch=&search_name=any&search_tax=any'; */
	window.location.href="/custom/?srch=&search_name=any&search_tax=any";
	document.getElementById("searchform").reset();
	
}
</script>

<?php 
 function find_my_array ($string, $array = array ()) 

    {  
    foreach ($array as $key => $value) {

          if ( $value->name == $string ) {

            return true; // nu tre sa cautam mai departe la cum ai creat tu if-ul de mai jos.Ajunge sa gasim o singura data. 

            //Putem sa iesim aici ca sa nu mai continuam cu cautarile. Am gasit ce ne interesa, daca mai continuam doar pierdem timp.

        }  

        }

        

        //daca ajunge aici inseamna ca nu a gasit nimic. Nu mai trebuie sa facem nici un if. Putem returna simplu false 

        //daca gaseste nu ajunge niciodata aici

        return false;    

    } 
	

?>

<!-- physician drop-down -->
<form action="" id="myform">
<div class="filters"> 
<select class="drop-down" id="search_name" name="select_post_type" onChange="((this.options[this.selectedIndex].value != '') ? document.location.href=this.options[this.selectedIndex].value : false);">
<?php while (have_posts()) : the_post(); ?>
<option value="" selected="selected" class="holder">Search by doctor's name</option>
<?php

$args = array(
    'post_type' => 'wp_md_doctors',
	'numberposts' => 999,  
	'orderby'=> 'first', 
	'order' => 'ASC'
);
$posts = get_posts($args);  
foreach ($posts as $post){ 
?> 
<option value="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_post_meta($post->ID, 'wp_mdfirst', true); ?></option>
<?php } endwhile; ?>
</select>
</div>
</form>
<!-- end -->

    <div class="or-statement">or</div>
    
<!-- speciality drop down -->
<form role="search" method="get" id="searchform" action="<?php bloginfo('url');?>/search/" >  
    <div class="filters"> 
    <select class="drop-down" name="search_tax" id="search_tax" onchange="this.form.submit()">
<?php //define default post category any to match all categories

        $post_default_option_value_name = "any"; 

        if (!$search_name) {

            $search_name ="any";
           
        }?>
    
            <?php 

            $taxonomy1     = 'wp_md_speciality';

            $show_count   = 0;      // 1 for yes, 0 for no

            $pad_counts   = 0;      // 1 for yes, 0 for no

            $hierarchical = 1;      // 1 for yes, 0 for no

            $title        = '';



            $args = array(

                'taxonomy'     => $taxonomy1,

                'show_count'   => $show_count,

                'pad_counts'   => $pad_counts,

                'hierarchical' => $hierarchical,

                'title_li'     => $title,
				
				'order_by'     => $post_title,
				
				'order' => 'ASC',


            );

            $categories = get_categories( $args ); ?>

                    <?php $post_default_option_value_tax = "any"; 

                    if (!$search_tax) {

                        $search_tax ="any";

                     }?>

                    <option value="<?php echo $post_default_option_value_tax; ?>"<?php echo ($post_default_option_value_tax == $search_tax)? " selected" : ""; ?>>Filter by speciality</option>

                    <?php 

                    foreach ($categories as $cat) {

                        if ($cat->count) { ?>

                              <?php  $option_value = $cat->cat_name; ?>

                              <option value="<?php echo $option_value ?>"<?php echo ($option_value == $search_tax)? " selected" : ""; ?>>

                                <?php echo $cat->cat_name; ?>

                             </option>

                             <?php 

                        }

                        else {

                            // do nothing if the category has no post

                        }

                    }

                    ?>                  

    </select>
</div>
<div class="search_buttons">
<input type="submit" id="searchsubmit" value="Search" class="search-button" />
</div>
</form>
<!-- end -->

<?php if ($srch=="" && $search_name =="any" && $search_tax =="any") { ?>

<?php } else { ?>

<br /><br />

<!-- Determine if the it's Orthopaedic Surgery department -->
<?php if ($search_tax =="Orthopedic Surgery") {?>

<h1>USC Faculty Physicians</h1>
<br />

<ul class="list" style="display:block">
    
    <?php query_posts('post_type=wp_md_doctors&wp_md_faculty=faculty&posts_per_page=999&order=DESC&orderby=post_title'); ?>
            
    <?php   $inc = 0; ?>

    <?php while ( have_posts() ) : the_post(); ?>

                <?php
	            $mtitle = $post -> post_title;

                $custom_meta = get_post_custom($post->ID);

                $terms = wp_get_post_terms( $post->ID, $taxonomy1, $args );

                $buildings = wp_get_post_terms( $post->ID, $taxonomy2, $args );
                
                $faculties = wp_get_post_terms( $post->ID, $taxonomy3, $args );

                $adress = $custom_meta['wp_mdadress'][0];

                $phone = $custom_meta['wp_mdphone'][0];

                $fax = $custom_meta['wp_mdfax'][0];

                $website = $custom_meta['wp_mdwebsite'][0];

                $school = $custom_meta['wp_mdschool'][0];

                $internship = $custom_meta['wp_mdinternship'][0];

                $fellowship = $custom_meta['wp_mdfellowship'][0];
			
			    $image = $custom_meta['wp_mdimage'][0];

                $gender = $custom_meta['wp_mdgender'][0];
				
				$profile_url = $post -> post_name;
				
			

                ?>

                
				
				<?php  $arraysrch = explode(' ', $srch ); ?>

                <?php if ( ( ($search_name == "any" ) || ($search_name == $mtitle ) ) && ( (stripos( $mtitle , $srch  ) !== false ) || !$srch || ( (stripos( $mtitle , $arraysrch[0]  ) !== false ) && (stripos( $mtitle , $arraysrch[1]  ) !== false ) ) ) && ((find_my_array( $search_tax, $terms ) != false) || ($search_tax =="any")) || ($orderby == "DESC")  ) { ?>

              <?php 

                $inc++;

                ?>

                <li class="list-item">


<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>">
                   <?php if(isset($image) && $image != '' ) {
							echo'<img style="float: left; padding: 0px 16px 0px 0px;" width="107" alt="' . $mtitle . '" src="' . $image . '"';
							echo'<div style="clear:both;></div>"';
						} ?>  
                </a>  
                    <div>    
					<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>" class="underline"><h3 class="title name<?php echo $post->ID ?>"><?php echo $mtitle; ?></h3>  </a>                    
                    <div class="specialities">

                     <?php 
					 
					 	echo '<p><strong>Specialties:</strong></p>';

                        foreach ($terms as $term) {

                            echo '<p><span class="cat' . $term->term_id . '">' . $term->name . '</span></p>';  

                        }

                        ?>

                    </div>

                    
                    <?php 
					/*
						if(isset($adress) && $adress != '' ) {
							echo '<p><strong>Address: </strong>' . $adress . '</p>';
						}
						
						if(isset($phone) && $phone != '' ) {
							echo '<p><strong>Phone: </strong>' . $phone . '</p>';
						}
						
						if(isset($fax) && $fax != '' ) {
							echo '<p><strong>Fax: </strong>' . $fax . '</p>';
						}
						
						if(isset($website) && $website != '' ) {
							echo '<p><strong>Website: </strong>' . $website . '</p>';
						}
						
						if(isset($school) && $school != '' ) {
							echo '<p><strong>School: </strong>' . $school . '</p>';
						}
						
						if(isset($internship) && $internship != '' ) {
							echo '<p><strong>Internship: </strong>' . $internship . '</p>';
						}
						
						if(isset($fellowship) && $fellowship != '' ) {
							echo '<p><strong>Fellowship: </strong>' . $fellowship . '</p>';
						} 
						if(isset($image) && $image != '' ) {
							echo '<p><strong>image: </strong>' . $fellowship . '</p>';
						} 
						
						if(isset($gender) && $gender != '' ) {
							echo '<p><strong>Gender: </strong>' . $gender . '</p>';
						} 
                    */
                    ?>

                </li>

                <?php } ?>

    <?php endwhile; ?>

</ul>
                
<div style="clear: both !important;"></div>
                
<h1>Staff Physicians</h1>
<br />                

<ul class="list" style="display:block">
    
    <?php query_posts('post_type=wp_md_doctors&wp_md_faculty=non-faculty&posts_per_page=999&order=DESC&orderby=post_title'); ?>
            
    <?php   $inc = 0; ?>

    <?php while ( have_posts() ) : the_post(); ?>

                <?php 
	            $mtitle = $post -> post_title;

                $custom_meta = get_post_custom($post->ID);

                $terms = wp_get_post_terms( $post->ID, $taxonomy1, $args );

                $buildings = wp_get_post_terms( $post->ID, $taxonomy2, $args );
                
                $faculties = wp_get_post_terms( $post->ID, $taxonomy3, $args );

                $adress = $custom_meta['wp_mdadress'][0];

                $phone = $custom_meta['wp_mdphone'][0];

                $fax = $custom_meta['wp_mdfax'][0];

                $website = $custom_meta['wp_mdwebsite'][0];

                $school = $custom_meta['wp_mdschool'][0];

                $internship = $custom_meta['wp_mdinternship'][0];

                $fellowship = $custom_meta['wp_mdfellowship'][0];
				
				$image = $custom_meta['wp_mdimage'][0];

                $gender = $custom_meta['wp_mdgender'][0];
				
				$profile_url = $post -> post_name;
				
                ?>               
				
				<?php  $arraysrch = explode(' ', $srch ); ?>

                <?php if ( ( ($search_name == "any" ) || ($search_name == $mtitle ) ) && ( (stripos( $mtitle , $srch  ) !== false ) || !$srch || ( (stripos( $mtitle , $arraysrch[0]  ) !== false ) && (stripos( $mtitle , $arraysrch[1]  ) !== false ) ) ) && ((find_my_array( $search_tax, $terms ) != false) || ($search_tax =="any")) || ($orderby == "DESC")  ) { ?>

              <?php 

                $inc++;

                ?>

                <li class="list-item">

<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>">
                   <?php if(isset($image) && $image != '' ) {
							echo'<img style="float: left; padding: 0px 16px 0px 0px;" width="107" alt="' . $mtitle . '" src="' . $image . '"';
							echo'<div style="clear:both;></div>"';
						} ?>  
                </a>  
                    <div>    
					<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>" class="underline"><h3 class="title name<?php echo $post->ID ?>"><?php echo $mtitle; ?></h3>  </a>                    
                    <div class="specialities">

                     <?php 
					 
					 	echo '<p><strong>Specialties:</strong></p>';

                        foreach ($terms as $term) {

                            echo '<p><span class="cat' . $term->term_id . '">' . $term->name . '</span></p>';  

                        }

                        ?>

                    </div>               


                    <?php 
					/*
						if(isset($adress) && $adress != '' ) {
							echo '<p><strong>Address: </strong>' . $adress . '</p>';
						}
						
						if(isset($phone) && $phone != '' ) {
							echo '<p><strong>Phone: </strong>' . $phone . '</p>';
						}
						
						if(isset($fax) && $fax != '' ) {
							echo '<p><strong>Fax: </strong>' . $fax . '</p>';
						}
						
						if(isset($website) && $website != '' ) {
							echo '<p><strong>Website: </strong>' . $website . '</p>';
						}
						
						if(isset($school) && $school != '' ) {
							echo '<p><strong>School: </strong>' . $school . '</p>';
						}
						
						if(isset($internship) && $internship != '' ) {
							echo '<p><strong>Internship: </strong>' . $internship . '</p>';
						}
						
						if(isset($fellowship) && $fellowship != '' ) {
							echo '<p><strong>Fellowship: </strong>' . $fellowship . '</p>';
						} 
						
						if(isset($image) && $image != '' ) {
							echo '<p><strong>Image: </strong>' . $image . '</p>';
						} 
						
						if(isset($gender) && $gender != '' ) {
							echo '<p><strong>Gender: </strong>' . $gender . '</p>';
						} 
                    */
                    ?>

                </li>
                
                <?php } ?>

    <?php endwhile; ?>

</ul>

<div style="clear: both !important;"></div>

<!-- If it's not Orthopaedic Surgery, display search results without <H1> headings, separated out USC Faculty from VHH Staff Physicians -->
<?php } else { ?>

<ul class="list" style="display:block">
    
    <?php query_posts('post_type=wp_md_doctors&posts_per_page=999&order=DESC&orderby=post_title'); ?>
            
    <?php   $inc = 0; ?>

    <?php while ( have_posts() ) : the_post(); ?>

                <?php
	            $mtitle = $post -> post_title;

                $custom_meta = get_post_custom($post->ID);

                $terms = wp_get_post_terms( $post->ID, $taxonomy1, $args );

                $buildings = wp_get_post_terms( $post->ID, $taxonomy2, $args );
                
                $faculties = wp_get_post_terms( $post->ID, $taxonomy3, $args );

                $adress = $custom_meta['wp_mdadress'][0];

                $phone = $custom_meta['wp_mdphone'][0];

                $fax = $custom_meta['wp_mdfax'][0];

                $website = $custom_meta['wp_mdwebsite'][0];

                $school = $custom_meta['wp_mdschool'][0];

                $internship = $custom_meta['wp_mdinternship'][0];

                $fellowship = $custom_meta['wp_mdfellowship'][0];
				
				$image = $custom_meta['wp_mdimage'][0];


                $gender = $custom_meta['wp_mdgender'][0];
				
				$profile_url = $post -> post_name;
				
                ?>               
				
				<?php  $arraysrch = explode(' ', $srch ); ?>

                <?php if ( ( ($search_name == "any" ) || ($search_name == $mtitle ) ) && ( (stripos( $mtitle , $srch  ) !== false ) || !$srch || ( (stripos( $mtitle , $arraysrch[0]  ) !== false ) && (stripos( $mtitle , $arraysrch[1]  ) !== false ) ) ) && ((find_my_array( $search_tax, $terms ) != false) || ($search_tax =="any")) || ($orderby == "DESC")  ) { ?>

              <?php 

                $inc++;

                ?>

                
                <li class="list-item" style="width: auto;">
                <a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>">
                   <?php if(isset($image) && $image != '' ) {
							echo'<img style="float: left; padding: 0px 16px 0px 0px;" width="107" alt="' . $mtitle . '" src="' . $image . '"';
							echo'<div style="clear:both;></div>"';
						} ?>  
                </a>  
                    <div>    
					<a href="<?php echo esc_url( get_permalink( get_page_by_title( 'search' ) ) ); ?>" title="<?php echo $mtitle; ?>" class="underline"><h3 class="title name<?php echo $post->ID ?>"><?php echo $mtitle; ?></h3>  </a>
                    
                   <div class="specialities">

                     <?php 
					 
					 	echo '<p><strong>Specialties:</strong></p>';

                        foreach ($terms as $term) {

                            echo '<p><span class="cat' . $term->term_id . '">' . $term->name . '</span></p>';  

                        }

                        ?>

                    </div>            

                    
                    
                    <?php 
					
						/* if(isset($adress) && $adress != '' ) {
							echo '<p><strong>Address: </strong>' . $adress . '</p>';
						}
						
						if(isset($phone) && $phone != '' ) {
							echo '<p><strong>Phone: </strong>' . $phone . '</p>';
						}
						
						if(isset($fax) && $fax != '' ) {
							echo '<p><strong>Fax: </strong>' . $fax . '</p>';
						}
						
						if(isset($website) && $website != '' ) {
							echo '<p><strong>Website: </strong>' . $website . '</p>';
						}
						
						if(isset($school) && $school != '' ) {
							echo '<p><strong>School: </strong>' . $school . '</p>';
						}
						
						if(isset($internship) && $internship != '' ) {
							echo '<p><strong>Internship: </strong>' . $internship . '</p>';
						}
						
						if(isset($fellowship) && $fellowship != '' ) {
							echo '<p><strong>Fellowship: </strong>' . $fellowship . '</p>';
						} 
						
						
						
						if(isset($gender) && $gender != '' ) {
							echo '<p><strong>Gender: </strong>' . $gender . '</p>';
						} 
                    */
                    ?>
</div>
                </li>
                
                <?php } ?>

    <?php endwhile; ?>

</ul>

<div style="clear: both !important;"></div>

<?php } ?>

<?php if ($inc == 0) { ?>

    <p> There is no doctor <strong><?php echo $srch; ?></strong> found. </p>

<?php 
    }
} ?>
<?php get_footer(); ?>