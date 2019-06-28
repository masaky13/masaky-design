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

    $('.clone_button').on('click', function (e) {
        e.preventDefault();
        // 追加ボタンの前にある要素をコピー
        add_elm = $(this).prev().clone();
        last_idx = parseInt( add_elm.find('input[type="hidden"].index').val() );
        new_idx = last_idx + 1;

        // 要素のinputを取得し、ループ
        add_elm.find('input').each(function(idx, obj) {
            // button以外
            if($(obj).attr('type') != 'button') {
                // nameのindexを変更
                $(obj).attr({
                    name: $(obj).attr('name').replace(/\[[0-9]+\]+$/, '['+ new_idx +']')
                });
                // inputの値をリセット
                $(obj).val('');
                // input.indexの場合はindexを書き換え
                if($(obj).hasClass('index')) {
                    $(obj).val(new_idx);
                }
            }
        });
        // 要素のtextareaを取得し、ループ
        add_elm.find('textarea').each(function(idx, obj) {
            $(obj).attr({
                // nameのindexを変更
                name: $(obj).attr('name').replace(/\[[0-9]+\]+$/, '['+ new_idx +']')
            });
            $(obj).val('');
        });
        // 追加ボタンの前へ追加
        $(this).before(add_elm);
    });

    $(document).on('click', '.delete_button', function (e) {
        e.preventDefault();
        $(this).parent().remove();
    });


    $('.fee_item .tax').each(function() {
        if( $(this).prop('checked') === true ) {
            price = $(this).closest('.fee_item').find('#fee_price').val();
            price = price.replace(/[^0-9]/g, '');
            $tatal = price * 1.08;
            $(this).siblings('#fee_price').after('<span class="tatal">'+Math.floor($tatal)+'</span>');
        }
    });
    $('.fee_item .tax').change(function() {
        if( $(this).prop('checked') === true ) {
            price = $(this).closest('.fee_item').find('#fee_price').val();
            price = price.replace(/[^0-9]/g, '');
            $tatal = price * 1.08;
            $(this).siblings('#fee_price').after('<span class="tatal">'+Math.floor($tatal)+'</span>');
        } else {
           $(this).siblings('.tatal').remove();
        }
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
