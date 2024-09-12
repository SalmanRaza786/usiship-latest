

$(document).ready(function(){



    $('.btn-start-picking').on('click', function() {

        var updateType = $(this).attr('updateType');
        updatePickingTime(updateType);
    });
    function  updatePickingTime(updateType){
        var pickerId=$('input[name=pickerId]').val();
        var workOrderId=$('input[name=work_order_id]').val();
        var stagedLoc=$('input[name=staged_loc]').val();


        $.ajax({
            url: route('admin.picking.update'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,pickerId:pickerId,workOrderId:workOrderId,stagedLoc:stagedLoc },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.btn-start-close').text('Processing...');
                $(".btn-start-close").prop("disabled", true);
            },
            success: function(response) {
                    console.log('response',response);
                if(response.status==true){
                    $('input[name=isStartPicking]').val(1);
                    $('input[name=start_pick_time]').val(response.data.start_time);
                    toastr.success(response.message)
                    checkIsPickingStart();
                    $('.btn-modal-close').click();
                    if(updateType==2){
                        window.location.href = route('admin.picking.index');
                    }
                }else{
                    toastr.error(response.message)
                }


            },
            complete: function(data) {
                if(updateType==1){
                    $(".btn-start-picking").html("Start Picking");
                }else{
                    $(".btn-close-picking").html("Close Picking");
                }

                $(".btn-start-close").prop("disabled", false);
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
            $('.btn-close-picking').removeClass('d-none');
        }else{
            $('.btn-close-picking').addClass('d-none');
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
                    toastr.success(response.message);
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

    $('.confirm-close-picking').on('click', function() {
        updatePickingTime(2);

    });

    $('#pickingDetailTable').on('click', '.btn-save-row', function() {

        var row = $(this).closest('tr');
        var formData = new FormData();
        var work_order_id=$('input[name=work_order_id]').val();

        formData.append('pickedLocId[]', row.find('.loc-id').val());
        formData.append('missedQty[]', row.find('.miss-qty').val());
        formData.append('hidden_id[]', $(this).attr('data'));
        formData.append('work_order_id',work_order_id);


        var fileInput = row.find('input[type="file"]')[0];
        var selectedFiles = fileInput.files;
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('pickedItemImages[' + 0 + '][]', selectedFiles[i]);
        }

        var fileInput = row.find('input[type="file"]')[1];
        var selectedFiles = fileInput.files;
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('pickedStagedLocImages[' + 0 + '][]', selectedFiles[i]);
        }


        $.ajax({
            url: route('admin.save-picked.items'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                beforeSend: function() {
                    row.find('.btn-save-row').text('...');
                    row.find('.btn-save-row').prop("disabled", true);
                },
            success: function(response) {
                if(response.status){
                    toastr.success(response.message);
                    // window.location.reload();
                }else{
                    toastr.error(response.message);
                }
            },
                complete: function(data) {

                    row.find('.btn-save-row').html('<i class="ri-save-2-fill fs-1"></i>');
                    row.find('.btn-save-row').prop("disabled", false);
                },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });

    });


    $('#pickingDetailTable').on('click', '.btn-delete-file', function() {
        var id = $(this).attr('data');
        $('.confirm-delete').val(id);
    });


    $('.confirm-delete').click(function() {
        var id = $(this).val();
        $.ajax({
            url: route('admin.file.remove'),
            type: 'get',
            async: false,
            dataType: 'json',
            data: { fileId: id },
            success: function(response) {
                $('#pickingDetailTable').DataTable().ajax.reload();
                $('.btn-close').click();
                toastr.success(response.message);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                toastr.success(error);
            }
        });
    });
});


