<?php

function wp_md_add_meddir_metabox() {
		add_meta_box('wp_md_doctor_info', 'Doctor Info', 'wp_md_inner_doctor_info', 'wp_md_doctors', 'normal', 'default');
}


// adds the callbax function for the innercontent of the metabox
function wp_md_inner_doctor_info() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="meta_noncename" id="meta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$first  = get_post_meta($post->ID, '_first', true);
    $adress  = get_post_meta($post->ID, '_adress', true);
	$phone = get_post_meta($post->ID, '_phone', true);
    $fax = get_post_meta($post->ID, '_fax', true);
    $website = get_post_meta($post->ID, '_website', true);
    $gender = get_post_meta($post->ID, '_gender', true);
    $school = get_post_meta($post->ID, '_school', true);
    $internship = get_post_meta($post->ID, '_internship', true);
    $fellowships = get_post_meta($post->ID, '_fellowships', true);
	$image = get_post_meta($post->ID, '_image', true);
    $languages = get_post_meta($post->ID, '_languages', true);
    
	// Echo out the field
    echo '<div class="misc-pub-section">';
    echo '<p>Adress:</p>';
	echo '<input type="text" name="_adress" value="' . $adress  . '" class="widefat" />';
    echo '<p>Phone</p>';
    echo '<input type="text" name="_phone" value="' . $phone  . '" class="widefat" />';
    echo '<p>Fax:</p>';
	echo '<input type="text" name="_fax" value="' . $fax  . '" class="widefat" />';
    echo '<p>Email:</p>';
    echo '<input type="text" name="_website" value="' . $website  . '" class="widefat" />';
	echo '</div>';
	echo '<div class="misc-pub-section">';
	echo '<p>Gender</p>';
	echo '<input type="text" name="_gender" value="' . $gender  . '" class="widefat" />';
    echo '<p>Medical School:</p>';
    echo '<input type="text" name="_school" value="' . $school  . '" class="widefat" />';
    echo '<p>Internship:</p>';
	echo '<input type="text" name="_internship" value="' . $internship  . '" class="widefat" />';
    echo '<p>Fellowships:</p>';
    echo '<input type="text" name="_fellowships" value="' . $fellowships  . '" class="widefat" />';
	echo '<p>Images:</p>';
    echo '<input type="text" name="_image" value="' . $image . '" class="widefat" />';
	echo '</div>';
}


















add_shortcode('like_button', 'wp_fp_sc_likebutton');

/**
* Adds the like link and count to post/page content
*
* The like link is introduced by applying a filter to 'the_content'
*
* @param $content Puts the content  
* @return $content Returns the content changed.
* @global int $user_ID The UserID Variable  
* @global object $post The post variable
* @uses wp_fp_get_like_count();
* @uses wp_fp_check_user_likes_post();
*/

function wp_fp_display_user_like_list() {
 	
 	//Almost all data that WordPress generates can be found in a global variable.
 	//Note that it's best to use the appropriate API functions when available, instead of modifying globals directly.
	//To access a global variable in your code, you first need to globalize the variable with global $variable;
	//In PHP global variables must be declared global inside a function if they are going to be used in that function.
	$args = array(
	 'post_type' => 'post',
	 'posts_per_page' => 12,
	 'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
	 );
	$x = 0;
	// only show the link when user is logged in and on a singular page
	if ( is_user_logged_in() ) {
 
		ob_start();
		echo '<div class="like-it-list">';
  			while (have_posts()) : the_post(); 
  				if(wp_fp_check_user_likes_post($user_ID, get_the_ID())) {
					echo '<article class="thumb-box span3">';
					echo '<a class="post-thumb" href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_post_thumbnail("thumb_300_170"); ?></a>';
			  		echo '<h5 class="thumb-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>';
					echo '</article>';
				}
			endwhile;
		// close our wrapper DIV
		echo '</div>';
	} else {
	 echo '<article class="thumb-box span12">';
	 echo '<h4>You have to be logged in to see your favorites page</h4>';
	 echo '</span>';                                           
	}
	// append our "like It" link to the item content.
	$likes_list = ob_get_clean();
	return $likes_list;
}
?>