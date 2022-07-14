$(document).ready(function () {
    // Initial setup
    let product_main = getProductInLocalstorage('product_main') || [];
    if(product_main.length === 0){
        $('.site-comparer').hide();
    }
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
    generateProductFromLocalStorage(product_main);
    arrowDown();

    // make Down the comparer Div
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

    // make Up the comparer Div
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
        $('.site-comparer').show();

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
            setProductInLocalstorage('product_main', product_main);
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
        setProductInLocalstorage('product_main', product_main);
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
        $('.product-placeholder .single-product-placholder').remove();
        for (let i = 0; i < (3 - product_main.length); i++) {
            $('.product-placeholder').append(single_product_placeholder);
        }
    }

    function removeAllProduct() {
        $('#removeAllProduct').click(function () {
            product_main = [];
            setProductInLocalstorage('product_main', product_main);
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

    function setProductInLocalstorage(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    function getProductInLocalstorage(key, value) {
        return JSON.parse(localStorage.getItem(key));
    }

    function generateProductFromLocalStorage(products) {
        if (products.length > 0) {
            let htmlProducts = '';
            products.map(function (product) {
                $(`.compare_checkbox[data-url="${product.site_url}"]`).prop("checked", true);

                htmlProducts += `<div class="single-product-main d-inline-block bg-white" data-url="${product.site_url}">
                <i class="fa fa-times mt-2"></i>
                ${product.site_name}
            </div>`;
            });
            $('.site-comparer .product-main').append(htmlProducts);
            generateFunctionForCompareProductClosing();
            handleDisablility();
            placeholderHandler();


        }

    }

});