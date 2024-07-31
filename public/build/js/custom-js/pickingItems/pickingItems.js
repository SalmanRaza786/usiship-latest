

$(document).ready(function(){



    $('.btn-start-picking').on('click', function() {

        var updateType = $(this).attr('updateType');
        updatePickingTime(updateType);
    });

    function  updatePickingTime(updateType){
        var pickerId=$('input[name=pickerId]').val();
        $.ajax({
            url: route('admin.picking.update'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,pickerId:pickerId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.btn-start-picking').text('Processing...');
                $(".btn-start-picking").prop("disabled", true);
            },
            success: function(response) {
                if(response.status==true){
                    $('input[name=isStartPicking]').val(1);
                    $('input[name=start_pick_time]').val(response.data.start_time);
                    toastr.success(response.message)
                    checkIsPickingStart();
                }else{
                    toastr.error(response.message)
                }


            },
            complete: function(data) {
                $(".btn-start-picking").html("Start Picking Now");
                $(".btn-start-picking").prop("disabled", false);
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    }

    checkIsPickingStart();
    function checkIsPickingStart(){
        var isStartPicking=$('input[name=isStartPicking]').val();
        if(isStartPicking==1){
            $('.pick-item-section').removeClass('d-none');
            $('.btn-start-picking').addClass('d-none');
        }else{
            $('.pick-item-section').addClass('d-none');
            $('.btn-start-picking').removeClass('d-none');
        }
    }

    $('#ClosePickingForm').on('submit', function(e) {
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
                $('.btn-close-picking').text('Processing...');
                $(".btn-close-picking").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    window.location.href = route('admin.picking.index');
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-close-picking").html("Close Picking");
                $(".btn-close-picking").prop("disabled", false);
            },

            error: function() {
                $('.btn-close-picking').text('Close Picking');
                $(".btn-close-picking").prop("disabled", false);
            }
        });
    });

    $('.btn-close-picking').on('click', function() {

        $('#ClosePickingForm').submit();

    });
});


