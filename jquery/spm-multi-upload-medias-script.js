jQuery(function($) {

    $('body').on('click', '.spm-wc_multi_upload_image_button', function(e) {
        e.preventDefault();

        var button = $(this),
            custom_uploader = wp.media({
                title: 'Insert image',
                button: {
                    text: 'Use this image'
                },
                multiple: true
            }).on('select', function() {
                var attech_ids = '';
                attachments
                var attachments = custom_uploader.state().get('selection'),
                    attachment_ids = new Array(),
                    i = 0;
                attachments.each(function(attachment) {
                    attachment_ids[i] = attachment['id'];
                    attech_ids += ',' + attachment['id'];
                    if (attachment.attributes.type == 'image') {
                        $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.url + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
                    } else {
                        $(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '"><a href="' + attachment.attributes.url + '" target="_blank"><img class="true_pre_image" src="' + attachment.attributes.icon + '" /></a><i class=" dashicons dashicons-no delete-img"></i></li>');
                    }

                    i++;
                });

                var ids = $(button).siblings('.attechments-ids').attr('value');
                if (ids) {
                    var ids = ids + attech_ids;
                    $(button).siblings('.attechments-ids').attr('value', ids);
                } else {
                    $(button).siblings('.attechments-ids').attr('value', attachment_ids);
                }
                $(button).siblings('.spmpcl_wc_multi_remove_image_button').show();
            })
            .open();
    });

    $('body').on('click', '.spmpcl_wc_multi_remove_image_button', function() {
        $(this).hide().prev().val('').prev().addClass('button').html('Add Media');
        $(this).parent().find('ul').empty();
        return false;
    });

});

jQuery(document).ready(function() {
    jQuery(document).on('click', '.spm-multi-upload-medias ul li i.delete-img', function() {
        var ids = [];
        var this_c = jQuery(this);
        jQuery(this).parent().remove();
        jQuery('.spm-multi-upload-medias ul li').each(function() {
            ids.push(jQuery(this).attr('data-attechment-id'));
        });
        jQuery('.spm-multi-upload-medias').find('input[type="hidden"]').attr('value', ids);
    });
});