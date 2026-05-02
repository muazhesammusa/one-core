jQuery(document).ready(function ($) {

    var OneCoreCustomizerduct_Gallery = function ($target, args) {
        var mobileModWidth = 568 ; //768;
        this.$target = $($target);

        args = $.extend({}, OneCoreCustomizer_JS.wc_product_gallery, args );
        var enableSlider = args.enable_slider;

        args.slider = $.extend({}, OneCoreCustomizer_JS.wc_product_gallery.slider, args.slider );
        args.thumbs = $.extend({}, OneCoreCustomizer_JS.wc_product_gallery.thumbs, args.thumbs);
        var largeSlider = $('.woocommerce-product-gallery__wrapper', this.$target);
        var gallery_item_selector = '.woocommerce-product-gallery__image';
        var gallerySlides = $( gallery_item_selector , largeSlider);
        if ( ! gallerySlides.length ) {
            gallery_item_selector = '.wc-gallery-item';
            gallerySlides = $( gallery_item_selector , largeSlider);
        }
        var navThumbs = largeSlider.clone();

        var show_thumbs = args.show_thumbs;
        if (gallerySlides.length <= 1) {
            show_thumbs = false;
        }

        if ( enableSlider) {
            var vertical_mod = args.vertical;
            if ( show_thumbs ) {
                navThumbs.removeClass('woocommerce-product-gallery__wrapper').addClass('wc-nav-thumbs');
                $('.woocommerce-product-gallery__image img', navThumbs).unwrap();
                navThumbs.insertAfter(largeSlider);
                if (vertical_mod) {
                    this.$target.addClass('wc-gallery-vertical');
                }
            }
            if ( ! vertical_mod) {
                this.$target.addClass('wc-gallery-horizontal');
            }
        }

        var initZoomForTarget = function (zoomTarget) {

            if (!args.enable_zoom) {
                return false;
            }

            var galleryWidth = largeSlider.width(),
                zoomEnabled = false;

            $(zoomTarget).each(function (index, target) {
                var image = $(target).find('img');
                if (image.data('large_image_width') > galleryWidth) {
                    zoomEnabled = true;
                    return false;
                }
            });

            // But only zoom if the img is larger than its container.
            if (zoomEnabled) {

                zoom_options = {
                    touch: false
                };

                if ('ontouchstart' in document.documentElement) {
                    zoom_options.on = 'click';
                }

                zoomTarget.trigger('zoom.destroy');
                zoomTarget.zoom(zoom_options);
            }
        };

        var getGalleryItems = function () {
            var $slides = gallerySlides,
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

            var pswpElement = $('.pswp')[0],
                items = getGalleryItems();

            if ( typeof index === "undefined") {
                index = largeSlider.slick('slickCurrentSlide');
            }

            var options = $.extend({
                index: index
            }, wc_single_product_params ? wc_single_product_params.photoswipe_options : {} );

            // Initializes and opens PhotoSwipe.
            var photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            photoswipe.init();

        };

        /**
         * Init PhotoSwipe.
         */
        var initPhotoswipe = function () {
            if (!args.enable_lightbox) {
                return false;
            }
            if ( enableSlider ) {
                if ( gallerySlides.length > 0) {
                    largeSlider.prepend('<a href="#" class="woocommerce-product-gallery__trigger"><i class="wcicon-expand"></i></a>');
                    largeSlider.on('click', '.woocommerce-product-gallery__trigger', openPhotoswipe );
                    largeSlider.on('click', '.slick-slide', function (e) {
                        openPhotoswipe(e);
                    });
                } else {
                    largeSlider.on('click', '.woocommerce-product-gallery__image a', openPhotoswipe );
                }
            } else {
                largeSlider.on('click', gallery_item_selector, function (e) {
                    openPhotoswipe(e, $( this ).index());
                });
            }
        };

        try {
            if( largeSlider.length ) {
                largeSlider.slick('unslick');
            }

            if( navThumbs.length ) {
                navThumbs.slick('unslick');
            }
        } catch (e) {

        }

        var thumb_args = $.extend({
            asNavFor: largeSlider,
            vertical: false,
        }, args.thumbs);

        var largeSliderAutoSize = function( currentSlide ){
            return false;
            // Do something when slide change

        };

        if ( enableSlider ) {

            largeSlider.bind('afterChange init', function(event, slick, currentSlide, nextSlide){
                largeSliderAutoSize( currentSlide );
            });

            largeSlider.bind('init', function (event) {
                $( document.body ).trigger( 'wc_single_slider_init_done' );

                $('.slick-list .slick-slide', largeSlider).each(function () {
                    initZoomForTarget($(this).find('.woocommerce-product-gallery__image'));
                });
                initPhotoswipe();
            });

            function setThumbsSize( ver_mod  ){
                if ( ! args.auto_resize ) {
                    return ;
                }
                if ( navThumbs.length ) {
                    navThumbs.removeAttr('style');
                    var n =  thumb_args.slidesToShow > gallerySlides.length ?  gallerySlides.length : thumb_args.slidesToShow;
                    var size = 80 * thumb_args.slidesToShow;
                    if (ver_mod) {
                        if (size >= largeSlider.height() - 20) {
                            size = '';
                        }
                        navThumbs.css('min-height', size);
                    } else {
                        if (size >= $(window).width() - 20) {
                            size = '';
                        }
                        navThumbs.css('width', size);
                    }
                }
            }

            setThumbsSize( vertical_mod );

            navThumbs.bind('init reInit breakpoint afterChange', function (event) {});

            if ( gallerySlides.length ) {
                largeSlider.slick($.extend({
                    asNavFor: show_thumbs ? navThumbs : false,
                }, args.slider));
            }

            if (show_thumbs) {
                navThumbs.slick(thumb_args);
            }
            var that = this;

            if (show_thumbs && vertical_mod) {

                var switchThumbMod = function(){
                    navThumbs.css('width', '');
                    navThumbs.css('max-width', '');
                    var width = $(window).width();
                    if (width <= mobileModWidth) {
                        that.$target.removeClass('wc-gallery-vertical');
                        navThumbs.slick('unslick');
                        setThumbsSize( false );
                        navThumbs.slick($.extend(thumb_args, {
                            vertical: false,
                        }));
                    } else {
                        that.$target.addClass('wc-gallery-vertical');
                        navThumbs.slick('unslick');
                        setThumbsSize( vertical_mod );
                        navThumbs.slick($.extend(thumb_args, {
                            vertical: true,
                        }));
                    }
                };

                $(window).resize(function () {
                    switchThumbMod();
                });

                switchThumbMod();
            }
        } else {
            $( gallery_item_selector, largeSlider).each(function () {
                initZoomForTarget($(this));
            });
            initPhotoswipe();
        }

        // when customize css change
        $( document ) .on( 'after_auto_render_css', function( event, id, field_name ) {
            largeSlider.find( '.slick-list' ).height( 'auto' );

            if ( enableSlider ) {
                largeSliderAutoSize( );
                setTimeout( function () {
                    largeSlider.slick('resize');
                    if (show_thumbs) {
                        navThumbs.slick('resize');
                    }
                }, 250 );

            }
        });

        $( window ).resize( function(){
            if ( enableSlider ) {
                largeSliderAutoSize( );

                setTimeout( function () {
                    largeSlider.slick('resize');
                    if (show_thumbs) {
                        navThumbs.slick('resize');
                    }
                }, 250 );

            }
        } );

    };


    /**
     * Function to call wc_product_gallery on jquery selector.
     */
    $.fn.tophive_wc_product_gallery = function (args) {
        new OneCoreCustomizerduct_Gallery(this, args );
        return this;
    };

    if (typeof OneCoreCustomizer_JS.wc_product_gallery !== "undefined") {

        /*
         * Initialize all galleries on page.
         */
        $('.woocommerce-product-gallery').each(function () {
            $(this).tophive_wc_product_gallery();
        });

        $(document).on('tophive_quickview_product_init', function (e, $content) {

            setTimeout(function () {
                $('.woocommerce-product-gallery', $content).each(function () {
                    OneCoreCustomizer_JS.wc_product_gallery_quick_view.enable_slider = true;
                    $(this).tophive_wc_product_gallery(OneCoreCustomizer_JS.wc_product_gallery_quick_view );
                });
            }, 500);
        });

    }




});