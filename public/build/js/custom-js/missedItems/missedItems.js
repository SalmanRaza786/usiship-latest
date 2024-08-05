

$(document).ready(function(){



    $('.btn-add-row').on('click', function() {

        var clonedRow = $('#clonedSection tr:first').clone();


        clonedRow.find('input').val('');
        clonedRow.find('select').val('');
        clonedRow.find('.sealImagesPreview').html('');

        // Append the cloned row to the table
        $('#clonedSection').append(clonedRow);

        // Update the row numbers and input names
       // updateRowNumbers();
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
                    if (name.includes('putawayImages')) {
                        $(this).attr('name', 'putawayImages[' + index + '][]');
                    } else if (name.includes('inventory_id')) {
                        $(this).attr('name', 'inventory_id[' + index + ']');
                    } else if (name.includes('qty')) {
                        $(this).attr('name', 'qty[' + index + ']');
                    } else if (name.includes('pallet_number')) {
                        $(this).attr('name', 'pallet_number[' + index + ']');
                    } else if (name.includes('loc_id')) {
                        $(this).attr('name', 'loc_id[' + index + ']');
                    } else if (name.includes('putAwayId')) {
                        $(this).attr('name', 'putAwayId[' + index + ']');
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
        alert(missedId);
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
        }else{
            $('.pick-item-section').addClass('d-none');
            $('.btn-start-resolve').removeClass('d-none');
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

    $('.btn-close-picking').on('click', function() {

        $('#ClosePickingForm').submit();

    });
});


