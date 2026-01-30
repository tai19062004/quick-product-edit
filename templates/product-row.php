<?php 
    $type = $product->get_type();
    $product->get_permalink();
    ?>

    <!-- ================= PARENT PRODUCT ================= -->
    <tr class="qpe-parent qpe-<?php echo esc_attr($type); ?>" data-id="<?php echo esc_attr($product->get_id()); ?>">

        <!-- ================= TÊN + BADGE ================= -->
        <td>
            <input type="text" class="qpe-title" value="<?php echo esc_attr($product->get_name()); ?>"
                style="width:100%; font-weight:600; margin-bottom:4px;">
        </td>

        <!-- ================= SIMPLE ================= -->
        <?php if ($product->is_type('simple')): ?>

            <td>
                <input type="number" class="qpe-price" value="<?php echo esc_attr($product->get_regular_price()); ?>">
            </td>

            <td>
                <input type="number" class="qpe-sale" value="<?php echo esc_attr($product->get_sale_price()); ?>">
            </td>

            <td>
                <textarea class="qpe-excerpt"><?php
                echo esc_textarea($product->get_short_description());
                ?></textarea>
            </td>

            <td>
                <button class="button button-primary qpe-save">
                    <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                </button>

                <a href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" class="button qpe-view">
                    <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                </a>
            </td>

            <!-- ================= EXTERNAL ================= -->
        <?php elseif ($product->is_type('external')): ?>

            <td colspan="2">
                <em><?php esc_html_e('External product', 'quick-product-editor'); ?></em>
            </td>

            <td>
                <input type="url" class="qpe-external-url" value="<?php echo esc_attr($product->get_product_url()); ?>"
                    placeholder="https://">

                <br><br>

                <input type="text" class="qpe-external-btn" value="<?php echo esc_attr($product->get_button_text()); ?>"
                    placeholder="<?php esc_attr_e('Button text', 'quick-product-editor'); ?>">
            </td>

            <td>
                <button class="button button-primary qpe-save">
                    <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                </button>

                <a href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" class="button qpe-view">
                    <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                </a>
            </td>

            <!-- ================= GROUPED ================= -->
        <?php elseif ($product->is_type('grouped')): ?>

            <?php
            $grouped_desc = get_post_field('post_content', $product->get_id());
            ?>

            <td colspan="2">
                <strong><?php esc_html_e('Sản phẩm theo nhóm', 'quick-product-editor'); ?></strong><br>
                <small>
                    <?php esc_html_e(
                        'Hiển thị danh sách các sản phẩm con. Có thể thêm mô tả giới thiệu.',
                        'quick-product-editor'
                    ); ?>
                </small>
            </td>

            <td>
                <textarea class="qpe-grouped-desc"
                    placeholder="<?php esc_attr_e('Mô tả sản phẩm nhóm (SEO)', 'quick-product-editor'); ?>"
                    rows="3"><?php echo esc_textarea($grouped_desc); ?></textarea>
            </td>

            <td>
                <button class="button button-primary qpe-save">
                    <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                </button>

                <a href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" class="button qpe-view">
                    <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                </a>
            </td>

            <!-- ================= VARIABLE ================= -->
        <?php else: ?>

            <td colspan="3">
                <em><?php esc_html_e(
                    'Sản phẩm cha – chỉnh ở dòng con',
                    'quick-product-editor'
                ); ?></em>
            </td>
            <td>
                <button class="button button-primary qpe-save">
                    <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                </button>
                <a href="<?php echo esc_url($product->get_permalink()); ?>" target="_blank" class="button qpe-view">
                    <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                </a>
            </td>

        <?php endif; ?>
    </tr>

    <!-- ================= VARIABLE → VARIATIONS ================= -->
    <?php if ($product->is_type('variable')):
        foreach ($product->get_children() as $vid):
            $v = wc_get_product($vid);
            if (!$v)
                continue;
            ?>
            <tr class="qpe-child qpe-variation" data-id="<?php echo esc_attr($vid); ?>"
                data-parent="<?php echo esc_attr($product->get_id()); ?>">

                <td class="qpe-indent">
                    ↳ <?php echo esc_html($v->get_name()); ?>
                </td>

                <td>
                    <input type="number" class="qpe-price" value="<?php echo esc_attr($v->get_regular_price()); ?>">
                </td>

                <td>
                    <input type="number" class="qpe-sale" value="<?php echo esc_attr($v->get_sale_price()); ?>">
                </td>

                <td>
                    <textarea class="qpe-variation-desc"
                        placeholder="<?php esc_attr_e('Mô tả biến thể', 'quick-product-editor'); ?>"><?php
                           echo esc_textarea($v->get_description());
                           ?></textarea>
                </td>

                <td>
                    <button class="button qpe-save button-primary">
                        <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                    </button>
                    <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" target="_blank" class="button qpe-view">
                        <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>

    <!-- ================= GROUPED → CHILD SIMPLE ================= -->
    <?php if ($product->is_type('grouped')):
        foreach ($product->get_children() as $cid):
            $c = wc_get_product($cid);
            if (!$c)
                continue;
            ?>
            <tr class="qpe-child qpe-grouped-child" data-id="<?php echo esc_attr($cid); ?>"
                data-parent="<?php echo esc_attr($product->get_id()); ?>">

                <td class="qpe-indent">
                    ↳ <?php echo esc_html($c->get_name()); ?>
                </td>

                <td>
                    <input type="number" class="qpe-price" value="<?php echo esc_attr($c->get_regular_price()); ?>">
                </td>

                <td>
                    <input type="number" class="qpe-sale" value="<?php echo esc_attr($c->get_sale_price()); ?>">
                </td>

                <td>
                    <small><?php esc_html_e('Con của grouped', 'quick-product-editor'); ?></small>
                </td>

                <td>
                    <button class="button qpe-save button-primary">
                        <?php esc_html_e('Lưu', 'quick-product-editor'); ?>
                    </button>
                    <a href="<?php echo esc_url($c->get_permalink()); ?>" target="_blank" class="button qpe-view">
                        <?php esc_html_e('Xem nhanh', 'quick-product-editor'); ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; endif; ?>