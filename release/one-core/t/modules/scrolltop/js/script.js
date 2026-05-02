jQuery( document ).ready( function( $ ){

    var scrolltop_duration = OneCoreCustomizer_JS.scrolltop_duration;
    var scrolltop_offset = OneCoreCustomizer_JS.scrolltop_offset;

    scrolltop_duration = parseInt( scrolltop_duration );
    if ( isNaN( scrolltop_duration ) ) {
        scrolltop_duration = 500;
    }

    scrolltop_offset = parseInt( scrolltop_offset );
    if ( isNaN( scrolltop_offset ) ) {
        scrolltop_offset = 100;
    }

    $( document ).on( 'click', '.scrolltop', function(e){
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, scrolltop_duration );
    } );

    function show_scroll(){
        var scroll_top = $( document ).scrollTop();
        if ( scroll_top > scrolltop_offset ) {
            $( '.scrolltop' ).removeClass( 'hide' );
        } else {
            $( '.scrolltop' ).addClass( 'hide' );
        }
    }

    show_scroll();

    // When page scroll
    $( document ).scroll(function() {
        show_scroll();
    } );


} );