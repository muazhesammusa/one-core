( function( $, api ) {

    wp.customize.selectiveRefresh._getCustomizeQuery =  wp.customize.selectiveRefresh.getCustomizeQuery;
    wp.customize.selectiveRefresh.getCustomizeQuery = function(){
        var data = this._getCustomizeQuery();
        data['msid'] = window.top.OneCoreCustomizer_MS.id;
        data['builder_id'] = top._current_builder_panel;
        return data;
    };

}( jQuery, wp.customize ) );