<?php
/**
 * @package Scholar
 * @version 1.0
 */
/*
Plugin Name: Scholar
Plugin URI: -
Description: Diploma work for creating tests with answers, taking tests and commenting results
Author: Teodor Dobrev
Version: 1.0
Author URI: -
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'SCHOLAR_VERSION', '1.0' );
define( 'SCHOLAR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCHOLAR__CSS_DIR_URL', plugin_dir_url( __FILE__ ) . 'css/' );
define( 'SCHOLAR__JS_DIR_URL', plugin_dir_url( __FILE__ ) . 'js/' );


function create_posttype() {
    register_post_type( 'tests',
        array(
            'labels' => array(
                'name' => 'Tests',
                'singular_name' => 'Tests'
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'tests'),
        )
    );
}
add_action( 'init', 'create_posttype' );

wp_enqueue_style('scholar', SCHOLAR__CSS_DIR_URL . 'scholar.css');

require_once( SCHOLAR__PLUGIN_DIR . 'class.scholar.php' );
require_once( SCHOLAR__PLUGIN_DIR . 'class.processor.php' );

add_action( 'wp_ajax_save_answer', array('Scholar', 'scholar_ajax_save_answer') );

Scholar::init();
add_action( 'admin_menu', array('Scholar', 'scholar_menu') );
register_activation_hook( __FILE__, array( 'Scholar', 'ssql_install' ) );






