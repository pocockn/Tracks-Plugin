<?php

/*
* First prevent direct file access
*/

if ( ! defined ( 'ABSPATH' ) ) {
	die();
}

require_once('class-tracks-meta.php');
require_once('class-custom-post-type.php');

// Register activation/deactivation hooks
register_activation_hook( __FILE__, array( 'Tracks_Plugin', 'set_up' ) );
register_deactivation_hook( __FILE__, array('Tracks_Plugin', 'tear_down') );




/**
 * Class: Tracks_PLugin
 *
 * Class which holds all of the core functions for instantiating the plugin when it's first enabled before
 * starting to add new songs and genres
 *
 * Changes or patches added to README.md
 */

Class Tracks_Plugin {

	/**
	* Constructor Setup
	*/

	public function __construct() {

		add_action( 'init', array( 'Tracks_Plugin', 'set_up' ) );
		add_action( 'add_meta_boxes', array('Tracks_MetaBox', 'tracks_song_name' ) );
		add_action( 'add_meta_boxes', array('Tracks_MetaBox', 'tracks_video_link' ) );
		add_action( 'add_meta_boxes', array('Tracks_MetaBox', 'tracks_buyNow_link' ) );
		add_action( 'add_meta_boxes', array('Tracks_MetaBox', 'artists_list' ) );
		add_action( 'save_meta_box_data', array('Tracks_MetaBox', 'save' ) );
		
	}

	/*
	* Call the methods needed to set up the plugin in the WP backend 
	*/

	public static function set_up() {
		// static:: used to reference the called class in a context of static inheritance, as self:: will call the original method definition
		// Explanation http://stackoverflow.com/questions/151969/when-to-use-self-vs-this
		// static:: refers to class, $this refers to current object
		
		Custom_Post_Type::all_custom_post_types();
		static::register_taxonomies();
		flush_rewrite_rules();

	}

	public static function tear_down() {
		  
		flush_rewrite_rules();

	}

	public static function register_taxonomies() {

		$labels = array(
	        'name'              => _x( 'Genres', 'taxonomy general name' ),
	        'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
	        'search_items'      => __( 'Search Genres' ),
	        'all_items'         => __( 'All Genres' ),
	        'parent_item'       => __( 'Parent Genre' ),
	        'parent_item_colon' => __( 'Parent Genre:' ),
	        'edit_item'         => __( 'Edit Genre' ),
	        'update_item'       => __( 'Update Genre' ),
	        'add_new_item'      => __( 'Add New Genre' ),
	        'new_item_name'     => __( 'New Genre Name' ),
	        'menu_name'         => __( 'Genre' ),
	    	);

	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'genre' ),
	    );

	    register_taxonomy( 'genre', array( 'songs' ), $args );

	}

}

