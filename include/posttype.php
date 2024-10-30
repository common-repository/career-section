<?php
add_action( 'init', 'career_section_posttype' );
function career_section_posttype() {
	$labels = array(
		'name'               => _x( 'Career Section', 'post type general name', 'csaf' ),
		'singular_name'      => _x( 'Career Section', 'post type singular name', 'csaf' ),
		'menu_name'          => _x( 'Career Section', 'admin menu', 'csaf' ),
		'name_admin_bar'     => _x( 'Career Section', 'add new on admin bar', 'csaf' ),
		'add_new'            => _x( 'Add New', 'Career Section', 'csaf' ),
		'add_new_item'       => __( 'Add New CSection', 'csaf' ),
		'new_item'           => __( 'New CSection', 'csaf' ),
		'edit_item'          => __( 'Edit CSection', 'csaf' ),
		'view_item'          => __( 'View CSection', 'csaf' ),
		'all_items'          => __( 'All CSection', 'csaf' ),
		'search_items'       => __( 'Search CSection', 'csaf' ),
		'parent_item_colon'  => __( 'Parent CSection:', 'csaf' ),
		'not_found'          => __( 'No CSection found.', 'csaf' ),
		'not_found_in_trash' => __( 'No CSection found in Trash.', 'csaf' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'csaf' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'csection' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'           => 'dashicons-buddicons-buddypress-logo',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);
	register_post_type( 'csection', $args );
}
//gallery Taxonomy
add_action( 'init', 'csection_taxonomy', 0 );
function csection_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'CS Category', 'taxonomy general name', 'csaf' ),
		'singular_name'     => _x( 'CS Categories', 'taxonomy singular name', 'csaf' ),
		'search_items'      => __( 'Search CS Categories', 'csaf' ),
		'all_items'         => __( 'All CS', 'csaf' ),
		'parent_item'       => __( 'Parent CS', 'csaf' ),
		'parent_item_colon' => __( 'Parent CS:', 'csaf' ),
		'edit_item'         => __( 'Edit CS', 'csaf' ),
		'update_item'       => __( 'Update CS', 'csaf' ),
		'add_new_item'      => __( 'Add New CS', 'csaf' ),
		'new_item_name'     => __( 'New CS', 'csaf' ),
		'menu_name'         => __( 'CS Categories', 'csaf' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'csection_cat' ),
	);
	register_taxonomy( 'csection_cat', array( 'csection' ), $args );
	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'CS Tags', 'taxonomy general name', 'csaf' ),
		'singular_name'              => _x( 'CS', 'taxonomy singular name', 'csaf' ),
		'search_items'               => __( 'Search CS Tags', 'csaf' ),
		'popular_items'              => __( 'Popular CS Tags', 'csaf' ),
		'all_items'                  => __( 'All CS Tags', 'csaf' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit CS Tags', 'csaf' ),
		'update_item'                => __( 'Update CS Tags', 'csaf' ),
		'add_new_item'               => __( 'Add New CS Tags', 'csaf' ),
		'new_item_name'              => __( 'New CS', 'csaf' ),
		'separate_items_with_commas' => __( 'Separate CS commas', 'csaf' ),
		'add_or_remove_items'        => __( 'Add or remove CS', 'csaf' ),
		'choose_from_most_used'      => __( 'Choose from the most used CS', 'csaf' ),
		'not_found'                  => __( 'No CS found.', 'csaf' ),
		'menu_name'                  => __( 'CS Tags', 'csaf' ),
	);
	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'cs_tag' ),
	);
	register_taxonomy( 'cs_tag', 'csection', $args );
}
?>