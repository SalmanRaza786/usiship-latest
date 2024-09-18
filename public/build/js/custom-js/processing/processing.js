

$(document).ready(function(){


    $('.btn-start-qc').on('click', function() {

         var updateType = $(this).attr('updateType');
         updateQcTime(updateType);
    });

    function  updateQcTime(updateType){
        var process_id=$('input[name=process_id]').val();
        var status_code=$('input[name=status_code]').val();


        $.ajax({
            url: route('admin.qc.start'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,process_id:process_id,status_code:status_code },
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

    $('#ProcessStart').on('submit', function(e) {

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
                $('.btn-start').text('Processing...');
                $(".btn-start").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    toastr.success(response.message);
                    $('#roleTable').DataTable().ajax.reload();
                    $('#ProcessStart')[0].reset();
                    $('.btn-close').click();
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-start").html("Start Processing");
                $(".btn-start").prop("disabled", false);
            },

            error: function() {
                $('.btn-start').text('Start Processing');
                $(".btn-start").prop("disabled", false);
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

    $('#roleTable').on('click', '.btn-start-processing', function() {
        var id = $(this).attr('data');
        console.log(id);
        $.ajax({
            url: route('admin.process.get', { id: id }),
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if(response.status==true){
                    $('input[name=process_id]').val(response.data.id);
                    $('input[name=order_ref]').val(response.data.work_order.order_reference);
                    $('input[name=customer_name]').val(response.data.work_order.client.name);
                    $('input[name=qc_start_time]').val(response.data.qc_work_order.start_time);
                    $('input[name=staged_location]').val(response.data.work_order.staged_location);


                }else{
                    toastr.error(response.message)
                }


            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    });


    $('.btn-add-row').on('click', function() {

        var clonedRow = $('#clonedSection tr:first').clone();


        clonedRow.find('input').val('');
        clonedRow.find('select').val('');
        clonedRow.find('.sealImagesPreview').html('');

        // Append the cloned row to the table
        $('#clonedSection').append(clonedRow);

        // Update the row numbers and input names
        updateRowNumbers();
    });

    function updateRowNumbers() {
        // Loop through each row to update the row numbers and input names
        $('#clonedSection tr').each(function(index) {
            // Update the row number
            $(this).find('th').text(index + 1);

            // Update the name attributes of the inputs
            $(this).find('input, select').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    // Update the name for putawayImages
                    if (name.includes('resolveQtyImages')) {
                        $(this).attr('name', 'resolveQtyImages[' + index + '][]');
                    } else if (name.includes('newLocationItemImages')) {
                        $(this).attr('name', 'newLocationItemImages[' + index + ']');
                    }
                }
            });
        });
    }

    $('#clonedSection').on('click', '.delete-row', function() {

        var $rowToDelete = $(this).closest('tr');
        $rowToDelete.remove();

    });

    $('#clonedSection').on('click', '.btn-save-row', function() {

        var row = $(this).closest('tr');
        var formData = new FormData();
        var w_order_id=$('input[name=w_order_id]').val();
        var itemId=row.find('.item-id').val();


        var splitValues = itemId.split(',');


        formData.append('missed_detail_parent_id',splitValues[2]);
        formData.append('resolveId',$('input[name=hidden_process_id]').val());
        formData.append('itemId[]', itemId);
        formData.append('resolveQty[]', row.find('.resolve-qty').val());
        formData.append('newLocId[]', row.find('.new-loc-id').val());

        formData.append('w_order_id',w_order_id);
        formData.append('staff_id',$('input[name=staff_id]').val());
        formData.append('missed_id',$('input[name=missed_id]').val());
        formData.append('status_code',$('input[name=status_code]').val());


        var fileInput = row.find('input[type="file"]')[0];
        var selectedFiles = fileInput.files;
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('resolveItemImages[' + 0 + '][]', selectedFiles[i]);
        }




        $.ajax({
            url: route('admin.save.resolve'),
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
                    window.location.reload();
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

});

