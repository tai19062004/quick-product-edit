<?php
/*
Plugin Name: Quick Product Editor
Description: Sửa nhanh sản phẩm WooCommerce
Version: 1.1
Author: Tai Nguyen
Text Domain: quick-product-editor
Domain Path: /languages
*/

if (!defined('ABSPATH')) exit;

/**
 * =====================================================
 * CONSTANTS
 * =====================================================
 */
define('QPE_PATH', plugin_dir_path(__FILE__));
define('QPE_URL', plugin_dir_url(__FILE__));

/**
 * =====================================================
 * INCLUDE FILES
 * =====================================================
 */
require_once QPE_PATH . './includes/core/class-i18n.php';
require_once QPE_PATH . './includes/class-main.php';
require_once QPE_PATH . './includes/core/class-enqueue.php';
require_once QPE_PATH . './includes/class-page.php';
require_once QPE_PATH . './includes/class-save.php';
require_once QPE_PATH . './includes/class-products.php';