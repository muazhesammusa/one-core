class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
				mainSwiper: '.tophive-main-swiper',
				swiperSlide: '.swiper-slide'
			},
			slidesPerView: {
				desktop: 3,
				tablet: 2,
				mobile: 1
			}
        };
    }

    getDefaultElements() {
		var selectors = this.getSettings('selectors');

		var elements = {
			$mainSwiper: this.$element.find(selectors.mainSwiper)
		};

		elements.$mainSwiperSlides = elements.$mainSwiper.find(selectors.swiperSlide);

		return elements;
    }
    getSlidesCount() {
    	return this.elements.$mainSwiperSlides.length;
    }

    bindEvents() {
        this.elements.$firstSelector.on( 'click', this.onFirstSelectorClick.bind( this ) );
    }

    getDeviceSlidesPerView(device) {
		var slidesPerViewKey = 'slides_per_view' + ('desktop' === device ? '' : '_' + device);

		return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesPerViewKey) || this.getSettings('slidesPerView')[device]);
	}
	getSlidesPerView(device) {
		if ('slide' === this.getEffect()) {
			return this.getDeviceSlidesPerView(device);
		}
		return 1;
	}

	getDesktopSlidesPerView() {
		return this.getSlidesPerView('desktop');
	}
	getTabletSlidesPerView() {
		return this.getSlidesPerView('tablet');
	}
	getMobileSlidesPerView() {
		return this.getSlidesPerView('mobile');
	}

	getDeviceSlidesToScroll(device) {
		var slidesToScrollKey = 'slides_to_scroll' + ('desktop' === device ? '' : '_' + device);

		return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesToScrollKey) || 1);
	}
	getSlidesToScroll(device) {
		if ('slide' === this.getEffect()) {
			return this.getDeviceSlidesToScroll(device);
		}

		return 1;
	}
	getDesktopSlidesToScroll() {
		return this.getSlidesToScroll('desktop');
	}
	getTabletSlidesToScroll() {
		return this.getSlidesToScroll('tablet');
	}
	getMobileSlidesToScroll() {
		return this.getSlidesToScroll('mobile');
	}
	getSpaceBetween(device) {
		var propertyName = 'space_between';

		if (device && 'desktop' !== device) {
			propertyName += '_' + device;
		}

		return this.getElementSettings(propertyName).size || 0;
	}

    onFirstSelectorClick( event ) {
        event.preventDefault();

        this.elements.$secondSelector.show();
   }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/your-widget-name.default', addHandler );
} );