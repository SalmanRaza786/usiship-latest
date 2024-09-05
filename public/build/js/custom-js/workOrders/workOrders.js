

$(document).ready(function(){




    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });


    $('#roleTable').on('click', '.btn-assign', function() {
        $('input[name=w_order_id]').val($(this).attr('data'));
    });

    $('#AssignForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn-submit').text('Processing...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('.btn-close').click();
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-submit").html("Assign Picker");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {
                $('.btn-submit').text('Assign Picker');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });

    $('.btn-import').click(function() {

        $.ajax({
            url: 'import-work-orders',
            method: 'GET',
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn-import').text('Importing Order From WHMS wait...');
                $(".btn-import").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);

                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-import").html("Import WMS Orders");
                $(".btn-import").prop("disabled", false);
            },

            error: function() {
                $('.btn-import').text('Import WMS Orders');
                $(".btn-import").prop("disabled", false);
            }
        });
    })




});


