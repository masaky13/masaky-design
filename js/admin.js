jQuery(function($) {
    var custom_uploader;
    $('.upload_button').click(function(e) {
        e.preventDefault();
        this_btn = $(this);
        if(custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection');
            images.each(function(file) {
                this_btn.siblings('.profile_image').val( file.toJSON().url );
                this_btn.siblings('.view').html('<img style="width:100%" src="'+file.toJSON().url+'" />');
            });
        });
        custom_uploader.open();
    });

    $('.clone_button').click(function(e) {
        e.preventDefault();
        clone = $(this).prev().clone();
        cloneindex = parseInt( clone.find('input[type="hidden"]').val() );
        newindex = cloneindex + 1;
        console.log( newindex );

        clone.find("input").each(function(idx, obj) {
            if( $(obj).attr('type') != 'button' ) {
                $(obj).attr({
                    name: $(obj).attr('name').replace(/\[[0-9]\]+$/, '['+ newindex +']')
                });
                if( $(obj).attr('name').match( /skill_index/ ) ) {
                    $(obj).val(newindex);
                } else {
                    $(obj).val('');
                }
            }
        });
        clone.find('textarea').each(function(idx, obj) {
            $(obj).attr({
                name: $(obj).attr('name').replace(/\[[0-9]\]+$/, '['+ newindex +']')
            });
            $(obj).val('');
        });
        $(this).before(clone);
    });

    $('.skill_delete_button').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });
});
//   function button_disabled() {
//         skill_item_num = $('.skill_item').length;
//         console.log('kazu:'+skill_item_num);
//         if( skill_item_num === 1 ) {
//             $('.skill_delete_button').prop("disabled", true);
//         } else {
//             $('.skill_delete_button').prop("disabled", false);
//         }
//     }
