jQuery(function ($) {

    /* =====================================================
     * Validate Price Function
     * ===================================================== */

    function qpeValidatePrice(price, sale) {
        price = price !== '' ? parseFloat(price) : '';
        sale = sale !== '' ? parseFloat(sale) : '';

        if (price !== '' && price < 0) {
            return 'Giá bán không được nhỏ hơn 0';
        }

        if (sale !== '' && sale < 0) {
            return 'Giá khuyến mãi không được nhỏ hơn 0';
        }

        if (price !== '' && sale !== '' && sale > price) {
            return 'Giá khuyến mãi không được lớn hơn giá bán';
        }

        return true;
    }

    /* =====================================================
     * SAVE PRODUCT (AJAX)
     * ===================================================== */

    function qpeSaveRow(row, callback = null) {

        const validation = qpeValidatePrice(
            row.find('.qpe-price').val(),
            row.find('.qpe-sale').val()
        );

        // VALIDATE FAIL → BÁO FAIL RÕ RÀNG
        if (validation !== true) {
            alert(validation);
            row.addClass('qpe-error');

            if (typeof callback === 'function') {
                callback({
                    success: false,
                    type: 'validate',
                    message: validation
                });
            }

            return;
        }

        const data = {
            action: 'qpe_save_product',
            nonce: QPE.nonce,
            id: row.data('id'),
            title: row.find('.qpe-title').val() || '',
            price: row.find('.qpe-price').val() || '',
            sale: row.find('.qpe-sale').val() || '',
            excerpt: row.find('.qpe-excerpt').val() || '',
            external_url: row.find('.qpe-external-url').val() || '',
            button_text: row.find('.qpe-external-btn').val() || '',
            grouped_desc: row.find('.qpe-grouped-desc').val() || '',
            description: row.hasClass('qpe-variation')
                ? row.find('.qpe-variation-desc').val() || ''
                : '',
        };

        $.post(QPE.ajax_url, data, function (res) {

            if (!res.success) {
                row.addClass('qpe-error');
            } else {
                row.removeClass('qpe-error').addClass('qpe-saved');
            }

            if (typeof callback === 'function') {
                callback(res);
            }
        });
    }

    function showSavedIcon(row) {
        row.find('.qpe-ok').remove();

        const ok = $('<span class="qpe-ok">✔</span>');
        row.find('td:last').append(ok);

        setTimeout(() => {
            ok.fadeOut(300, () => ok.remove());
        }, 800);
    }



    $(document).on('click', '.qpe-save', function () {

        const btn = $(this);
        const parentRow = btn.closest('tr');
        const parentId = parentRow.data('id');

        // CHỐNG DOUBLE CLICK
        if (btn.prop('disabled')) return;

        btn.prop('disabled', true).text(QPE.i18n?.saving || 'Đang lưu...');

        // LƯU PARENT
        qpeSaveRow(parentRow, function (res) {

            // PARENT FAIL → DỪNG TOÀN BỘ
            if (!res || res.success === false) {
                btn.prop('disabled', false).text('Lưu');
                return;
            }

            // TÌM VARIATIONS
            const variations = $('.qpe-variation[data-parent="' + parentId + '"]');

            // KHÔNG CÓ VARIATION → XONG
            if (!variations.length) {
                btn.prop('disabled', false).text('Lưu');
                showSavedIcon(parentRow);
                return;
            }

            let saved = 0;
            let hasError = false;

            // LƯU VARIATIONS
            variations.each(function () {

                const row = $(this);

                qpeSaveRow(row, function (res) {

                    // CÓ 1 THẰNG FAIL → DỪNG
                    if (!res || res.success === false) {
                        hasError = true;
                        btn.prop('disabled', false).text('Lưu');
                        return;
                    }

                    saved++;

                    // LƯU XONG HẾT
                    if (saved === variations.length && !hasError) {
                        btn.prop('disabled', false).text('Lưu');
                        showSavedIcon(parentRow);
                    }
                });
            });
        });
    });


    /* =====================================================
     * PAGINATION (PARENT + CHILD)
     * ===================================================== */
    let currentPage = 1;
    let totalPages = 1;
    const perPage = 5;

    function renderPagination() {
        const $pages = $('.qpe-pages');
        $pages.empty();

        for (let i = 1; i <= totalPages; i++) {
            const btn = $('<button/>', {
                class: 'button qpe-page' + (i === currentPage ? ' button-primary' : ''),
                text: i,
                'data-page': i
            });
            $pages.append(btn);
        }
    }

    function showTableLoading() {

        let rows = '';

        for (let i = 0; i < 8; i++) {
            rows += `
            <tr class="qpe-loading-row">
                <td><div class="qpe-skel skel-title"></div></td>
                <td><div class="qpe-skel skel-price"></div></td>
                <td><div class="qpe-skel skel-price"></div></td>
                <td><div class="qpe-skel skel-desc"></div></td>
                <td>
                    <span class="spinner is-active"></span>
                </td>
            </tr>`;
        }

        $('.qpe-product-rows').html(rows);
    }

    function hideTableLoading(html) {
        $('.qpe-product-rows').html(html);
    }

    function loadProducts(page = 1) {

        showTableLoading();

        $.post(QPE.ajax_url, {
            action: 'qpe_load_products',
            nonce: QPE.nonce,
            page: page
        }, function (res) {

            if (!res.success) {
                alert('Lỗi load sản phẩm');
                return;
            }

            hideTableLoading(res.data.html);

            currentPage = page;
            totalPages = Math.ceil(res.data.total / perPage);

            renderPagination();
        });
    }

    // CLICK SỐ TRANG
    $(document).on('click', '.qpe-page', function () {
        loadProducts(parseInt($(this).data('page')));
    });

    // PREV
    $('.qpe-prev').on('click', function () {
        if (currentPage > 1) {
            loadProducts(currentPage - 1);
        }
    });

    // NEXT
    $('.qpe-next').on('click', function () {
        if (currentPage < totalPages) {
            loadProducts(currentPage + 1);
        }
    });

    // LOAD LẦN ĐẦU
    loadProducts(1);

});