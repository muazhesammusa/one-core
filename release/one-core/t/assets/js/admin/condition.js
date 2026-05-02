
(function ($) {

    $.fn.tophive_condition = function (options) {

        var getTemplate = _.memoize(function () {
            var control = this;
            var compiled,
                /*
                 * Underscore's default ERB-style templates are incompatible with PHP
                 * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
                 *
                 * @see trac ticket #22344.
                 */
                options = {
                    evaluate: /<#([\s\S]+?)#>/g,
                    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
                    variable: 'data'
                };

            return function (data, id, data_variable_name) {
                if (_.isUndefined(id)) {
                    id = 'tmpl-tophive-condition';
                }
                if (!_.isUndefined(data_variable_name) && _.isString(data_variable_name)) {
                    options.variable = data_variable_name;
                } else {
                    options.variable = 'data';
                }

                compiled = _.template($('#' + id).html(), null, options);
                return compiled(data);
            };

        });

        if( _.isUndefined( options ) ) {
            options = {};
        }

        options = _.defaults( options, {
            ajax_url: false,
            save_cb: false,
            change_cb: false
        } );

        var ajax_url = options.ajax_url ? options.ajax_url : ajaxurl;

        var template = getTemplate();

        var condition = function ($el) {
            var panel_id = 'tmpl-tophive-condition';
            var row_id = 'tmpl-tophive-condition-row';

            var c = {
                addPanel: function () {
                    var html = template({}, panel_id );
                    $el.html(html);
                },

                add_row: function( row_values ){
                    var that = this;
                    if ( ! _.isObject( row_values ) ) {
                        row_values = {};
                    }
                    var html = template(row_values, row_id );
                    var row = $( html );
                    var id = '_id'+ new Date().getTime();
                    row.attr( 'id', id );
                    $( '.cond-list', $el ) .append( row );
                    $('select.cond-sub-id', row ).select2({
                        width: 150,
                       // minimumInputLength: 1,
                        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                        ajax: {
                            url: ajax_url,
                            dataType: 'json',
                            data: function (params) {
                                var query ;
                                query = that.get_val( row );
                                query.search = params.term;
                                query.action = 'tophive-pro/ajax/condition-data';
                                return query;
                            }
                        }
                    });

                    $('select.cond-sub-id', row ).data('select2').on('open', function (e) {
                        this.results.clear();
                        this.dropdown._positionDropdown();
                    });

                    $('.cond-lv-2 select', row ).trigger('change');

                },

                get_val: function( $row ){
                    var lv_1 =  $('.cond-lv-1 select', $row ).val();
                    var lv_2 = null;
                    var lv_3 = null;
                    var show_lv_3 = false;
                    switch ( lv_1 ) {
                        case 'archive':
                            lv_2 = $( 'select.cond--archive', $row ).val();
                            lv_3 = $( 'select.cond-sub-id' ).val();
                            break;
                        case 'singular':
                            lv_2 = $( 'select.cond--singular', $row ).val();
                            lv_3 = $( 'select.cond-sub-id',$row ).val();
                            break;
                        default:
                            break;
                    }

                    if ( lv_2 ) {
                        show_lv_3 =  true;
                        if ( lv_2.indexOf('post_type_archive/') > -1 ) {
                            lv_3  = null; // All archive do not need sub id
                            show_lv_3 = false;
                        }
                        if ( lv_2.indexOf('/') === -1 ||'general' === lv_2 ) {
                            lv_3  = null; // All archive do not need sub id
                            show_lv_3 = false;
                        }

                    } else {
                        lv_3 = null;
                        show_lv_3 = false;
                    }

                    if ( 'general' === lv_1 ) {
                        lv_3  = null; // All archive do not need sub id
                        show_lv_3 = false;
                    }

                    var sub_id_label = '';

                    if ( show_lv_3 ) {
                        var data =  $('select.cond-sub-id', $row ).select2('data');
                        if ( _.isArray( data ) && _.size( data ) > 0 ) {
                            sub_id_label = data[0].text;
                        }
                    }

                    if ( ! sub_id_label ) {
                        lv_3 = '';
                        //show_lv_3 = false;
                    }

                    return {
                        type: $( 'select.cond-type', $row ).val(),
                        name: lv_1,
                        sub_name: lv_2,
                        sub_id: lv_3,
                        show_sub_id: show_lv_3,
                        sub_id_label: sub_id_label
                    }
                },

                conditions: function() {
                    var that = this;
                    //$el.on( $('select', $el).not( '.cond-sub-id' ).change(function () {
                    $el.on( 'change', 'select:not(.cond-sub-id, .cond-type)', function () {
                        var row = $( this ).closest('.cond-item');
                        var value = that.get_val( row );
                        if ( value.name  ) {
                            $( '.cond-lv-2', row ).removeClass( 'hide' );
                        } else {
                            $( '.cond-lv-2', row ).addClass( 'hide' );
                        }
                        switch ( value.name ) {
                            case 'archive':
                                $( 'select.cond--singular', row ).addClass( 'hide' );
                                $( 'select.cond--archive', row ).removeClass( 'hide' );
                                break;
                            case 'singular':
                                $( 'select.cond--archive', row ).addClass( 'hide' );
                                $( 'select.cond--singular', row ).removeClass( 'hide' );
                                break;
                            default:
                                $( '.cond-lv-2', row ).addClass( 'hide' );
                                break;
                        }

                        try {
                            $('select.cond-sub-id', row ).find( 'option' ).remove();
                            $('select.cond-sub-id', row ).select2('change');
                        } catch ( e ){

                        }

                        if ( value.show_sub_id ){
                            $( '.cond-lv-3', row ).removeClass( 'hide' );

                        } else {
                            $( '.cond-lv-3', row ).addClass( 'hide' );
                        }

                    });
                },

                save: function(){
                    var values = [];
                    var that = this;
                    $( '.cond-item', $el ).each( function( index ){
                        values[ index ] = that.get_val( $( this ) );
                    } );
                    $el.find( '.cond-save' ).addClass( 'loading updating-message' ).text( OneCoreCustomizer_Conditional.l10n.loading );
                    var title = $( 'input.cond-name',$el).val() || '';

                    var data = {
                        action: 'tophive-pro/ajax/condition-save',
                        msid: OneCoreCustomizer_Conditional.id,
                        title: title,
                        conditionals: values,
                        _nonce: OneCoreCustomizer_Conditional._nonce
                    };

                    $.ajax( {
                        url: ajax_url,
                        type: 'post',
                        data: data,
                        success: function( res ){
                            $el.find( '.cond-save' ).removeClass( 'loading updating-message' ).text( OneCoreCustomizer_Conditional.l10n.save );
                            $( '.li-boxed[data-id="'+OneCoreCustomizer_Conditional.id+'"] .li-boxed-label' ).text( title );
                            if ( typeof  options.save_cb === 'function' ){
                                options.save_cb( res, data );
                            }
                        }
                    } );
                    console.log( 'save_value', values );
                }

            };

            c.addPanel();

            if ( _.size( OneCoreCustomizer_Conditional.conditionals ) > 0 ) {
                _.each( OneCoreCustomizer_Conditional.conditionals, function( row_values ){
                    c.add_row( row_values );
                } );
            }


            c.conditions();
            $el.on( 'click', '.cond-add', function( e ){
                e.preventDefault();
                c.add_row();
            } );

            $el.on( 'click', '.cond-remove', function( e ){
                e.preventDefault();
                $( this ).closest( '.cond-item-wrapper').remove();
            } );

            $el.on( 'click', '.cond-save', function( e ){
                e.preventDefault();
                if ( ! $( this ).hasClass('loading') ) {
                    c.save();
                }
            } );

            $el.bind( 'change', 'input select textarea', function( e ){
                if ( typeof  options.change_cb === 'function' ){
                    var values = [];
                    $( '.cond-item', $el ).each( function( index ){
                        values[ index ] = c.get_val( $( this ) );
                    } );
                    options.change_cb( values );
                }
            } );

            return c;
        };

        return this.each(function () {
            // Do something to each element here.
            return new condition($(this));
        });

    };
}(jQuery));