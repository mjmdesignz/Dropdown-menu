<?php
/*
Plugin Name: Custom Search Widget
Description: Custom Search Sidebar Widget for LIVE
Version: 2.0
Author: Mitch
*/

/* widget registration */
class wp_custom_search_plugin extends WP_Widget {

	// constructor
	function wp_custom_search_plugin() {
		parent::WP_Widget(false, $name = __('Custom Dropdown Widget', 'wp_custom_search_plugin') );
	}

	// widget form creation
	function form($instance) {	
	// Check values
        if( $instance) {
             $title = esc_attr($instance['title']);

        } else {
             $title = '';

        }
        ?>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
        $instance = $old_instance;
      // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
	}

	// widget display
	function widget($args, $instance) {
	   extract( $args );
	   $doctorByNameArray = array();
	   

		//wp_enqueue_script('customSearch');
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Check if title is set
        if ( $title ) {
           echo $before_title . $title . $after_title;
        }
        
		//END ?>
    
<!-- START Widget -->

<?php 
 
$search_tax = (isset($_GET["search_tax"]) && $_GET["search_tax"] != "")? $_GET["search_tax"] : "";

$search_name = (isset($_GET["search_name"]) && $_GET["search_name"] != "")? $_GET["search_name"] : "";

$srch = (isset($_GET["srch"]) && $_GET["srch"] != "")? $_GET["srch"] : "";

?>

<!-- <div class="hrule"></div> -->
<div class="byName"style="padding-top: 20px;padding-bottom: 15px;">

<!-- physician drop-down -->
<b style="font-size: 12px;">Search by Name:</b>
<br>
<form action="" id="myform">
<div class="filters">
<div class="fixWidth"> 
<select class="drop-down" id="search_name" name="select_post_type" onChange="((this.options[this.selectedIndex].value != '') ? document.location.href=this.options[this.selectedIndex].value : false);">
<?php while (have_posts()) : the_post(); ?>
<option value="" selected="selected" class="holder">Search by name</option>
<?php

$args = array(
	'post_type' => 'wp_md_doctors',
	'numberposts' => 999,
	'order'=> 'ASC',
	
);
$posts = get_posts($args);  
foreach ($posts as $post){ 
?> 
<option value="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_post_meta($post->ID, 'wp_mdfirst', true); ?></option>
<?php } endwhile; ?>
</select>
</div>
</div>
</form>
<!-- end -->   
      
<!--<div class="or-statement">or</div>-->
<div style="margin-top: 10px;"></div>

<!-- speciality drop down -->
<b style="font-size: 12px;">Filter by Feature:</b>
<br>
<div class="fixWidth" style="padding-bottom: 20px;">
<form role="search" method="get" id="searchform" action="<?php bloginfo('url');?>/custom/" >  
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
</div>
</form>
<!-- end -->

<!-- Find a title-->
<div class="find-a-doc" style="padding-bottom: 10px;">
<?php
echo do_shortcode( '[fontawesome icon="fa-user-md" circle="yes" size="38px" iconcolor="#990000" circlecolor="transparent" circlebordercolor="transparent" rotate="" spin="no" animation_type="0" animation_direction="down" animation_speed="0.1" alignment="left" class="" id="doc-icon"]');
?>
<a href="/doctors/">Find a Doctor</a>
</div>

<!-- end Find a Title-->      

<!--Call Us amd Support -->
<div class="dotRule"></div>
<div class="orCall">
	<?php
		echo do_shortcode( '[fontawesome icon="fa-phone" circle="yes" size="38px" iconcolor="#990000" circlecolor="transparent" circlebordercolor="transparent" rotate="" spin="no" animation_type="0" animation_direction="down" animation_speed="0.1" alignment="left" class="" id="doc-icon-phone"]'
	);?>
	<a href="tel:8888888888"><span style="color:#747474;">Call Us:</span> <br/>(888) 888-8888</a>
</div>
<div class="dotRule"></div>
<div class="heart-bucket">
	<?php
		echo do_shortcode( '[fontawesome icon="fa-heart" circle="yes" size="38px" iconcolor="#990000" circlecolor="transparent" circlebordercolor="transparent" rotate="" spin="no" animation_type="0" animation_direction="down" animation_speed="0.1" alignment="left" class="" id="doc-icon-heart"]'
	);?>
</div>
</div>
<!--End Call Us and support -->
        		
<!-- END Widget -->	
        <?php
        echo '</div>';
        echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_custom_search_plugin");'));

?>