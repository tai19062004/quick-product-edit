<?php
/**
 * Fired when the plugin is uninstalled.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Nếu plugin KHÔNG lưu option / meta gì → để trống là OK
// (Đây là best practice, không bắt buộc phải xóa dữ liệu WooCommerce)

// Ví dụ nếu sau này có option:
// delete_option('qpe_settings');

// Nếu có meta:
// global $wpdb;
// $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_qpe_%'");
