
$(document).ready(function(){

    $('.save-row').on('click', function() {
        var rowId = $(this).data('row-id');
        var Id = $(this).data('id');
        var row = $('#row-' + rowId);

        var data = {
            id:Id,
            cartons_qty: row.find('input[name="cartons_qty"]').val(),
            received_each: row.find('input[name="received_each"]').val(),
            exception_qty: row.find('input[name="exception_qty"]').val(),
            ti: row.find('input[name="ti"]').val(),
            hi: row.find('input[name="hi"]').val(),
            total_pallets: row.find('input[name="total_pallets"]').val(),
            lot_3: row.find('input[name="lot_3"]').val(),
            serial_number: row.find('input[name="serial_number"]').val(),
            upc_label: row.find('input[name="upc_label"]').val(),
            expiry_date: row.find('input[name="expiry_date"]').val(),
            length: row.find('input[name="length"]').val(),
            width: row.find('input[name="width"]').val(),
            height: row.find('input[name="height"]').val(),
            weight: row.find('input[name="weight"]').val(),
            custom_field_1: row.find('input[name="custom_field_1"]').val(),
            custom_field_2: row.find('input[name="custom_field_2"]').val(),
            custom_field_3: row.find('input[name="custom_field_3"]').val(),
            custom_field_4: row.find('input[name="custom_field_4"]').val()
        };
        console.log('data',data);

        $.ajax({
            url: route('admin.update.packaging.list'),
            method: 'POST',
            data: data,
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.btn-submit').text('Processing...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(response) {
                console.log(response);
                if (response.status==true) {
                    toastr.success(response.message);
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }

            },

            complete: function(data) {
                $(".btn-submit").html("Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {
                // toastr.error('something went wrong');
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });

    });

});


