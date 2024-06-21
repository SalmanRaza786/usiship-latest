
$(document).ready(function(){

    $('.edit-row').on('click', function() {
        var rowId = $(this).data('row-id');
        var row = $('#row-' + rowId);

        row.find('input').prop('disabled', false);
        row.find('.btn-success').prop('disabled', false);
        $(this).hide();
        row.find('.save-row').show();
    });

    $('.save-row').on('click', function() {
        var rowId = $(this).data('row-id');
        var Id = $(this).data('id');
        var row = $('#row-' + rowId);

        // var data = {
        //     id:Id,
        //     cartons_qty: row.find('input[name="cartons_qty"]').val(),
        //     received_each: row.find('input[name="received_each"]').val(),
        //     exception_qty: row.find('input[name="exception_qty"]').val(),
        //     ti: row.find('input[name="ti"]').val(),
        //     hi: row.find('input[name="hi"]').val(),
        //     total_pallets: row.find('input[name="total_pallets"]').val(),
        //     lot_3: row.find('input[name="lot_3"]').val(),
        //     serial_number: row.find('input[name="serial_number"]').val(),
        //     upc_label: row.find('input[name="upc_label"]').val(),
        //     expiry_date: row.find('input[name="expiry_date"]').val(),
        //     length: row.find('input[name="length"]').val(),
        //     width: row.find('input[name="width"]').val(),
        //     height: row.find('input[name="height"]').val(),
        //     weight: row.find('input[name="weight"]').val(),
        //     custom_field_1: row.find('input[name="custom_field_1"]').val(),
        //     custom_field_2: row.find('input[name="custom_field_2"]').val(),
        //     custom_field_3: row.find('input[name="custom_field_3"]').val(),
        //     custom_field_4: row.find('input[name="custom_field_4"]').val()
        // };
        var data = new FormData();
        data.append('id', Id);
        data.append('cartons_qty', row.find('input[name="cartons_qty"]').val());
        data.append('received_each', row.find('input[name="received_each"]').val());
        data.append('exception_qty', row.find('input[name="exception_qty"]').val());
        data.append('ti', row.find('input[name="ti"]').val());
        data.append('hi', row.find('input[name="hi"]').val());
        data.append('total_pallets', row.find('input[name="total_pallets"]').val());
        data.append('lot_3', row.find('input[name="lot_3"]').val());
        data.append('serial_number', row.find('input[name="serial_number"]').val());
        data.append('upc_label', row.find('input[name="upc_label"]').val());
        data.append('expiry_date', row.find('input[name="expiry_date"]').val());
        data.append('length', row.find('input[name="length"]').val());
        data.append('width', row.find('input[name="width"]').val());
        data.append('height', row.find('input[name="height"]').val());
        data.append('weight', row.find('input[name="weight"]').val());
        data.append('custom_field_1', row.find('input[name="custom_field_1"]').val());
        data.append('custom_field_2', row.find('input[name="custom_field_2"]').val());
        data.append('custom_field_3', row.find('input[name="custom_field_3"]').val());
        data.append('custom_field_4', row.find('input[name="custom_field_4"]').val());

        // Add multiple images to FormData
        var damageImages = row.find('input[name="damageImages[]"]')[0].files;
        for (var i = 0; i < damageImages.length; i++) {
            data.append('damageImages[]', damageImages[i]);
        }
        var upc_label_photos = row.find('input[name="upc_label_photos[]"]')[0].files;
        for (var i = 0; i < upc_label_photos.length; i++) {
            data.append('upc_label_photos[]', upc_label_photos[i]);
        }


       // console.log('data',data);

        $.ajax({
            url: route('admin.update.packaging.list'),
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                row.find('.save-row').prop('disabled', true);
            },
            success: function(response) {
                console.log(response);
                if (response.status==true) {
                    toastr.success(response.message);
                    row.find('input').prop('disabled', true);
                    row.find('.btn-success').prop('disabled', true);
                    row.find('.save-row').hide();
                    row.find('.edit-row').show();
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },
            complete: function(data) {
                row.find('.save-row').prop('disabled', false);
            },
            error: function() {
                 toastr.error('something went wrong');
                row.find('.save-row').prop('disabled', false);
            }
        });

    });

});


