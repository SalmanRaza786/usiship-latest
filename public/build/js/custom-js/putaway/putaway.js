$(document).ready(function() {

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

        $('#deleteRecordModal').modal('show');
        const putAwayId=$(this).attr('data');
        var $rowToDelete = $(this).closest('tr');

        $('.confirm-delete').click(function() {
            $rowToDelete.remove();
         $('#deleteRecordModal').modal('hide');

            if(putAwayId > 0){
                fnDeletePutAwayItem(putAwayId);
            }
        });
    });

    $('#savePutAwayStatus').on('click',function (){
        $('#PutAwayForm').submit();
    });
    $('#PutAwayForm').on('submit', function(e) {
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
                $('.checkPutAwayStatus').text('Processing...');
                $(".checkPutAwayStatus").prop("disabled", true);
            },
            success: function(data) {

                if (data.status==true) {
                    toastr.success(data.message);
                    window.location.reload();

                }
                if (data.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".checkPutAwayStatus").html(" Save Put Away Items");
                $(".checkPutAwayStatus").prop("disabled", false);
            },

            error: function() {;
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });
    function fnDeletePutAwayItem(id){

        $.ajax({
            url: route('admin.put-away.delete',{id:id}),
            type: 'get',
            async: false,
            dataType: 'json',
            success: function(response) {

                toastr.success(response.message);
                $('.btn-close').click();
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                var errors = xhr.responseJSON.errors;
                toastr.error(error);
            }
        });
    }

    $('#checkPutAwayStatus').on('click',function (){

    const offLoadingId=$(this).attr('data');

        $.ajax({
            url: route('admin.put-away.status',{id:offLoadingId}),
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {

                if(response.status) {

                    var html = '';
                    var totalPending=0;
                    $.each(response.data, function (key, row) {
                        totalPending=parseFloat(totalPending) + parseFloat(row.pending);

                        html += '<tr>' +
                            '<td>' + row.item_name + '</td>' +
                            '<td>' + row.sku + '</td>' +
                            '<td>' + row.packgingQty + '</td>' +
                            '<td>' + row.put_away_qty + '</td>' +
                            '<td>' + row.pending + '</td>';
                        '</tr>';

                        $('#putAwayItems').html(html);
                    });

                    if(totalPending==0){
                        $('.btn-close-putaway').removeClass('disabled');
                    }else{
                        $('.btn-close-putaway').addClass('disabled');
                    }
                    $('#loadTypeTable').html(html);
                }
                else{
                    toastr.error('Record not exist');
                }
            },
            error: function(xhr, status, error) {
                if(xhr.responseText){
                    toastr.error(xhr.responseText);
                }
                if(xhr.responseJSON.message){
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });

    //btn-close-putaway
    $('.btn-close-putaway').on('click',function (){

        const offLoadingId=$(this).attr('data');
        $.ajax({
            url: route('admin.offloading.status.change',{id:offLoadingId}),
            type: 'GET',
            async: false,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-close-putaway').text('Processing...');
                $(".btn-close-putaway").prop("disabled", true);
            },
            success: function(response) {
                window.location.href =route('admin.put-away.index');
            },
            complete: function() {
                $('.btn-close-putaway').text('Close Put Away');
                $(".btn-close-putaway").prop("disabled",false);
            },
            error: function(xhr, status, error) {
                if(xhr.responseText){
                    toastr.error(xhr.responseText);
                }
                if(xhr.responseJSON.message){
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });



});
