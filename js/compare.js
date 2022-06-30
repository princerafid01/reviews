$(document).ready(function () {
    // Initial setup
    let product_main = [];
    const single_product_placeholder = `
    <div class="single-product-placholder d-inline-block">
        <svg class="bd-placeholder-img card-img-top mt-3" width="100%" height="180"
        xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
        preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="80px" height="100px" fill="#868e96"></rect>
        </svg>
    </div>
    `;
    for (let i = 1; i <= 3; i++) {
        $('.product-placeholder').append(single_product_placeholder);
    }
    arrowDown();

    function arrowDown(params) {
        $(".fa.fa-arrow-down").click(function () {
            $('.site-comparer').stop().animate({
                'bottom': '-122px'
            }, 500);
            $(this).removeClass('fa-arrow-down');
            $(this).addClass('fa-arrow-up');
            arrowUp();
        });
    }


    function arrowUp() {
        $(".fa.fa-arrow-up").click(function () {
            $('.site-comparer').stop().animate({
                'bottom': '0px'
            }, 500);
            $(this).removeClass('fa-arrow-up');
            $(this).addClass('fa-arrow-down');
            arrowDown();
        });
    }



    // Handle Checkbox
    $(".compare_checkbox").change(function () {
        const site_url = $(this).data('url');
        const site_name = $(this).data('name');

        if ($(this).is(':checked')) {
            generateMainProductComparer(site_url, site_name)
        } else {
            removeMainProductComparer(site_url);
        }
    });


    // While adding product to the comparer
    function generateMainProductComparer(site_url, site_name) {
        if (product_main.length >= 4) {
            alert('Only Three Product can be compared')
        } else {
            const html = `<div class="single-product-main d-inline-block bg-white" data-url="${site_url}">
                <i class="fa fa-times mt-1"></i>
                ${site_name}
            </div>`;
            product_main.push({
                site_url,
                site_name
            });
            $('.site-comparer .product-main').append(html);
            generateFunctionForCompareProductClosing();
            handleDisablility();
            placeholderHandler();
            removeAllProduct();
        }
    }

    // While removing product to the comparer 
    function removeMainProductComparer(site_url) {
        product_main = product_main.filter(elem => elem.site_url !== site_url);
        $(`.single-product-main[data-url="${site_url}"]`).remove();
        $(`.compare_checkbox[data-url="${site_url}"]`).prop("checked", false);
        handleDisablility();
        placeholderHandler();
    }

    function generateFunctionForCompareProductClosing() {
        $('.single-product-main i').click(function () {
            const site_url = $(this).parent().data('url');
            removeMainProductComparer(site_url);
        });
    }

    function handleDisablility() {
        if (product_main.length >= 3) {
            $.each($('input:checkbox'), function (index, element) {
                $(element).prop('disabled', true);
            });
        } else {
            $.each($('input:checkbox'), function (index, element) {
                $(element).prop('disabled', false);
            });
        }
    }

    function placeholderHandler() {
        // const element = $('.product-placeholder .single-product-placholder').html();
        $.each($('.product-placeholder .single-product-placholder'), function (index, element) {
            $(element).remove();
        });
        console.log(product_main.length)
        $('.product-placeholder .single-product-placholder').remove();
        for (let i = 0; i < (3 - product_main.length); i++) {
            $('.product-placeholder').append(single_product_placeholder);
        }
    }

    function removeAllProduct() {
        $('#removeAllProduct').click(function () {
            product_main = [];
            $.each($('.product-main  .single-product-main'), function (index, element) {
                $(element).remove();
            });

            $.each($('.compare_checkbox'), function (index, element) {
                $(element).prop('checked', false);
            });

            handleDisablility();
            placeholderHandler();
        });
    }

});