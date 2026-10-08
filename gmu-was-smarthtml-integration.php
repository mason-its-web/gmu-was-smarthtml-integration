<?php
/**
 * Plugin Name:   Mason WordPress: SmartHTML Integration
 * Description:   Implement SmartHTML PDF conversion app on Mason WordPress Websites
 * Version:       1.0.0
 * Author:        ITS Web Services, George Mason University
 * Author URI:    https://its.gmu.edu
 * Text Domain:   gmu-was-emergencyalerts
 *
 * @package       GMU_WAS_SMARTHTML_INTEGRATION
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin Update Checker.
require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$update_checker = PucFactory::buildUpdateChecker(
    'https://github.com/mason-its-web/gmu-was-pdf2html-integration',
    __FILE__,
    'gmu-was-pdf2html-integration'
);


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
