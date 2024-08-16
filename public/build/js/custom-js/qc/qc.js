

$(document).ready(function(){


    $('.btn-start-qc').on('click', function() {

         var updateType = $(this).attr('updateType');
         updateQcTime(updateType);
    });

    function  updateQcTime(updateType){
        var qc_id=$('input[name=qc_id]').val();
        var status_code=$('input[name=status_code]').val();


        $.ajax({
            url: route('admin.qc.start'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,qc_id:qc_id,status_code:status_code },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                if(updateType==1) {
                    $('.btn-start-qc').text('Processing...');
                    $(".btn-start-qc").prop("disabled", true);
                }else{
                    $('.btn-close-qc').text('Processing...');
                    $(".btn-close-qc").prop("disabled", true);
                }
            },
            success: function(response) {
                console.log('response',response);
                if(response.status==true){
                    $('input[name=isStartPicking]').val(1);
                    $('input[name=start_pick_time]').val(response.data.start_time);
                    toastr.success(response.message)
                    checkIsPickingStart();
                    if(updateType==2) {
                        window.location.href = route('admin.qc.index');
                    }
                }else{
                    toastr.error(response.message)
                }


            },
            complete: function(data) {
                if(updateType==1) {
                    $('.btn-start-qc').text('Start Q/C');
                    $(".btn-start-qc").prop("disabled", false);
                }else{
                    $('.btn-close-qc').text('Close Q/C');
                    $(".btn-close-qc").prop("disabled", false);
                }
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
            $('.btn-close-qc').removeClass('d-none');
        }else{
            $('.pick-item-section').addClass('d-none');
            $('.btn-start-qc').removeClass('d-none');
            $('.btn-close-qc').addClass('d-none');
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
        updateQcTime(2);
    });
    $('#qcTable').on('click', '.btn-save-row', function() {

        var row = $(this).closest('tr');
        var formData = new FormData();
        var work_order_id=$('input[name=work_order_id]').val();


        formData.append('hidden_id[]', $(this).attr('data'));
        formData.append('qcQty[]', row.find('.qcQty').val());
        formData.append('work_order_id',work_order_id);


        var fileInput = row.find('input[type="file"]')[0];
        var selectedFiles = fileInput.files;
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('qcItemImages[' + 0 + '][]', selectedFiles[i]);
        }


        $.ajax({
            url: route('admin.update.qc'),
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
                console.log('response',response);
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


    $('#qcTable').on('click', '.btn-delete-file', function() {
        var id = $(this).attr('data');
        console.log('id',id);
        $('.confirm-delete').val(id);
    });



    $('.confirm-delete').click(function() {
        var id = $(this).val();
        console.log('deleted file id',id);
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


