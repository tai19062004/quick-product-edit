<?php
if (!defined('ABSPATH')) exit;

/**
 * Load language files
 */
add_action('plugins_loaded', function () {
    load_plugin_textdomain(
        'quick-product-editor',
        false,
        dirname(plugin_basename(__FILE__)) . '/../languages'
    );
});
