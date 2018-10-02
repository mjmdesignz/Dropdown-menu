<?php

// Set up the post type, the meta box and thee save postdata from metabox.
add_action('init', 'wp_md_doctors_registrer_post_type');
add_action( 'init', 'wp_md_create_speciality_taxonomies', 0 );
add_action( 'init', 'wp_md_create_building_taxonomies', 0 );
add_action( 'init', 'wp_md_create_faculty_taxonomies', 0 );
add_action('add_meta_boxes', 'wp_md_add_meddir_metabox');
add_action('save_post', 'wp_md_save_postdata');

    global $meta_box, $post; // get the variables from global $meta_box and $post
// Registers post type

function wp_md_doctors_registrer_post_type() {
		$doctor_args = array (
			'public' => true,
			'query_var' => 'the_doctors',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'doctors'
				),
			'supports' => array( 
				'title',
				'name'
				),
			'labels' => array(
				'name' => __( 'Add a person' ),
				'singular_name' => __( 'Person' ),
				'add_new_item' => __( 'Add New Person' ),
                'edit_item' => __( 'Edit Person' )
				),
			'taxonomies' => array( 
				'wp_md_speciality'
			 	)
			);
		register_post_type ('wp_md_doctors', $doctor_args ); 
}

// Create Speciality taxonomy

function wp_md_create_speciality_taxonomies() {
   	$speciality_args = array(
            'labels' => array(
                'name' => 'Speciality',
                'add_new_item' => 'Add New Speciality',
                'new_item_name' => "New Speciality"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
    );
    register_taxonomy( 'wp_md_speciality', 'wp_md_doctors', $speciality_args);
}

function wp_md_create_building_taxonomies() {
    $building_args = array(
            'labels' => array(
                'name' => 'Building',
                'add_new_item' => 'Add New Building',
                'new_item_name' => "New Building"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
    );
    register_taxonomy( 'wp_md_building', 'wp_md_doctors', $building_args);
}

function wp_md_create_faculty_taxonomies() {
    $faculty_args = array(
            'labels' => array(
                'name' => 'Faculty',
                'add_new_item' => 'Add New Faculty Option',
                'new_item_name' => "New Faculty Option"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
    );
    register_taxonomy( 'wp_md_faculty', 'wp_md_doctors', $faculty_args);
}

// adds a box to the main column on the custom post type edit screens 

// custom meta box
$prefix = 'wp_md'; // a custom prefix to help us avoid pulling data from the wrong meta box
$meta_box = array(
    'id' => 'doctor_info', // the id of our meta box
    'title' => 'Doctor Info', // the title of the meta box
    'page' => 'wp_md_doctors', // display this meta box on post editing screens
    'context' => 'advanced',
    'priority' => 'high', // keep it near the top
    'fields' => array( // all of the options inside of our meta box
	/* first name */
	array (
            'name' => 'Full Name',
            'desc' => 'Persons Full Name',
            'id' => $prefix . 'first',
            'type' => 'text',
            'std' => '',
			'orderby'=> 'first', 
			'order' => 'ASC'
        ),

			
        array (
            'name' => 'Address',
            'desc' => 'Please write the persons adress',
            'id' => $prefix . 'adress',
            'type' => 'text',
            'std' => ''
        ),
		
		array(
            'name' => 'Phone',
            'desc' => 'Please enter the persons phone number',
            'id' => $prefix . 'phone',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Fax',
            'desc' => 'Please write the persons fax',
            'id' => $prefix . 'fax',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Email',
            'desc' => 'Please write the persons email',
            'id' => $prefix . 'website',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'School',
            'desc' => 'Please write the persons Medical School',
            'id' => $prefix . 'school',
            'type' => 'text',
            'std' => ''
        ),
         array(
            'name' => 'Internship',
            'desc' => 'Please write the persons internship place',
            'id' => $prefix . 'internship',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Fellowships',
            'desc' => 'Please write the persons Medical Fellowships',
            'id' => $prefix . 'fellowship',
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => 'Physician Photo',
            'desc' => '',
            'id' => $prefix . 'image',
            'type' => 'text',
            'std' => ''
        ),
	
		
        // array(
        //     'name' => 'Languages',
        //     'desc' => 'Please write the doctors spoken languages',
        //     'id' => $prefix . 'languages',
        //     'type' => 'text',
        //     'std' => ''
        // ),
        // array(
        //     'name' => 'Additional Details',
        //     'desc' => 'Enter extra post details here',
        //     'id' => $prefix . 'add_details',
        //     'type' => 'textarea',
        //     'std' => ''
        // ),
        array(
            'name' => 'Select the gender',
            'id' => $prefix . 'gender',
            'type' => 'select',
            'options' => array('Male', 'Female')
        )
    )
);
function wp_md_add_meddir_metabox() {
		global $meta_box; // get all of the options from the $meta_box array
	    add_meta_box($meta_box['id'], $meta_box['title'], 'display_html', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}


// Callback function to show fields in meta box
function display_html() {   
    
     global $meta_box, $post; // get the variables from global $meta_box and $post


    // Use nonce for verification to check that the person has adequate priveleges
    echo '<input type="hidden" name="my_first_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	// create the table which the options will be displayed in
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) { // do this for each array inside of the fields array
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>', // create a table row for each option
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {

            case 'text': // the HTML to display for type=text options
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '
', $field['desc'];
                break;     

            case 'textarea': // the HTML to display for type=textarea options
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '
', $field['desc'];
                break;

            case 'select': // the HTML to display for type=select options
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;

            case 'radio': // the HTML to display for type=radio options
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;

            case 'checkbox': // the HTML to display for type=checkbox options
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '<td>',
            '</tr>';
    }
    echo '</table>';
}

// save the box options

/* When the post is saved, saves our custom data */

function wp_md_save_postdata($post_id) {
     global $meta_box;

    // verify nonce -- checks that the user has access
    if (!wp_verify_nonce($_POST['my_first_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) { // save each option
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) { // compare changes to existing values
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}


function foo_modify_query_order( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'foo_modify_query_order' );




?>