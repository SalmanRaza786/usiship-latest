$(document).ready(function() {
    $('.btn-add-row').on('click', function() {

        var clonedRow = $('#clonedSection tr:first').clone();

        clonedRow.find('input').val('');
        clonedRow.find('select').val('');


        $('#clonedSection').append(clonedRow);
        updateRowNumbers();
    });

    function updateRowNumbers() {
        $('#clonedSection tr').each(function(index) {
            $(this).find('th').text(index + 1);
        });
    }

    $('#clonedSection').on('click', '.delete-row', function() {

        var rowIndex = $(this).closest('tr').index();
        const putAwayId=$(this).attr('data');
        if(putAwayId > 0){
            fnDeletePutAwayItem(putAwayId);
        }


        if (rowIndex > 0) {
            $(this).closest('tr').remove();
        }

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
                $('.btn-submit').text('Saving...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(data) {

                if (data.status==true) {

                    toastr.success(data.message);

                    $('.checkPutAwayStatus').text('Processing');
                    $(".checkPutAwayStatus").prop("disabled", false);

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
                    $.each(response.data, function (key, row) {

                        html += '<tr>' +
                            '<td>' + row.item_name + '</td>' +
                            '<td>' + row.sku + '</td>' +
                            '<td>' + row.packgingQty + '</td>' +
                            '<td>' + row.put_away_qty + '</td>' +
                            '<td>' + row.pending + '</td>';
                        '</tr>';

                        $('#putAwayItems').html(html);
                    });
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
});
