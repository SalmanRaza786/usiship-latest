
$(document).ready(function(){

    $('#addForm').on('submit', function(e) {
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
                $('.btn-submit').text('Processing...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    $('.btn-close').click();
                    resetLoadTypeForm();

                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#addForm')[0].reset();


                }
                if (response.status==false) {
                    toastr.error(response.message);
                }

            },

            complete: function(data) {
                $(".btn-submit").html("Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {
                // toastr.error('something went wrong');
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });


    });

    $('#verifyForm').on('submit', function(e) {
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
                $('.btn-verify').text('Processing...');
                $(".btn-verify").prop("disabled", true);
            },
            success: function(response) {
                if (response.status==true) {
                    $('.btn-close').click();
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },
            complete: function(data) {
                $(".btn-verify").html("Verify");
                $(".btn-verify").prop("disabled", false);
            },
            error: function() {
                $('.btn-verify').text('Verify');
                $(".btn-verify").prop("disabled", false);
            }
        });


    });

    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });

    $('#roleTable').on('click', '.btn-check-in', function() {
        editElement();

        var whId = $(this).attr('whId');
        var orderId = $(this).attr('orderId');
        var id = $(this).attr('data');
        $.ajax({
            url: 'get-door-wh-id/'+whId,
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {

                    if(response.status==true){

                        $('input[name=order_contact_id]').val(id);
                        $('input[name=order_id]').val(orderId);

                        $('select[name="whDoors"]').empty();
                        $('select[name="whDoors"]').append(`<option value="">Choose One</option>`);

                        $.each(response.data, function(key, row) {
                            $('select[name="whDoors"]').append(`<option value="${row.id}">${row.door_title}</option>`);
                        });


                    }else{
                    toastr.error(response.message)
                }


            },
            error: function(xhr, status, error) {

           toastr.error(error);
            }
        });
    });

    $('#roleTable').on('click', '.btn-carrier_docs', function() {

        var whId = $(this).attr('whId');
        var orderId = $(this).attr('orderId');
        var id = $(this).attr('data');

        $.ajax({
            url: route('admin.orderContact.get'),
            type: 'GET',
            async: false,
            data: {'id':id},
            dataType: 'json',
            success: function(response) {
                var html = '';

                    if(response.status==true){

                        $('input[name=order_id]').val(response.data.order_id);
                        $('input[name=id]').val(response.data.id);
                        $('.job-title').text(response.data.carrier.carrier_company_name);

                        $('.company-name').text(response.data.carrier.company.company_title);
                        $('.phone_no').text(response.data.carrier.contacts);
                        $('.arrive_time').text('Arrive Time : '+response.data.arrival_time);
                        $('.verify').text(response.data.is_verify);

                        if(response.data.is_verify == "Not Verified")
                        {
                            $('.btn-verify').removeClass('d-none');
                        }else {
                            $('.btn-verify').addClass('d-none');
                        }

                        $.each(response.data.carrier.docimages, function(index, file) {
                        html +='<div class="col-sm-3">'+
                            '<figure class="figure mb-0">'+
                            ' <img src="/storage/uploads/'+file.file_name+'" class="figure-img img-fluid rounded" alt="...">'+
                            ' <figcaption class="figure-caption">'+file.field_name+'</figcaption>'+
                            ' </figure>'+
                            '</div>';
                        });
                        $.each(response.data.filemedia, function(index, file) {
                            html +='<div class="col-sm-3">'+
                                '<figure class="figure mb-0">'+
                                ' <img src="/storage/uploads/'+file.file_name+'" class="figure-img img-fluid rounded" alt="...">'+
                                ' <figcaption class="figure-caption">'+file.field_name+'</figcaption>'+
                                ' </figure>'+
                                '</div>';
                        });
                        $('#media').html(html);
                    }else{
                    toastr.error(response.message)
                }


            },
            error: function(xhr, status, error) {

           toastr.error(error);
            }
        });
    });

    $('#roleTable').on('click', '.btn-delete', function() {
        var id = $(this).attr('data');
        $('.confirm-delete').val(id);
    });

    $('.confirm-delete').click(function() {
        var id = $(this).val();

        $.ajax({
            url: 'delete-load-type/'+id,
            type: 'get',
            async: false,
            dataType: 'json',
            success: function(response) {

                $('#roleTable').DataTable().ajax.reload();
                $('.btn-close').click();
                toastr.success(response.message);

            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                toastr.success(error);

            }
        });
    });

    $('.btn-modal-close').click(function() {
        addElement();
    });
    function addElement(){

        $('.btn-save-changes').css('display', 'none');
        $('.btn-add').css('display', 'block');
        $('.add-lang-title').css('display', 'block');
        $('.edit-lang-title').css('display', 'none');
        //$('#addForm').replaceWith(initialFormState.clone());
        resetLoadTypeForm();

    }
    function editElement(){
        $('.add-lang-title').css('display', 'none');
        $('.edit-lang-title').css('display', 'block');
        $('.btn-save-changes').css('display', 'block');
        $('.btn-add').css('display', 'none');
    }
    $('#loadTypeModal').modal({
        backdrop: 'static',
        keyboard: false
    })
    function resetLoadTypeForm() {
        $('#addForm')[0].reset();
        $('#addForm').find('option').prop('selected', false);
    }

});


