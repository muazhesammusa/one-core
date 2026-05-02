<?php
OneCoreCustomizer()->register_sub_module( 'OneCoreCustomizer_Module_WooCommerce_Booster', 'OneCoreCustomizer_Module_WC_Single_Product_Layout', array() );
class OneCoreCustomizer_Module_WC_Single_Product_Layout {

	private $configs = array();
	private static $_instance = null;

	/**
     * The instance method
     *
	 * @return OneCoreCustomizer_Module_WC_Single_Product_Layout
	 */
	static function get_instance(){
	    if ( is_null( self::$_instance ) ) {
		    self::$_instance = new self();
		    self::$_instance->init();
        }
        return self::$_instance;
    }

	/**
	 * Init
	 */
	public function init() {


		// Add customizer settings
		add_filter( 'tophive/customizer/config', array( $this, 'configs' ), 550 );

		if ( ! is_admin() ) {
			add_action( 'wp', array( $this, 'setup' ) );
			add_action( 'tophive-pro/scripts', array( $this, 'assets' ) );


			//Add new hook before main content
			add_action( 'tophive/before-site-content', array( $this, 'wc_before_main_layout' ) );

			// Add more classes to single product div
			add_filter( 'post_class', array( $this, 'wc_single_layout_classes' ) );

			// Add conditonal for gallery slider
			add_filter( 'wc_gallery_slider_required', array( $this, 'wc_gallery_slider_required' ) );

			/**
			 * Custom image size for product gallery
			 *
			 * @see woocommerce_gallery_image_size
			 */
			add_filter( 'woocommerce_gallery_image_size', array( $this, 'woocommerce_gallery_image_size' ), 999 );
			add_filter( 'woocommerce_get_availability', array($this, 'th_wc_custom_get_availability'), 1, 2);
			add_action( 'woocommerce_share', array($this, 'tophive_wc_social_sharing_buttons'), 1,1);
			add_filter( 'woocommerce_product_get_rating_html', array($this, 'th_wc_rating_single_page'), 10, 3 );
			add_filter( 'woocommerce_account_menu_items', array($this, 'th_wc_dashboard_custom_icons'), 99 ,1 );

		}
	}
	function th_wc_dashboard_custom_icons($items) {
	    $items['dashboard'] = esc_html__('Dashboard', 'tophive-pro');
	    $items['orders'] = esc_html__('Orders', 'tophive-pro');
	    return $items;
	}
	function th_wc_rating_single_page( $html, $rating, $count ) {
		global $product;
		if ( $html && is_singular( 'product' ) &&$product) {
			$html .= sprintf( '<span class="wc-single-page-rating-count">(%s reviews)</span>', $product->get_rating_count() );
		}
		return $html;
	}
	function tophive_wc_social_sharing_buttons($content) {
	    if(is_singular() || is_home()){
	    	global $product;
	        $thwcShareURL = get_permalink();

	        $thwcShareTitle = str_replace( ' ', '%20', get_the_title());

	        $productthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'full' );

	        $twitterURL = 'https://twitter.com/intent/tweet?text='.$thwcShareTitle.'&amp;url='.$thwcShareURL.'&amp;via=tophive';
	        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$thwcShareURL;
	        $googleURL = 'https://plus.google.com/share?url='.$thwcShareURL;
	        $bufferURL = 'https://bufferapp.com/add?url='.$thwcShareURL.'&amp;text='.$thwcShareTitle;
	        $linkedinURL = 'https://www.linkedin.com/shareArticle?mini=true&url='. $thwcShareURL .'&title=' . $thwcShareTitle;
	        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$thwcShareURL.'&amp;media='.$productthumb[0].'&amp;description='.$thwcShareTitle;

	        // Add sharing button at the end of page/page content
	        $content .= '<div class="tophive-wc-social">';
	        $content .= '<a class="tophive-wc-link small ec-mr-3 tophive-wc-facebook" href="'.$facebookURL.'" target="_blank"><i class="fa fa-facebook"></i></a>';
	        $content .= '<a class="tophive-wc-link small ec-mr-3 tophive-wc-googleplus" href="'.$twitterURL.'" target="_blank"><i class="fa fa-twitter"></i></a>';
	        $content .= '<a class="tophive-wc-link small ec-mr-3 tophive-wc-buffer" href="'.$linkedinURL.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
	        $content .= '<a class="tophive-wc-link small ec-mr-3 tophive-wc-pinterest" href="'.$pinterestURL.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
	        $content .= '</div>';

	        echo $content;
	    }
	}
	function th_wc_custom_get_availability( $availability, $_product ) {
	   	global $product;

	    if ( $_product->is_in_stock() ) {
	        $availability['availability'] = '<i class="eicon-check-circle-o available"></i> ' . esc_html__('Available in stock', 'tophive-pro');
	    }

	    if ( $_product->is_in_stock() && $product->get_stock_quantity() <= 2 ) {
	    	$availability['availability'] = '<i class="eicon-info-circle finishing"></i> ' . sprintf( esc_html__('Only %s left in store!', 'tophive-pro'), $product->get_stock_quantity());
		}

	    if ( ! $_product->is_in_stock() ) {
	    	$availability['availability'] = '<i class="eicon-minus-circle unavailable"></i> ' . esc_html__('Sorry, All sold out!', 'tophive-pro');
	    }

	    return $availability;
	}

	/**
	 * All product gallery image have same size
	 *
	 * @param $size
	 *
	 * @return string
	 */
	function woocommerce_gallery_image_size( $size ) {
	    if ( $this->configs['layout'] == 'top-full' ) {
		    $size = 'full';
        } elseif( $this->configs['layout'] == 'top-medium' ) {
		    $size = 'large';
        } else {
		    $size = 'woocommerce_single';
        }

		return $size;
	}

	/**
     * Conditonal to display gallery slider settings
     *
	 * @param $r
	 *
	 * @return array
	 */
	function wc_gallery_slider_required( $r ) {
		$r = array( 'wc_single_layout', '!=', 'left-grid' );
		return $r;
	}

	/**
	 * Setup
	 */
	function setup() {
		$this->configs = array(
			// top-medium || top-full || left
			'layout'            => tophive_one()->get_setting( 'wc_single_layout' ),
			// top-medium || top-full || left
			'slider_layout'     => tophive_one()->get_setting( 'wc_single_gallery_slider' ),

			//'thumbs_mod' => 'vertical', // horizontal || vertical
			// right or left or bottom | bottom for top full || top-medium and for horizontal only
			'thumbs_position'   => '',
			// 1 || 0 // apply for medium only
			'thumbs_in_gallery' => tophive_one()->get_setting( 'thumbs_in_gallery' ),
			// 1 || 0 // apply for medium only
			'thumbs_nav_number' => tophive_one()->get_setting( 'wc_thumbs_number' ),
			// 1 || 0 // apply for medium only
			'tab_position'      => tophive_one()->get_setting( 'wc_single_product_tab_position' ),

            // 1 || 0 // apply for medium only
			'grid_columns'      => tophive_one()->get_setting( 'wc_single_left_grid_columns', 'all' ),
			// 1 || 0 // apply for medium only
			'left_col_size'      => tophive_one()->get_setting( 'wc_single_layout_left_col_size' ),

			'breadcrumb'      => tophive_one()->get_setting( 'wc_single_layout_breadcrumb' ), // show breadcrumb  1||0
		);

		$slider_layout = tophive_one()->get_setting( 'wc_single_gallery_slider' );

		if ( $slider_layout == 'thumbnails_vertical' ) {
			$this->configs['thumbs_position'] = tophive_one()->get_setting( 'thumbs_pos_vertical' );
		} else {
			$this->configs['thumbs_position'] = tophive_one()->get_setting( 'thumbs_pos_horizontal' );
		}

		// Filter to control this options
		$this->configs = apply_filters( 'tophive-pro/single-product-layouts/args', $this->configs, $this );

		if ( $this->configs['layout'] == 'top-full' ) {
			$this->configs['thumbs_in_gallery'] = 1;
		}

		if ( $slider_layout == 'thumbnails_vertical' ) {
			if ( ! in_array( $this->configs['thumbs_position'], array( 'left', 'right' ) ) ) {
				$this->configs['thumbs_position'] = 'left';
			}
		} else {
			if ( ! in_array( $this->configs['thumbs_position'], array( 'bottom', 'bottom-left', 'bottom-right' ) ) ) {
				$this->configs['thumbs_position'] = 'bottom-right';
			}
		}

		//  Filter to allow 3rd party to modify settings
		add_filter( 'wc_single_gallery_thumbs_args', array( $this, 'wc_single_gallery_thumbs_args' ) );

		switch ( $this->configs['layout'] ) {
            case 'top-medium':
            case 'top-full':

                /**
                 * Remove product product image in woocommerce_before_single_product_summary
                 */
                remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
                remove_action( 'woocommerce_single_product_media', 'woocommerce_show_product_images', 20 );

                //And move gallery to the top of the page
                add_action( 'single_product_layout_top', 'woocommerce_show_product_images' );

                /**
                 * Move title desc to left column
                 */
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
                add_action( 'woocommerce_single_product_media', 'woocommerce_template_single_title', 5 );
                /**
                 * Move Short desc to left column
                 */
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
                add_action( 'woocommerce_single_product_media', 'woocommerce_template_single_excerpt', 20 );

                // Highlight summary box
                add_filter( 'woocommerce_single_product_summary_classes', array( $this, 'summary_box_classes' ) );
                // Auto resize nav slider
                add_filter( 'wc_single_gallery_slider_auto_resize_nav','__return_true' );

                if ( $this->configs['layout'] == 'top-medium' ) {
	                add_filter( 'wc_single_gallery_slider_auto_width','__return_true' );
                }

                break;
            case 'left-grid':

	            /**
	             * Disable all default single product gallery script
	             */
	            add_filter( 'woocommerce_single_product_photoswipe_enabled', '__return_false', 399 );
	            add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false', 399 );
	            add_filter( 'woocommerce_single_product_zoom_enabled', '__return_false', 399 );
	            add_filter( 'wc_single_gallery_enable_zoom', '__return_false', 399 );
	            add_filter( 'wc_single_gallery_enable_slider', '__return_false', 399 );

	            // Set Gallery columns
	            add_filter( 'woocommerce-product-gallery-classes', array( $this, 'grid_columns_classes' ) );
	            // Add column `tophive-col` to gallery item
	            add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'wc_thumbnail_class' ) );

	            // Add product summary classes
	            add_filter( 'woocommerce_single_product_summary_classes', array( $this, 'summary_box_classes' ) );

                break;

            default:
                // Default layout can resizeable
	            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	            add_action( 'woocommerce_single_product_media', 'woocommerce_show_product_images', 20 );

        }


		add_filter( 'tophive/wc_single_layout_size', array( $this, 'wc_single_layout_size' ) );

		// Set tab position
		$this->set_tab_position();
		// Set breadcrumb position
		$this->woocommerce_breadcrumb_position();

	}


	function wc_single_layout_size( $size  ){
	    $col = absint( $this->configs['left_col_size'] );
	    if ( $col > 12 || $col < 1 ) {
	        $col = 6;
        }

        $r_col = 12 - $col;
	    if ( $r_col == 0 ) {
		    $r_col = 12;
        }

		$size['left'] = "tophive-col-{$col}_md-{$col}_sm-12_xs-12";
		$size['right'] = "tophive-col-{$r_col}_md-{$r_col}_sm-12_xs-12";
	    return $size;
    }


	/**
	 * Display breadcrumb depended on single product layout
     * @see woocommerce_breadcrumb
	 */
	function woocommerce_breadcrumb_position(){
	    if ( $this->configs['breadcrumb'] ) {

		    switch ( $this->configs['layout'] ) {
			    case  'top-full':
			    case  'top-medium':
			        remove_action( 'woocommerce_single_product_summary_before', 'woocommerce_breadcrumb', 5 );
				    add_action( 'woocommerce_single_product_media', 'woocommerce_breadcrumb', 2 );
				    break;
			    case 'left-grid':
			    case 'default':
			        remove_action( 'woocommerce_single_product_media', 'woocommerce_breadcrumb', 5 );
				    add_action( 'woocommerce_single_product_summary_before', 'woocommerce_breadcrumb', 5 );
				    break;
		    }
        }

    }

	/**
     * Add summary classes to make it highlight
     *
	 * @return string
	 */
	function summary_box_classes() {
		return 'group-highlight-box';
	}

	/**
     * Filter to add more classes to wc thumbnail item
     *
	 * @param $html
	 *
	 * @return string
	 */
	function wc_thumbnail_class( $html ) {
		$html = str_replace( 'woocommerce-product-gallery__image', 'tophive-col wc-gallery-item', $html );
		return $html;
	}

	/**
     * Setup grid gallery layout
     *
	 * @return string
	 */
	function grid_columns_classes() {

		if ( ! is_array( $this->configs['grid_columns'] ) ) {
			$this->configs['grid_columns'] = absint( $this->configs['grid_columns'] );
			if ( $this->configs['grid_columns'] > 12 || $this->configs['grid_columns'] <= 0 ) {
				$this->configs['grid_columns'] = 1;
			}

			return sprintf( ' tophive-grid-%d_md-%d_sm-%d_xs-1', $this->configs['grid_columns'], $this->configs['grid_columns'], $this->configs['grid_columns'] );
		} else {
			$this->configs['grid_columns'] = array_map( 'absint', $this->configs['grid_columns'] );

			$c = wp_parse_args( $this->configs['grid_columns'], array(
				'desktop' => '',
				'tablet'  => '',
				'mobile'  => '',
			) );

			if ( ! $c['desktop'] ) {
				$c['desktop'] = 1;
			}
			if ( ! $c['tablet'] ) {
				$c['tablet'] = 1;
			}

			if ( ! $c['mobile'] ) {
				$c['mobile'] = 1;
			}

			return " tophive-grid-{$c['desktop']}_md-{$c['desktop']}_sm-{$c['tablet']}_xs-{$c['mobile']}";

		}
	}

	/**
	 * Set tab position
	 */
	function set_tab_position() {
		switch ( $this->configs['tab_position'] ) {
			case 'left':
				add_action( 'woocommerce_single_product_media', 'woocommerce_output_product_data_tabs', 50 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
				break;
			case 'right':
				add_action( 'woocommerce_single_product_summary_after', 'woocommerce_output_product_data_tabs', 50 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
				break;
			default:
				if ( $this->configs['tab_position'] == 'default' ) {

					if ( $this->configs['layout'] == 'top-medium' || $this->configs['layout'] == 'top-full' ) {
						// Move to left
						add_action( 'woocommerce_single_product_media', 'woocommerce_output_product_data_tabs', 50 );
						remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
					} elseif ( $this->configs['layout'] == 'left-grid' ) {
						// Move tabs to right
						add_action( 'woocommerce_single_product_summary_after', 'woocommerce_output_product_data_tabs', 50 );
						remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
					}

				}
		}
	}

	/**
     * Filter to show custom number style.
     *
	 * @param $args
	 *
	 * @return mixed
	 */
	function wc_single_gallery_thumbs_args( $args ) {
		if ( in_array( $this->configs['layout'], array( 'top-medium', 'top-full' ) ) ) {
			if ( $this->configs['thumbs_nav_number'] ) {
				if ( $this->configs['layout'] != 'top-medium' && $this->configs['thumbs_in_gallery'] ) {
					$args['slidesToShow'] = $this->configs['thumbs_nav_number'];
				}

				if ( $this->configs['slider_layout'] != 'thumbnails_vertical' ) {
					$args['variableWidth'] = false;
				}
			}
		}

		return $args;
	}

	/**
     * Customize configs
     *
	 * @param $configs
	 *
	 * @return array
	 */
	function configs( $configs ) {
		$section = 'wc_single_product';

		$configs[] = array(
			'name'            => 'wc_single_layout',
			'type'            => 'image_select',
			'section'         => $section,
			'title'           => esc_html__('Layout', 'tophive-pro'),
			'default'         => 'default',
			'choices'         => array(
				'default'         => array(
					'img' => esc_url(get_template_directory_uri()) . '/assets/images/customizer/wc-layout-default.svg',
					'label' => __( 'Default', 'tophive-pro' ),
				),
				'top-medium'   => array(
					'img' => esc_url(get_template_directory_uri()) . '/assets/images/customizer/wc-layout-top-medium.svg',
					'label' =>__( 'Top Gallery Boxed', 'tophive-pro' ),
				),
				'top-full' => array(
					'img' => esc_url(get_template_directory_uri()) . '/assets/images/customizer/wc-layout-top-full.svg',
					'label' => __( 'Top Gallery Full Width', 'tophive-pro' ),
				),
				'left-grid'    => array(
					'img' => esc_url(get_template_directory_uri()) . '/assets/images/customizer/wc-layout-left-grid.svg',
					'label' => __( 'Left Gallery Grid', 'tophive-pro' ),
				),
			)
		);


		$col_sizes = array();

		for ( $i= 1; $i <=12; $i++ ) {
		    $string = '';
		    if ( $i == 1 ) {
			    $string = __( '1 Column', 'tophive-pro' );
            } else {
			    $string = sprintf( __( '%s Columns', 'tophive-pro' ), $i );
            }
			$col_sizes[ $i ] = sprintf( '%1$s - %2$s', round( ( $i/12) * 100, 2 ).'%', $string );
        }

		$configs[] = array(
			'name'    => 'wc_single_layout_left_col_size',
			'type'    => 'select',
			'section' => $section,
			'default' => 6,
			'label'   => __( 'Left Column Size', 'tophive-pro' ),
			'description'   => __( 'The right column will resize automatically to fit the layout.', 'tophive-pro' ),
			'choices' => $col_sizes
		);

		$configs[] = array(
			'name'    => 'wc_single_top_box_bg',
			'type'    => 'color',
			'section' => $section,
			'default' => '',
			'label'   => __( 'Background', 'tophive-pro' ),
			'selector'        => '.product.gallery-top-medium',
			'device_settings' => true,
			'css_format'      => 'background-color: {{value}};',
			'required'        => array( 'wc_single_layout', 'in', array( 'top-medium' ) )
		);

		$configs[] = array(
			'name'    => 'wc_single_top_image_max_height',
			'type'    => 'slider',
			'section' => $section,
			'default' => array(
                'desktop' => array(
                    'unit' => 'px',
                    'value' => 550
                ),
            ),
			'label'   => __( 'Gallery Height', 'tophive-pro' ),
			'max' => 1000,
			'step' => 20,
			'selector'        => 'format',
			'device_settings' => true,
			'css_format'      => 'div.product.wc-product-top-media .wc-product-top-media-inner { height: {{value}};  } div.product.wc-product-top-media .woocommerce-product-gallery__image img {  max-height: {{value}};  }',
			'required'        => array( 'wc_single_layout', '=', array( 'top-full', 'top-medium' ) )
		);

		$configs[] = array(
			'name'    => 'wc_single_top_image_max_width',
			'type'    => 'slider',
			'section' => $section,
			'default' => array(
				'desktop' => array(
					'unit' => 'px',
					'value' => 500
				),
			),
			'label'   => __( 'Gallery Width', 'tophive-pro' ),
			'max' => 1000,
			'step' => 20,
			'selector'        => 'format',
			'device_settings' => true,
			'css_format'      => '.media-only.gallery-top-medium .wc-product-top-media-inner { width: {{value}}; }',
			'required'        => array( 'wc_single_layout', '=', 'top-medium' )
		);

		$configs[] = array(
			'name'            => 'wc_single_left_grid_columns',
			'type'            => 'text',
			'section'         => $section,
			'label'           => __( 'Gallery Columns', 'tophive-pro' ),
			'device_settings' => true,
			'default'         => '',
			'required'        => array( 'wc_single_layout', '=', 'left-grid' )
		);

		$configs[] = array(
			'name'            => 'wc_single_layout_boxed_padding',
			'type'            => 'css_ruler',
			'section'         => $section,
			'default'         => '',
			'label'           => __( 'Gallery Padding', 'tophive-pro' ),
			'selector'        => 'div.product.wc-product-top-media.gallery-top-medium',
			'device_settings' => true,
			'css_format'      => array(
				'top'    => 'padding-top: {{value}};',
				'right'  => 'padding-right: {{value}};',
				'bottom' => 'padding-bottom: {{value}};',
				'left'   => 'padding-left: {{value}};',
			),
			'required'        => array( 'wc_single_layout', '=', 'top-medium' )
		);

		// tab settings
		$configs[] = array(
			'name'     => "{$section}_tab_position",
			'type'     => 'select',
			'default'  => 'default',
			'section'  => $section,
			'label'    => __( 'Tab Position', 'tophive-pro' ),
			'choices'  => array(
				'default' => __( 'Default', 'tophive-pro' ),
				'right'   => __( 'Right Column', 'tophive-pro' ),
				'left'    => __( 'Left Column', 'tophive-pro' ),
				'bottom'  => __( 'Bottom', 'tophive-pro' ),
			),
			'priority' => 43,
		);

		$configs[] = array(
			'name'     => 'wc_thumbs_number',
			'type'     => 'text',
			'section'  => $section,
			'label'    => __( 'Number product thumbnails to show', 'tophive-pro' ),
			'priority' => 261,
			'required' => array( 'wc_single_layout', 'in', array( 'top-medium', 'top-full' ) )
		);

		$configs[] = array(
			'name'           => 'thumbs_in_gallery',
			'type'           => 'checkbox',
			'section'        => $section,
			'default'        => 1,
			'checkbox_label' => __( 'Thumbnails navigation in gallery', 'tophive-pro' ),
			'priority'       => 31,
			'required'       => array( 'wc_single_layout', '=', 'top-medium' )
		);

		$configs[] = array(
			'name'     => 'thumbs_pos_vertical',
			'type'     => 'select',
			'section'  => $section,
			'default'  => 'left',
			'label'    => __( 'Thumbnail position', 'tophive-pro' ),
			'choices'  => array(
				'left'  => __( 'Left', 'tophive-pro' ),
				'right' => __( 'Right', 'tophive-pro' ),
			),
			'priority' => 31,
			'required' => array(
				array( 'wc_single_layout', '!=', 'default' ),
                array('wc_single_gallery_slider', '=', 'thumbnails_vertical'),
				array('wc_single_layout', '!=', 'left-grid')
            )
		);

		$configs[] = array(
			'name'     => 'thumbs_pos_horizontal',
			'type'     => 'select',
			'section'  => $section,
			'default'  => 'bottom',
			'label'    => __( 'Thumbnail position', 'tophive-pro' ),
			'choices'  => array(
				'bottom'       => __( 'Bottom center', 'tophive-pro' ),
				'bottom-left'  => __( 'Bottom left', 'tophive-pro' ),
				'bottom-right' => __( 'Bottom right', 'tophive-pro' ),
			),
			'priority' => 31,
			'required' => array(
				array( 'wc_single_layout', '!=', 'default' ),
				array( 'wc_single_gallery_slider', '=', 'thumbnails_horizontal' ),
				array('wc_single_layout', '!=', 'left-grid')
			),

		);

		return $configs;
	}

	/**
     * Add single product classes depended on layout
     *
	 * @param $classes
	 *
	 * @return array
	 */
	function wc_single_layout_classes( $classes ) {

		if ( ! $this->configs['layout'] || $this->configs['layout'] == 'default' ) {
			return $classes;
		}

		if ( get_post_type() == 'product' ) {

			if ( $this->configs['layout'] == 'left-grid' ) {
				$classes[] = 'product-grid-media';
				return $classes;
			}
			$classes['wc-product-top-media'] = 'wc-product-top-media';
		}

		return $classes;
	}


	/**
	 * Add assets to front end
	 */
	function assets() {

		$suffix = tophive_one()->get_asset_suffix();
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_css( 'single-product-layouts' . $suffix . '.css' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( 'sticky-kit' . $suffix . '.js' );
		OneCoreCustomizer_Module_WooCommerce_Booster::get_instance()->add_js( 'single-product-layout' . $suffix . '.js' );

	}

	/**
	 * Add more hook before main layout
     * @todo display gallery on the top product page
	 */
	function wc_before_main_layout() {

		if( !class_exists('woocommerce') ){
			return;
		}

		if ( is_product() ) {

		    $_loop = isset( $GLOBALS['woocommerce_loop'] )  ? $GLOBALS['woocommerce_loop'] : null;

			$GLOBALS['woocommerce_loop'] = array();

		    the_post();

            if ( has_action( 'single_product_layout_top' ) ) {
                $class = 'media-only';
                if ( ! OneCoreCustomizer()->is_enabled_module( 'OneCoreCustomizer_Module_WC_Gallery_Slider' ) ) {
                    $class .= ' default-gallery';
                }
                if ( $this->configs['thumbs_in_gallery'] ) {
                    $class .= ' thumbs_in_gallery';
                } else {
                    $class .= ' thumbs_out_gallery';
                }
                if ( $this->configs['layout'] !== 'left' ) {
                    $class .= ' gallery-' . $this->configs['layout'];
                }
                if ( $this->configs['thumbs_position'] ) {
                    $class .= ' gallery-tp-' . $this->configs['thumbs_position'];
                }
                $classes['wc-product-top-media'] = 'wc-product-top-media';
                ?>
                <div id="product-top-<?php the_ID(); ?>" <?php wc_product_class( $class ); ?>>
                    <div class="wc-product-top-media-inner">
	                    <?php do_action( 'single_product_layout_top', $this ); ?>
                    </div>
                </div>
                <?php
            }

			rewind_posts();
			$GLOBALS['woocommerce_loop'] = $_loop;
		}
	}

}
