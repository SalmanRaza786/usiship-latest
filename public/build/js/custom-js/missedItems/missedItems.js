

$(document).ready(function(){



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


    $('.btn-start-resolve').on('click', function() {

        var updateType = $(this).attr('updateType');
        updatePickingTime(updateType);
    });

    function  updatePickingTime(updateType){

        var missedId=$('input[name=missedId]').val();

        $.ajax({
            url: route('admin.missed.update'),
            type: 'POST',
            async: false,
            dataType: 'json',
            data: { updateType: updateType,missedId:missedId },
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
                    if(updateType==2){
                        $('.btn-modal-close').click();
                        window.location.href = route('admin.missing.index');
                    }

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
            $('.btn-start-resolve').addClass('d-none');
            $('.btn-close-resolve ').removeClass('d-none');
        }else{
            $('.pick-item-section').addClass('d-none');
            $('.btn-start-resolve').removeClass('d-none');
            $('.btn-close-resolve ').addClass('d-none');
        }
    }

    $('#CloseResolveForm').on('submit', function(e) {
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
                    window.location.href = route('admin.missing.index');
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-close-resolve").html("Close Picking");
                $(".btn-close-resolve").prop("disabled", false);
            },

            error: function() {
                $('.btn-close-resolve').text('Close Picking');
                $(".btn-close-resolve").prop("disabled", false);
            }
        });
    });
    $('.confirm-close-resolve').on('click', function() {
        updatePickingTime(2);
    });


    $('#clonedSection').on('click', '.btn-save-row', function() {

        var row = $(this).closest('tr');
        var formData = new FormData();
        var w_order_id=$('input[name=w_order_id]').val();
        var itemId=row.find('.item-id').val();


        var splitValues = itemId.split(',');


        formData.append('missed_detail_parent_id',splitValues[2]);
        formData.append('resolveId',$('input[name=hidden_resolve_id]').val());
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

        var fileInput = row.find('input[type="file"]')[1];
        var selectedFiles = fileInput.files;
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('newLocationItemImages[' + 0 + '][]', selectedFiles[i]);
        }

        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
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

    $('#clonedSection').on('click', '.btn-delete-file', function() {
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


