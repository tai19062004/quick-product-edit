<?php
if (!defined('ABSPATH')) exit;

add_action('admin_enqueue_scripts', function ($hook) {

    if (strpos($hook, 'quick-product-editor') === false) return;

    wp_enqueue_style(
        'qpe-admin-css',
        plugin_dir_url(__FILE__) . '../../assets/css/product.css',
        [],
        '1.1'
    );

    wp_enqueue_script(
        'qpe-admin-js',
        plugin_dir_url(__FILE__) . '../../assets/js/product.js',
        ['jquery'],
        '1.1',
        true
    );

    wp_localize_script('qpe-admin-js', 'QPE', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('qpe_nonce'),
        'i18n'     => [
            'saving' => __('Đang lưu...', 'quick-product-editor'),
            'saved'  => __('Đã lưu', 'quick-product-editor'),
            'error'  => __('Lỗi khi lưu', 'quick-product-editor'),
        ]
    ]);
});
