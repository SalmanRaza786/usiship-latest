

$(document).ready(function(){


    $('.btn-start-qc').on('click', function() {

         var updateType = $(this).attr('updateType');
         updateQcTime(updateType);
    });

    function  updateQcTime(updateType){
        var qcId=$('input[name=qcId]').val();

        $.ajax({
            url: route('admin.qc.start'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,qcId:qcId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.btn-start-picking').text('Processing...');
                $(".btn-start-picking").prop("disabled", true);
            },
            success: function(response) {
                console.log('response',response);
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
            $('.btn-start-qc').addClass('d-none');
        }else{
            $('.pick-item-section').addClass('d-none');
            $('.btn-start-qc').removeClass('d-none');
        }
    }

    $('#CloseQCForm').on('submit', function(e) {

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
                $('.btn-close-qc').text('Processing...');
                $(".btn-close-qc").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    toastr.success(response.message);
                    window.location.href = route('admin.qc.index');
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-close-qc").html("Close Picking");
                $(".btn-close-qc").prop("disabled", false);
            },

            error: function() {
                $('.btn-close-qc').text('Close Picking');
                $(".btn-close-qc").prop("disabled", false);
            }
        });
    });

    $('.btn-close-qc ').on('click', function() {

        $('#CloseQCForm').submit();

    });
});


