/* global wp, jQuery */
/* exported PluginCustomizer */
var OneProLang = (function (api, $) {
    'use strict';

    var component = {
        data: {
            url: null,
            languages: null,
            current_language: null,
        }
    };

    /**
     * Initialize functionality.
     *
     * @param {object} args Args.
     * @param {string} args.url  Preview URL.
     * @returns {void}
     */
    component.init = function init(options) {

        _.extend(component.data, options);
        if (!options || !options.url || !options.languages || !options.current_language) {
            throw new Error('Missing args');
        }

        function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return uri + separator + key + "=" + value;
            }
        }

        api.bind('ready', function () {
            // pll.url = updateQueryStringParameter(window.location.href, 'lang', pll.current_language );
            // console.log( 'lang_options', options );
            //	api.previewer.previewUrl.set( pll.url );
            var languages = options.languages;
            var current_language = options.current_language;
            var current_language_name = '';

            var current_lang = '';

            var html = '';
            html += '<ul id="cp-language-select">';
            _.each(languages, function (language) {
                // var selected = (language.code === current_language) ? 'selected=""' : '';
                current_language_name = language.native_name;
                if (language.code === current_language) {
                    current_lang = '<span class="current-lang" data-code="' + language.code + '"><img src="' + language.country_flag_url + '" alt=""/> ' + current_language_name + '</span>';
                } else {
                    html += '<li data-code="' + language.code + '"><span><img src="' + language.country_flag_url + '" alt=""/> ' + current_language_name + '</span></li>';
                }
            });

            html += '</ul>';
            html = '<div id="cp-language-select-wrapper">' + current_lang + html + '</div>';

            $(html).prependTo('#customize-header-actions');
			
            $('body').on('click', '#cp-language-select li', function () {
                var language = $(this).attr('data-code') || '';
                var old_url = window.location.href;
                var preview_url = wp.customize.previewer.previewUrl.get();
				var url = updateQueryStringParameter(window.location.href, 'lang', language);
				if ( $('#customize-theme-controls #sub-accordion-section-multiple_headers').length > 0 && $('#customize-theme-controls #sub-accordion-section-multiple_headers').hasClass('open') ) {
					url = updateQueryStringParameter(url, 'autofocus[control]', 'multiple_headers');
					url = updateQueryStringParameter(url, 'msid', OneCoreCustomizer_Conditional.id);
				}
                //url = updateQueryStringParameter(url, 'url',  encodeURI( preview_url ) );
                window.location.href = url;
            });
        });

    };

    return component;
}(wp.customize, jQuery) );

OneProLang.init(Customiy_Pro_Languages);