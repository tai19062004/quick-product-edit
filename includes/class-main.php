<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {

    add_menu_page(
        __('Quick Product Editor', 'quick-product-editor'),
        __('Sửa nhanh sản phẩm', 'quick-product-editor'),
        'manage_woocommerce',
        'quick-product-editor',
        'qpe_page_products',
        'dashicons-products',
        32
    );

    add_submenu_page(
        'quick-product-editor',
        __('Danh sách sản phẩm', 'quick-product-editor'),
        __('Danh sách sản phẩm', 'quick-product-editor'),
        'manage_woocommerce',
        'quick-product-editor',
        'qpe_page_products'
    );
});