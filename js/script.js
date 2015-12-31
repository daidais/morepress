jQuery(function (jQuery) {
    var $ = jQuery;

    function initAutocomplete(element)
    {
        var $this = $(element);
        $this.autocomplete({
            source: php_array.admin_ajax + '?action=morepress_'+$this.attr('data-callback')+'_ajax',
            select: function (event, ui) {
                $this.val(ui.item.post_title);
                $this.next().val(ui.item.ID);
                return false;
            },
            change: function (event, ui) {
                if (!ui.item) {
                    $this.val('');
                    $this.next().val('');
                }
            }
        });
        $this.autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<a>" + item.ID + ": " + item.post_title + " (" + item.post_type + ")</a>")
                    .appendTo(ul);
        };
    }

    $(document).on('click', '.upload_image_button', function (e) {
        var formfield = $(this).parent().parent().find('.upload_image');
        var preview = $(this).parent().parent().find('.upload_preview');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.send_to_editor = function (html) {
            var regexurl = /<img.*?src="(.*?)"/;
            var imgurl = regexurl.exec(html)[1];
            var regexclass = /<img.*?class="(.*?)"/;
            var imgclass = regexclass.exec(html)[1];
            var idclass = imgclass.replace(/(.*?)wp-image-/, '');
            formfield.val(idclass);
            preview.find('img').attr('src', imgurl);
            tb_remove();
            return;
        };
        return e.preventDefault();
    });
    $(document).on('click', '.upload_button', function (e) {
        var formfield = $(this).parent().parent().find('.upload');
        var preview = $(this).parent().parent().find('.upload_preview');
        tb_show('', 'media-upload.php?TB_iframe=true');
        window.send_to_editor = function (html) {
            var href = $(html).attr('href');
            formfield.val(href);
            preview.find('a').attr('href', href).text(href);
            tb_remove();
            return;
        };
        return e.preventDefault();
    });

    $(document).on('click', '.clear_image_button', function (e) {
        var defaultImage = $(this).parent().parent().find('.default_image').text();
        $(this).parent().parent().find('.upload_image').val('');
        $(this).parent().parent().find('.preview_image').attr('src', defaultImage);
        return e.preventDefault();
    });
    $(document).on('click', '.clear_button', function (e) {
        $(this).parent().parent().find('.upload').val('');
        $(this).parent().parent().find('.upload_preview a').attr('href', '#').text('');
        return e.preventDefault();
    });

    // Reapeatable fields
    $(document).on('click', '.repeatable-add', function (e) {

        var field = $(this).closest('td').find('.repeatable li:last').clone(true);
        var fieldLocation = $(this).closest('td').find('.repeatable li:last');
        field.insertAfter(fieldLocation, $(this).closest('td'));
        return e.preventDefault();
    });

    $(document).on('click', '.repeatable-remove', function (e) {
        $(this).parent().remove();
        return e.preventDefault();
    });

    // Reapeatable fieldset
    $(document).on('click', '.group-repeatable-add', function (e) {
        var $newFieldset = $($(this).attr('href')).html();
        $newFieldset = $newFieldset.replace(/__INDEX__/g, $(this).parent().parent().find('fieldset').size());
        $(this).parent().before($newFieldset);
        $('.morepress_post_list').each(function () {
            initAutocomplete(this);
        });
        return e.preventDefault();
    });

    $(document).on('click', '.group-repeatable-remove', function (e) {
        $(this).parent().parent().remove();
        return e.preventDefault();
    });

    $('.morepress_post_list').each(function () {
        initAutocomplete(this);
    });

});
