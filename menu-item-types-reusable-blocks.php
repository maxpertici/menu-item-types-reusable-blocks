<?php
/*
Plugin Name:  Menu Item Types — Reusable Blocks
Plugin URI:   #
Description:  —
Version:      1.0
Author:       @maxpertici
Author URI:   https://maxpertici.fr
Contributors:
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  mitypes-reusable-blocks
Domain Path:  /languages
*/

defined( 'ABSPATH' ) or	die();


/**
 * Add custom nav menu item
 */
function mitypes_rblocks_add_item_types( $types ){
    $types[] = array(
        'slug'        => "wpblock",
        'label'       => __( 'Reusable Blocks', 'mitypes-reusable-blocks' ),
        'field-group' => plugin_dir_path( __DIR__ ) . 'menu-item-types-reusable-blocks/acf/reusable-blocks-field-group.php',
		'render'      => plugin_dir_path( __DIR__ ) . 'menu-item-types-reusable-blocks/render/wpblock.php',
    );
    return $types;
}

add_filter( 'mitypes_item_types', 'mitypes_rblocks_add_item_types' );


/**
 * Show Reusable Blocks Menu
 */
function mitypes_rblocks_menu_display( $type, $args ) {
	if ( 'wp_block' !== $type ) { return; }
	$args->show_in_menu = true;
	$args->_builtin = false;
	$args->labels->name = esc_html__( 'Reusable Blocks', 'mitypes-reusable-blocks' );
	$args->labels->menu_name = esc_html__( 'Reusable Blocks', 'mitypes-reusable-blocks' );
	$args->menu_icon = 'dashicons-screenoptions';
	$args->menu_position = 58;
}


add_action( 'registered_post_type', 'mitypes_rblocks_menu_display', 10, 2 );


/**
 * Enqueue css on nav-menu screen
 */

function mitypes_rblocks_enqueue_nav_item_styles( $hook ) {

	if ( 'nav-menus.php' != $hook ) {
        return;
    }

	wp_register_style( 'mitypes-rblocks', plugin_dir_url( __FILE__ ) . 'css/mitypes-reusable-blocks.css', array( 'mitypes_nav_menu_style' ), '1.0' );
	wp_enqueue_style( 'mitypes-rblocks' );

}

add_action( 'admin_enqueue_scripts', 'mitypes_rblocks_enqueue_nav_item_styles' );



/**
 * Handle attributes : skip href
 */

function mitypes_rblocks_attributes_skiper( $atts, $item, $args, $depth, $custom_item_type ){
	if( ( 'wpblock' === $custom_item_type ) ){ unset( $atts['href'] ); }
	return $atts ;
}

add_filter( 'mitypes_nav_menu_link_attributes', 'mitypes_rblocks_attributes_skiper', 11, 5 );