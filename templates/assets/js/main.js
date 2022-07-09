(function ($) {
    $('.dkPlus_sync input[type="submit"]').click(function (e) {
        e.preventDefault()

        var button = $(this),
            button_type = button.data('type'),
            form = button.closest('.dkPlus_sync'),
            action = button.data('action'),
            inputs = form.find('input'),
            itemName, itemVal,
            formData = {
                'sync_params': {},
                'woocoo_schedule': form.find('select[name="woocoo_schedule"]').val()
            };

        inputs.each(function (e) {
            itemName = $(this).prop('name')
            itemVal = $(this).val()

            if ($(this).prop('type') === 'checkbox') {
                if (!$(this).prop('checked')) return;

                formData['sync_params'][e] = itemName
            }

            if ($(this).prop('type') === 'hidden') {
                formData[itemName] = itemVal
            }
        })

        $.ajax({
            url: ajax.url,
            type: 'POST',
            data: {
                'action': action,
                'data': formData
            },
            beforeSend: function () {
                button.prop('disabled', 1)
            },
            success: function () {
                button.prop('disabled', 0)
            }
        })
    })

    /*$('.dkPlus_sync').submit(function (e) {
        e.preventDefault()

        var form = $(this)
        var button = form.find('input[type="submit"]')
        var action = form.find('input[name="action"]').val()

    })*/

    $('button[data-action="dkPlus_sync_product_one"], button[data-action="send_to_dkPlus"]').click(function (e) {
        e.preventDefault()

        var form = $('.product_sync_form')
        var inputs = form.find('input')
        var button = $(this)
        var action = button.data('action')
        var formData = {'sync_params': {}}
        var itemName, itemVal
        var sku = $('input[name="_sku"]')

        if (!sku.val()) {
            $('a[href="#inventory_product_data"]').trigger('click')
            sku.focus()
            alert('Please, enter the SKU of the product')
            return;
        }

        formData['sku'] = sku.val()

        inputs.each(function (e) {
            itemName = $(this).prop('name')
            itemVal = $(this).val()

            if ($(this).prop('type') === 'checkbox') {
                if (!$(this).prop('checked')) return;

                formData['sync_params'][e] = itemName
            }

            if ($(this).prop('type') === 'hidden') {
                formData[itemName] = itemVal
            }
        })

        $.ajax({
            url: ajax.url,
            type: 'POST',
            data: {
                'action': action,
                'data': formData,
            },
            beforeSend: function () {
                button.prop('disabled', 1)
            },
            success: function (data) {
                /*var result = $.parseJSON(data)

                if (result.status === true) {
                    content_replace_items(result.content)
                }
*/
                button.prop('disabled', 0)
                //window.location.href = window.location.href + '&message=1'

            }
        })
    })
})(jQuery)
