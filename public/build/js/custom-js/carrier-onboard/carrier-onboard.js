$('#order_id').on('keyup', function() {
    var orderId = $(this).val();

    if (orderId.length > 0) {
        $.ajax({
            url: '"check-order-id"',
            method: 'GET',
            data: { order_id: orderId },
            success: function(response) {

                if (response.data.load) {
                    $('#orderIdFeedback')
                        .removeClass('d-none alert-danger')
                        .addClass('alert-success')
                        .text('Order ID exists.');
                } else {
                    $('#orderIdFeedback')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text('Order ID not exists.');
                }
            },
            error: function() {
                $('#orderIdFeedback')
                    .removeClass('d-none alert-success')
                    .addClass('alert-danger')
                    .text('An error occurred while checking the Order ID.');
            }
        });
    } else {
        $('#orderIdFeedback').addClass('d-none').text('');
    }
});

$('#verifyButton').on('click', function(){
    let warehouseId = $('#warehouseId').val();
    let orderId = $('#id').val();
    var targetTab = $(this).data('nexttab');
    console.log(targetTab);
    $.ajax({
        url: 'verify-warehouse-id',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            warehouseId: warehouseId,
            orderId: orderId
        },
        success: function(response){
            if (response.status == true) {
                toastr.success(response.message);
                $('#currentDateTime').val(response.data.current_date_time);
                $('#timeDiff').text(response.data.time_difference);
                $('#' + targetTab).tab('show');

            }

            if (response.status == false) {
                toastr.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            var errors = xhr.responseJSON.errors;
            toastr.error(error);
        }
    });
});

$('#CarrierForm').on('submit', function(e) {
    e.preventDefault();
    var targetTab = $('#btn-carrier-submit').data('nexttab');
    console.log(targetTab);
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
                toastr.success(response.message);
                $('.btn-submit').text('Submit');
                $(".btn-submit").prop("disabled", false);
                $('#' + targetTab).tab('show');
            }
            if (response.status==false) {
                toastr.error(response.message);
            }
        },
        complete: function(data) {
            $(".btn-submit").html("Submit");
            $(".btn-submit").prop("disabled", false);
        },
        error: function() {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Submit');
            $(".btn-submit").prop("disabled", false);
        }
    });

});

$('.nexttab').click(function() {
    var targetTab = $(this).data('nexttab');
    $('#' + targetTab).tab('show');
});

$('.previestab').click(function() {
    var previousTab = $(this).data('previous');
    $('#' + previousTab).tab('show');
});
