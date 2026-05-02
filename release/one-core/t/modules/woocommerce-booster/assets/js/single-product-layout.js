jQuery( document ).ready( function( $ ){

    $( '.wc-layout-columns' ).each( function( ){
        var box = $(".entry-summary-inner", $( this ));
        var bh = box.height();
        if ( bh <=  $( this ).innerHeight() - 100 ) {
            box.stick_in_parent({
                spacer: false
            });
        }
    } );

    $( document.body ).on( 'wc_toggle_done', function(){
        $(document.body).trigger("sticky_kit:recalc");
    } );


    var autoGallerySize = function(){
        /// auto hight for top gallery
        $( '.media-only.product .wc-product-top-media-inner' ).each( function(){
            var w = $( this );
            var maxH = w.css( 'height' );
            var g = $( '.woocommerce-product-gallery' );
            var gh = g.css( 'height' );
            var h = maxH > gh ? maxH : gh;

            w.css( 'max-height', h ).height( 'auto' );

        } );
    };


    $( window ).resize( function(){
        $(document.body).trigger("sticky_kit:recalc");
        setTimeout( function(){
            autoGallerySize();
        }, 200 );
    } );

    $( document ) .on( 'after_auto_render_css', function( event, id, field_name ) {
        $( window ).resize( );
    });

    $( window ).load( function(){
        autoGallerySize();
    } );

    /**
     * Make sure variations work with new slider
     */

    /**
     * Sets product images for the chosen variation
     */
    $.fn.tophive_wc_variations_image_update = function( variation ) {


        var $form             = this,
            product_id = $( 'input[name="product_id"]', $form ).val();
        var $product, hasSlick = false, $product_gallery, $gallery_nav, $gallery_img;

        if ( $( '#product-top-'+product_id ).length  ) {
            $product = $( '#product-top-'+product_id );
            $product_gallery  = $product.find( '.woocommerce-product-gallery__wrapper' );
            if ( $product_gallery.hasClass( 'slick-slider' ) ) {
                hasSlick = true;
                $gallery_nav      = $product.find( '.wc-nav-thumbs .slick-list' );
                $gallery_img      = $gallery_nav.find( '.slick-slide:eq(0) img' );
            } else {
                $product_gallery  = $product.find( '.images' );
                $gallery_nav      = $product.find( '.flex-control-nav' );
                $gallery_img      = $gallery_nav.find( 'li:eq(0) img' );
            }

        } else {
            $product =  $form.closest( '.product' );
            $product_gallery  = $product.find( '.images' );
            $gallery_nav      = $product.find( '.flex-control-nav' );
            $gallery_img      = $gallery_nav.find( 'li:eq(0) img' );
        }

        var
            $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
            $product_img      = $product_img_wrap.find( '.wp-post-image' ),
            $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

        if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
            // See if the gallery has an image with the same original src as the image we want to switch to.
            var galleryHasImage = $gallery_nav.find( 'li img[data-o_src="' + variation.image.gallery_thumbnail_src + '"]' ).length > 0;

            // If the gallery has the image, reset the images. We'll scroll to the correct one.
            if ( galleryHasImage ) {
                $form.tophive_wc_variations_image_reset();
            }

            // See if gallery has a matching image we can slide to.
            var slideToImage;
            if (  hasSlick ) {
                slideToImage = $gallery_nav.find( '.slick-slide div[data-thumb="' + variation.image.gallery_thumbnail_src + '"]' );
                if ( slideToImage.length > 0 ) {
                    var index = slideToImage.closest( '.slick-slide').attr( 'data-slick-index' ) || 0;
                    if ( $product.find( '.wc-nav-thumbs' ).length ) {
                        $product.find( '.wc-nav-thumbs' ).slick( 'slickGoTo', index );
                    } else {
                        $product_gallery.slick( 'slickGoTo', index );
                    }

                    $form.attr( 'current-image', variation.image_id );
                    window.setTimeout( function() {
                        $( window ).trigger( 'resize' );
                        $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
                    }, 20 );
                    return;
                }
            } else {
                slideToImage = $gallery_nav.find( 'li img[src="' + variation.image.gallery_thumbnail_src + '"]' );

                if ( slideToImage.length > 0 ) {
                    slideToImage.trigger( 'click' );
                    $form.attr( 'current-image', variation.image_id );
                    window.setTimeout( function() {
                        $( window ).trigger( 'resize' );
                        $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
                    }, 20 );
                    return;
                }
            }


            $product_img.wc_set_variation_attr( 'src', variation.image.src );
            $product_img.wc_set_variation_attr( 'height', variation.image.src_h );
            $product_img.wc_set_variation_attr( 'width', variation.image.src_w );
            $product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
            $product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
            $product_img.wc_set_variation_attr( 'title', variation.image.title );
            $product_img.wc_set_variation_attr( 'data-caption', variation.image.caption );
            $product_img.wc_set_variation_attr( 'alt', variation.image.alt );
            $product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
            $product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
            $product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
            $product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
            $product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
            $gallery_img.wc_set_variation_attr( 'src', variation.image.gallery_thumbnail_src );
            $product_link.wc_set_variation_attr( 'href', variation.image.full_src );
        } else {
            $form.tophive_wc_variations_image_reset();
        }

        window.setTimeout( function() {
            $( window ).trigger( 'resize' );
            $form.wc_maybe_trigger_slide_position_reset( variation );
            $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
        }, 20 );
    };

    /**
     * Reset main image to defaults.
     */
    $.fn.tophive_wc_variations_image_reset = function() {
        var $form             = this,
            product_id        = $( 'input[name="product_id"]', $form ).val(),
            $product          = $( '#product-top-'+product_id ).length ? $( '#product-top-'+product_id ) :  $form.closest( '.product' ),
            $product_gallery  = $product.find( '.images' ),
            $gallery_nav      = $product.find( '.flex-control-nav' ),
            $gallery_img      = $gallery_nav.find( 'li:eq(0) img' ),
            $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
            $product_img      = $product_img_wrap.find( '.wp-post-image' ),
            $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

        $product_img.wc_reset_variation_attr( 'src' );
        $product_img.wc_reset_variation_attr( 'width' );
        $product_img.wc_reset_variation_attr( 'height' );
        $product_img.wc_reset_variation_attr( 'srcset' );
        $product_img.wc_reset_variation_attr( 'sizes' );
        $product_img.wc_reset_variation_attr( 'title' );
        $product_img.wc_reset_variation_attr( 'data-caption' );
        $product_img.wc_reset_variation_attr( 'alt' );
        $product_img.wc_reset_variation_attr( 'data-src' );
        $product_img.wc_reset_variation_attr( 'data-large_image' );
        $product_img.wc_reset_variation_attr( 'data-large_image_width' );
        $product_img.wc_reset_variation_attr( 'data-large_image_height' );
        $product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
        $gallery_img.wc_reset_variation_attr( 'src' );
        $product_link.wc_reset_variation_attr( 'href' );
    };


    // Variables product
    $( 'form.variations_form' ).on( 'found_variation', function( e, variation ) {
        var form           = $( this );
        form.tophive_wc_variations_image_update( variation );
    });


    var getGalleryItems = function () {
        var $slides =  $('.woocommerce-product-gallery__wrapper .wc-gallery-item');
            items = [];

        if ($slides.length > 0) {
            $slides.each(function (i, el) {
                var img = $(el).find('img');
                if (img.length) {
                    var large_image_src = img.attr('data-large_image'),
                        large_image_w = img.attr('data-large_image_width'),
                        large_image_h = img.attr('data-large_image_height'),
                        item = {
                            src: large_image_src,
                            w: large_image_w,
                            h: large_image_h,
                            title: img.attr('data-caption') ? img.attr('data-caption') : img.attr('title')
                        };
                    items.push(item);
                }
            });
        }

        return items;
    };

    /**
     * Open photoswipe modal.
     */
    var openPhotoswipe = function (e, index ) {
        e.preventDefault();

        if ( typeof wc_single_product_params !== "undefined" ) {

            var pswpElement = $('.pswp')[0],
                items = getGalleryItems();

            if (typeof index === "undefined") {
                index = 0;
            }

            var options = $.extend({
                index: index
            }, wc_single_product_params.photoswipe_options );

            // Initializes and opens PhotoSwipe.
            var photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            photoswipe.init();
        }

    };

    /**
     * Init PhotoSwipe.
     */
    var initPhotoswipe = function () {
        // if ( typeof One_Pro_JS.wc_product_gallery !== "undefined" ) {
        //     return false;
        // }
        var photoswipe_enabled = typeof PhotoSwipe !== 'undefined';
        if ( ! photoswipe_enabled ) {
            return false;
        }

        $('.woocommerce-product-gallery__wrapper').on('click', '.wc-gallery-item', function (e) {
            openPhotoswipe(e, $( this ).index());
        });

    };

    initPhotoswipe();

} );