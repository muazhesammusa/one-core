(function ($, window, document) {
    "use strict";

    var tophiveWCFiterXHR = false;

    $.fn.tophiveOffCanvas = function ( options ) {
        var opts = $.extend({
            selector   : '.woocommerce-listing',
        }, options );

        var updateURL = function( url ) {
            // IE only supports pushState() in v10 and above, so don't bother if those conditions aren't met.
            if ( ! window.history.pushState ) {
                return;
            }
            history.pushState( null, null, url );
        };

        var offCanvasFilter = function( options, $el ){
            /*
            $el.on( 'click', '.woocommerce-widget-layered-nav-list li a', function(e){
                e.preventDefault();
                var url = $( this ).attr( 'href' ) || false;
                if ( url ) {
                    ajax_request( url );
                }
            } );
            */

            $( '.tophive-wc-filter-form input', $el ).on( 'change', function(e){
                var data = {};
                var form = $( '.tophive-wc-filter-form' );
                $( 'input', form ).each( function(){
                    var input = $( this );
                    var input_type = input.attr( 'type' ) || 'text';
                    var name = false;
                    switch ( input_type ) {
                        case 'checkbox':
                            if ( input.is(':checked') ) {
                                name = $( this ).attr( 'data-name' ) || false;
                                if ( name ) {
                                    if ( typeof data[ name ] ===  "undefined" ) {
                                        data[ name ] = [];
                                    }
                                }
                                data[ name ].push( $( this ).val() );
                            }
                            break;
                        case 'hidden':
                        case 'text':
                            name = $( this ).attr( 'name' ) || false;
                            if ( name ) {
                                if ( typeof data[ name ] ===  "undefined" ) {
                                    data[ name ] = input.val();
                                }
                            }
                            break;
                    }

                } );

                var args = [];

                $.each( data, function( key, values ){
                    var string = '';
                    if ( typeof values === 'array'  || typeof values === 'object' ) {
                        string = values.join(',');
                    } else {
                        string = values;
                    }
                    args.push( key+'='+encodeURI( string ) );
                } );

                var sep = OneCoreCustomizer_JS.wc_filter.shop.indexOf('?') > -1 ? '&' : '?';
                var query_url = OneCoreCustomizer_JS.wc_filter.shop+sep+ args.join('&');
                ajax_request( query_url );


            } );

           function ajax_request( desturl ){
               console.log( 'Query URL', desturl );
               // decode url to prevent error
              // desturl = decodeURIComponent(desturl);
              // desturl = desturl.replace(/^(?:\/\/|[^\/]+)*\//, "/");

               if ( tophiveWCFiterXHR ) {
                   tophiveWCFiterXHR.abort();
                   tophiveWCFiterXHR = false;
               }
               updateURL( desturl );

               // ajax call
               tophiveWCFiterXHR = $.ajax({
                   // params
                   url         : desturl,
                   dataType    : 'html',
                   success     : function (data) {
                       var $data = $( data );
                       var obj;
                       if ( $( opts.selector, $data ).length ) {
                           $( opts.selector ).html( $( opts.selector, $data ) );
                       }
                   },
                   error: function (req) {

                   }
               });
           }

        };

        return this.each(function() {
            return new offCanvasFilter( options, $( this ) );
        });

    }

})( jQuery, window, document );


jQuery( document ).ready( function($){
    $( '.off-canvas-sidebar' ).tophiveOffCanvas();

    jQuery( document ).on ( 'click', '.tophive-filter-btn, .off-canvas-sidebar-overlay, .off-canvas-close', function( e ) {
        e.preventDefault();
        if ( $( '.off-canvas-sidebar' ).hasClass( 'active' ) ) {
            $( '.off-canvas-sidebar, .off-canvas-sidebar-overlay, .tophive-filter-btn' ).removeClass( 'active' );
        } else {
            $( '.off-canvas-sidebar, .off-canvas-sidebar-overlay, .tophive-filter-btn' ).addClass( 'active' );
        }

    } );
} );