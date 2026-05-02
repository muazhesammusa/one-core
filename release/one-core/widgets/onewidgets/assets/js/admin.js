jQuery(document).ready( function(){
    function media_upload( button_class) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
        jQuery('body').on('click',button_class, function(e) {
            var button_id ='#'+jQuery(this).attr('id');
            var self = jQuery(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = jQuery(button_id);
            var id = jQuery(button_class).attr('id');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                   jQuery( button_id + '.custom_media_id').val(attachment.id); 
                   jQuery( button_id + '.custom_media_url').val(attachment.url).trigger('change');
                   jQuery( button_id + '.custom_media_image').attr('src',attachment.url).css('display','block');   
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(button);
            return false;
        });
    }
    media_upload( '.custom_media_upload');
});
( function( $ ){
    function initColorPicker( widget ) {
        widget.find( '.color-picker' ).wpColorPicker( {
            change: _.throttle( function() { // For Customizer
                $(this).trigger( 'change' );
            }, 1000 ),
            palettes: ['#ededed', '#ecf0f1',  '#c8d6e5', '#7f8c8d', '#34495e', '#22313f', '#2ecc71', '#48b56a', '#0abde3', '#1f8dd6', '#2574a9', '#1f3a93', '#5f27cd', '#fad232','#ff9f43', '#ed6789', '#ff6b6b', '#ee5253'],
        });
    }

    function onFormUpdate( event, widget ) {
        initColorPicker( widget );
    }

    $( document ).on( 'widget-added widget-updated', onFormUpdate );

    $( document ).ready( function() {
        $( '.widget:has(.color-picker)' ).each( function () {
            initColorPicker( $( this ) );
        } );
    } );
}( jQuery ) );

jQuery(document).ready(function($) {
    let mediaUploader;

    // Add item
    $(document).on('click', '.add-menu-item', function (e) {
        e.preventDefault();

        const container = $(this).siblings('.menu-items-container');
        const index = container.find('.menu-item').length;
        const baseName = $(this).data('field-prefix');
        const fieldPrefix = `${baseName}[${index}]`;

        const html = `
        <div class="menu-item" style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
            <p>Text: <input type="text" name="${fieldPrefix}[text]" class="widefat" /></p>
            <p>URL: <input type="text" name="${fieldPrefix}[url]" class="widefat" /></p>
            <p>
                Icon Image URL:
                <input type="text" name="${fieldPrefix}[icon]" class="widefat icon-url" />
                <button class="upload-icon button">Upload</button>
            </p>
            <button class="remove-menu-item button">Remove</button>
        </div>`;
        container.append(html);
    });

    // Remove item
    $(document).on('click', '.remove-menu-item', function (e) {
        e.preventDefault();
        $(this).closest('.menu-item').remove();
    });

    // Media uploader for icon
    $(document).on('click', '.upload-icon', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.icon-url');

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Select Icon Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
        });

        mediaUploader.open();
    });
});
