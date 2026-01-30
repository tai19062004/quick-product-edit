<?php
if (!defined('ABSPATH'))
    exit;

add_action('wp_ajax_qpe_load_products', 'qpe_ajax_load_products');

function qpe_ajax_load_products() {

    check_ajax_referer('qpe_nonce', 'nonce');

    $page     = max(1, intval($_POST['page'] ?? 1));
    $per_page = 5;

    $q = new WP_Query([
        'post_type'      => 'product',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'post_status'    => ['publish', 'draft'],
    ]);

    ob_start();

    foreach ($q->posts as $post) {
        $product = wc_get_product($post->ID);
        require plugin_dir_path(__FILE__) . '../templates/product-row.php';
    }

    $html = ob_get_clean();

    wp_send_json_success([
        'html'  => $html,
        'total' => $q->found_posts,
    ]);
}
