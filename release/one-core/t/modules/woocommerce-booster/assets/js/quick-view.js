jQuery(document).ready(function ($) {

    // Quick view
    // Close quick view
    $(document.body).on('click', '.tophive-wc-modal-close, .tophive-wc-modal-overlay', function (e) {
        e.preventDefault();
        $(this).closest('.tophive-wc-modal').removeClass('show').addClass('hide');
        $(document).trigger('tophive_quickview_closed');
    });

    $(window).on('keyup', function (e) {
        if (e.which === 27) { // esc button
            $('.tophive-wc-modal').removeClass('show').addClass('hide');
            $(document).trigger('tophive_quickview_closed');
        }
    });

    // Open quick view
    $(document.body).on('click', '.tophive-wc-quick-view, .quick-view-btn', function (e) {
        e.preventDefault();
        var button = $(this);
        var id = button.attr('data-id') || '';
        //button.data('default_text', button.html());

        if (id && !button.hasClass('loading')) {

            if ($('#tophive-wc-modal-product-' + id).length) {
                $('#tophive-wc-modal-product-' + id).removeClass('hide').addClass('show');
                $(window).resize();
                $( '.woocommerce-product-gallery__wrapper' ).css( 'opacity', 1 );
                $(document).trigger('tophive_quickview_product_reopen');
                setTimeout(function () {
                    $(window).resize();
                }, 200 );
            } else {
                //button.addClass('loading').html(OneCoreCustomizer_JS.quick_view.loading_text);
                button.addClass('loading');
                $.ajax({
                    url: woocommerce_params.ajax_url,
                    type: 'get',
                    data: {
                        action: 'tophive/wc/quick-view',
                        product_id: id,
                    },
                    success: function (res) {
                        //button.removeClass('loading').html(button.data('default_text'));
                        button.removeClass('loading');
                        //Set WC single product params
                        wc_single_product_params = res.params;

                        var content = $(
                            '<div id="tophive-wc-modal-product-' + id + '" class="tophive-wc-modal hide">' +
                                '<div class="tophive-wc-modal-overlay"></div>' +
                                '<div class="tophive-wc-modal-cont  woocommerce woocommerce-page single single-product">' +
                                    '<div class="tophive-wc-modal-inner">' +
                                        '<a href="#" class="remove2x tophive-wc-modal-close">×</a> ' +
                                        '<div class="tophive-container">' +
                                            '<div class="tophive-grid"><div class="tophive-wc-modal-col tophive-col-12">' + res.content + '</div></div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>');

                       // var content = $( res.content );
                        $('body').append(content);

                        /*
                        * Initialize all galleries on page.
                        */
                        if ($.fn.wc_product_gallery) {
                            $('.woocommerce-product-gallery', content ).each(function () {
                                $(this).wc_product_gallery();
                                $( '.woocommerce-product-gallery__wrapper' ).css( 'opacity', 1 );
                            });
                        }

                        if (res.type === 'variable') {
                            wc_add_to_cart_variation_params = res.variation_params;
                            if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                                $('.variations_form', content).each(function () {
                                    $(this).wc_variation_form();
                                });
                            }
                        }

                        // Add + - button
                        $(document.body).trigger('updated_wc_div');
                        $(document).trigger('tophive_quickview_product_init', [content]);

                        setTimeout(function () {
                            content.removeClass('hide').addClass('show');

                            $(window).resize();
                            setTimeout(function () {
                                $(window).resize();
                            }, 200);
                        }, 100)

                    }
                });
            }
        } // end if id

    });

    $.fn._add_cart_serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };


    // Quick view add to cart
    $(document.body).on('click', '.tophive-wc-modal .single_add_to_cart_button', function (e) {
        e.preventDefault();

        var $thisbutton = $(this);

        if ($thisbutton.hasClass('disabled') || $thisbutton.is(':disabled')) {
            return;
        }

        var form = $thisbutton.closest('form');
        var data = form._add_cart_serializeObject();

        $thisbutton.removeClass('added');
        $thisbutton.addClass('loading');

        if (typeof data.product_id === "undefined" && typeof data['add-to-cart'] !== "undefined") {
            data.product_id = data['add-to-cart'];
        } else if (typeof data['add-to-cart'] === "undefined") {
            data.product_id = $thisbutton.val();
        }

        // Trigger event.
        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

        // Ajax action.
        $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'), data, function (response) {
            console.log(response);
            if (!response) {
                return;
            }

            if (response.error && response.product_url) {
                window.location = response.product_url;
                return;
            }

            // Redirect to cart option
            if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                window.location = wc_add_to_cart_params.cart_url;
                return;
            }

            // Trigger event so themes can refresh other areas.
            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
        });

    });

    //---------------------------------------------------------------------

});