<div class="wrap">
    <h1><?php esc_html_e('Danh sách sản phẩm', domain: 'quick-product-editor'); ?></h1>

    <table class="widefat striped qpe-table">
        <thead>
            <tr>
                <th><?php esc_html_e('Tên', 'quick-product-editor'); ?></th>
                <th><?php esc_html_e('Giá', 'quick-product-editor'); ?></th>
                <th><?php esc_html_e('Sale', 'quick-product-editor'); ?></th>
                <th><?php esc_html_e('Mô tả ngắn', 'quick-product-editor'); ?></th>
                <th><?php esc_html_e('Lưu', domain: 'quick-product-editor'); ?></th>
            </tr>
        </thead>
        <tbody class="qpe-product-rows"></tbody>
    </table>

    <!-- Panigation cho danh sách sản phẩm -->
    <div class="qpe-pagination" style="margin-top:15px; display:flex; gap:6px; align-items:center;">
        <button class="button qpe-prev">«</button>
        <div class="qpe-pages"></div>
        <button class="button qpe-next">»</button>
    </div>
</div>