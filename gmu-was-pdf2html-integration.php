<?php
/*
Plugin Name: Mason WordPress: PDF2HTML JS Integration
Description: Implement PDF2HTML on Mason WordPress Websites
Version: 1.0.0
Author: ITS Web Services
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function enqueueAssets() {
    $args = array(
        'strategy'      => 'defer',
        'in_footer'     => FALSE,
        'fetchpriority' => 'auto'
    );
    wp_enqueue_script('gmu-was-pdf2html', 'https://ingestion.pdfaccess.app/tohtml.min.js', array(), null, $args);
}
add_action('wp_enqueue_scripts', 'enqueueAssets', 1);

// Intercept the HTML tag and add the crossorigin attribute
function add_crossorigin_attribute($tag, $handle, $src) {
    // Target only your specific script handle
    if ('gmu-was-pdf2html' === $handle) {
        // Add the crossorigin attribute to the HTML script tag
        $tag = str_replace('<script ', '<script crossorigin="anonymous" ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_crossorigin_attribute', 10, 3);
