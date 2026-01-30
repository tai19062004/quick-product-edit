<?php
if (!defined('ABSPATH'))
    exit;

/**
 * =====================================================
 * AJAX: LƯU NHANH SẢN PHẨM
 * =====================================================
 * - Simple: sửa giá + sale
 * - Variation: sửa giá + sale (+ mô tả nếu có)
 * - External: sửa URL + button text
 */

add_action('wp_ajax_qpe_save_product', function () {

    check_ajax_referer('qpe_nonce', 'nonce');

    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        wp_send_json_error(__('ID không hợp lệ', 'quick-product-editor'));
    }

    // Kiểm tra quyền chỉnh sửa sản phẩm
    if (!current_user_can('edit_post', $id)) {
        wp_send_json_error(__('Bạn không có quyền chỉnh sửa sản phẩm này', 'quick-product-editor'), 403);
    }

    $product = wc_get_product($id);
    if (!$product) {
        wp_send_json_error(__('Không tìm thấy sản phẩm', 'quick-product-editor'));
    }

    // TITLE

    if (!empty($_POST['title'])) {
        $product->set_name(
            sanitize_text_field($_POST['title'])
        );
    }

    // SIMPLE
    if ($product->is_type('simple')) {
        $regular = wc_format_decimal($_POST['price'] ?? '');
        $sale    = wc_format_decimal($_POST['sale'] ?? '');

        $product->set_regular_price($regular);
        $product->set_sale_price($sale);
    }

    // VARIATION
    if ($product->is_type('variation')) {
        $regular = wc_format_decimal($_POST['price'] ?? '');
        $sale    = wc_format_decimal($_POST['sale'] ?? '');

        $product->set_regular_price($regular);
        $product->set_sale_price($sale);

        if (!empty($_POST['description'])) {
            $product->set_description(
                sanitize_textarea_field($_POST['description'])
            );
        }
    }

    // GROUPED
    if ($product->is_type('grouped')) {
        if (isset($_POST['grouped_desc'])) {
            wp_update_post([
                'ID'           => $product->get_id(),
                'post_content' => wp_kses_post($_POST['grouped_desc']),
            ]);
        }
    }

    // EXTERNAL
    if ($product->is_type('external')) {
        /** @var WC_Product_External $product */
        $product = new WC_Product_External($id);

        if (isset($_POST['external_url'])) {
            $product->set_product_url(esc_url_raw($_POST['external_url']));
        }

        if (isset($_POST['button_text'])) {
            $product->set_button_text(sanitize_text_field($_POST['button_text']));
        }
    }

    // MÔ TẢ CHUNG (TRỪ GROUPED)
    if (isset($_POST['description']) && !$product->is_type('grouped')) {
        $product->set_description(
            sanitize_textarea_field($_POST['description'])
        );
    }

    if (isset($_POST['excerpt']) && method_exists($product, 'set_short_description')) {
        $product->set_short_description(
            sanitize_textarea_field($_POST['excerpt'])
        );
    }

    $product->save();

    wp_send_json_success(__('Đã lưu', 'quick-product-editor'));
});

