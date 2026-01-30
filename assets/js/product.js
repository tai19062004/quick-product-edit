jQuery(function ($) {

    /* =====================================================
     * SAVE PRODUCT (AJAX)
     * ===================================================== */
    $(document).on('click', '.qpe-save', function () {

        const row = $(this).closest('tr');
        const btn = $(this);

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

        btn.prop('disabled', true).text(QPE.i18n.saving);

        $.post(QPE.ajax_url, data, function (res) {
            btn.prop('disabled', false).text('Lưu');

            if (!res.success) {
                alert(QPE.i18n.error);
                return;
            }

            btn.after('<span class="qpe-ok">✔</span>');
            setTimeout(() => {
                row.find('.qpe-ok').fadeOut(300, function () {
                    $(this).remove();
                });
            }, 800);
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