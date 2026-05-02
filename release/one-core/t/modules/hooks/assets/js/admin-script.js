

jQuery( document ).ready( function( $ ){


    $('select.tophive_hook_name' ).select2({});

    $( '.hook-conditionals' ).tophive_condition({
        change_cb: function( values ){
            $( '#tophive_hook_conditionals' ).val( JSON.stringify( values ) );
        }
    });

   // htmlEditor = wp.codeEditor.initialize( $( "#hook-html-template" ).find('textarea' ), tophiveHookCodeEditor_config.html );
    phpEditor = wp.codeEditor.initialize( $( "#hook-php-template" ).find('textarea' ), tophiveHookCodeEditor_config.php );

    var current_editor_type = $( '#tophive_current_editor' ).val();

    $( '#hook-enable-php' ).addClass('tophive-hide-none');

    $( '#tophive-hooks-settings-tabs-wrapper a').click( function( e ){
        e.preventDefault();
        var mod =  $( this ).data( 'editor' ) || '';
        $( this ).parent().find( 'a' ).removeClass( 'nav-tab-active' );
        $( this ).addClass( 'nav-tab-active' );

        if ( mod  === 'code' ) {
            $( '#hook-script-div' ).addClass('show');
            $( '#postdivrich' ).addClass('tophive-hide ');
            $( '#elementor-editor' ).addClass('tophive-hide-none');
            $( '#elementor-switch-mode-button' ).addClass('tophive-hide-none');
            $( '#hook-enable-php' ).removeClass('tophive-hide-none');
        } else {
            $( '#hook-script-div' ).removeClass('show');
            $( '#postdivrich' ).removeClass('tophive-hide');
            $( '#elementor-editor' ).removeClass('tophive-hide-none');
            $( '#elementor-switch-mode-button' ).removeClass('tophive-hide-none');
            $( '#hook-enable-php' ).addClass('tophive-hide-none');
        }

        $( window ).resize();

        $( '#tophive_current_editor' ).val( mod );
    } );

    $( '#tophive-hooks-settings-tabs-wrapper a[data-editor="'+current_editor_type+'"]').click();

    $( '.tophive_hook_name' ).on( 'change custom_change', function(){
        var v = $( this ).val();
        if ( v === '__custom' ) {
            $( '.custom-hook-input' ).removeClass( 'tophive-hide-none' );
        } else {
            $( '.custom-hook-input' ).addClass( 'tophive-hide-none' );
        }
    } );

    $( '.tophive_hook_name' ).trigger( 'custom_change' );


} );
