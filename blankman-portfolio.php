<?php
/**
 * Blankman Portfolio
 * 
 * @package     PluginPackage
 * @author      Richard Alexander
 * @copyright   2018 Richard Alexander
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Blankman Portfolio
 * Plugin URI:  https://richardjalexander.com
 * Description: Creates a project custom post type with admin thumbnails.
 * Version:     1.0.0
 * Author:      Richard Alexander
 * Author URI:  https://richardjalexander.com
 * Text Domain: blankman-portfolio
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();

/**
 * The Blankman_Portfolio class
 */
class Blankman_Portfolio {

	/**
	 * The constructor method for the Blankman_Portfolio class
	 */
	function __construct() {
		add_action( 'init', array( $this, 'portfolio_init' ) );
		add_filter( 'manage_edit-project_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_project_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );
	}

	/**
	 * Register project post type
	 */
	function portfolio_init() {
		// Register the post type
		$labels = array(
			'name' => 'Projects',
			'singular_name' => 'Project',
			'all_items' => 'All Projects',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Project',
			'edit_item' => 'Edit Project',
			'new_item' => 'New Project',
			'view_item' => 'View Project',
			'search_items' => 'Search Projects',
			'not_found' => 'No Projects found',
			'not_found_in_trash' => 'No Projects found in Trash'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-portfolio',
			'rewrite' => array( 'slug' => 'project' ),
			'supports' => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'project', $args );

		// Register project categories
		$cat_labels = array(
			'name' => 'Project Categories',
			'singular_name' => 'Category',
			'search_items' => 'Search Categories',
			'all_items' => 'All Categories',
			'parent_item' => 'Parent Category',
			'parent_item_colon' => 'Parent Category:',
			'edit_item' => 'Edit Category',
			'update_item' => 'Update Category',
			'add_new_item' => 'Add New Category',
			'new_item_name' => 'New Category Name',
			'menu_name' => 'Categories',
		);
		$cat_args = array(
			'labels' => $cat_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_tagcloud' => false,
			'query_var' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'project-category' ),
		);
		register_taxonomy( 'project-category', array( 'project' ), $cat_args );
	}

	/**
	 * Add thumbnail column
	 */
	function add_thumbnail_column( $columns ) {
		$column_thumb = array( 'thumbnail' => 'Thumbnail' );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );
		return $columns;
	}

	/**
	 * Display thumbnail
	 */
	function display_thumbnail( $column ) {
		global $post;
		switch ( $column ) {
			case 'thumbnail' :
				echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
				break;
		}
	}

}
new blankman_portfolio();