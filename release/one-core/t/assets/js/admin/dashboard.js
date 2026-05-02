
jQuery( document ).ready( function($){

    var _timeout;
    var close_toast = function () {
        _timeout = setTimeout( function(){
            $( '#toast-container' ).hide();
        }, 1500 );
    };

    var toast = function( msg, type  ){
        if ( _.isUndefined( type ) ) {
            type = 'success';
        }
        if ( _timeout ) {
            clearTimeout( _timeout );
        }
        if ( $( '#toast-container' ).length <= 0 ) {
            $( 'body' ).append( '<div id="toast-container" class="toast-top-right"></div>' );
        }
        $( '#toast-container' ).html( '<div class="toast-message toast-'+type+'">'+msg+'<button type="button" class="toast-close-button" role="button">×</button></div>' );
        $( '#toast-container' ).show();
        close_toast();
    };

    $( document ).on( 'click', '#toast-container', function(e){
        $( '#toast-container' ).hide();
    });

    $( document ).on( 'change', '.cd-modules .cd-onoff-module', function(e){
        e.preventDefault();
        var input = $( this );
        if ( ! input.is( ':disabled' ) ) {
            var name = input.attr( 'name' );
            input.attr( 'disabled', 'disabled' );
            var check = input.is(':checked') ? 1 : 0;
            var reload = input.data( 'reload' ) || 0;
            var parent = input.data( 'parent' ) || false;
            var sub_modules = {};

            if ( ! parent ) {
                sub_modules[ name ] = check;
                // find all sub module for this parent
                $( 'input[data-parent="'+name+'"]' ).each( function(){
                    var sub_input = $( this );
                    var sub_name = sub_input.attr( 'name' );
                    var sub_check = sub_input.is(':checked') ? 1 : 0;
                    if ( ! check ) {
                        sub_input.attr( 'disabled', 'disabled' );
                        sub_input.removeAttr( 'checked', 'checked' );
                        sub_modules[ sub_name ] = 0;
                    } else {
                        sub_input.removeAttr( 'disabled', 'disabled' );
                        sub_modules[ sub_name ] = sub_check;
                    }
                } );
            }

            toast(CD_Dashboard.updating, 'info' );
            $.ajax( {
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'tophive_pro_module',
                    name: parent ? name : sub_modules,
                    enable: check,
                    doing: 'toggle_module',
                    _nonce: CD_Dashboard._nonce
                }
            }).done(function( data ) {
                toast(CD_Dashboard.updated, 'success');
                if ( reload === 1 ) {
                    window.location = window.location; // reload
                }
            }).fail(function( data ) {
                toast(CD_Dashboard.error, 'warning');
            }).always( function(){
                input.removeAttr( 'disabled' );
            });
        }

    } );

    $( document ).on( 'change', '.cd-assets .cd-onoff-assets', function(e){
        e.preventDefault();
        var input = $( this );
        if ( ! input.is( ':disabled' ) ) {
            var name = input.attr( 'name' );
            input.attr( 'disabled', 'disabled' );
            var check = input.is(':checked') ? 'on' : 'off';
            toast(CD_Dashboard.updating, 'info' );
            if ( check === 'on' ) {
                $( '.tophive-regenerate-assets' ).removeClass( 'tophive-hide-none' );
            } else {
                $( '.tophive-regenerate-assets' ).addClass( 'tophive-hide-none' );
            }
            $.ajax( {
                url: ajaxurl,
                data: {
                    action: 'tophive_pro_module',
                    name: name,
                    enable: check,
                    doing: 'toggle_module_assets',
                    _nonce: CD_Dashboard._nonce
                }
            }).done(function( data ) {
                toast(CD_Dashboard.updated, 'success');
            }).fail(function( data ) {
                toast(CD_Dashboard.error, 'warning');
            }).always( function(){
                input.removeAttr( 'disabled' );
            });
        }

    } );

    // Regenerate-assets
    $( '.tophive-regenerate-assets' ).on( 'click', function(e){
        e.preventDefault();
        var button =  $( this );
        button.addClass( 'updating-message disabled' );
        $.get( CD_Dashboard.regenerate_url, function(){
            button.removeClass('updating-message disabled');
            toast( CD_Dashboard.regenerate_done, 'success');
        } );
    } );

} );