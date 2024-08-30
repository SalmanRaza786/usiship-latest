
$(document).ready(function(){


    $('#addFrom').on('submit', function(e) {
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
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#addFrom')[0].reset();


                }
                if (response.status==false) {
                    toastr.error(response.message);
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
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


    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });


    $('#roleTable').on('click', '.btn-edit', function() {
        editElement();
        var id = $(this).attr('data');
        // console.log("ID:", id);
        $.ajax({
            url: 'edit-carriers/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                 console.log(response.data);
                if(response.status==true){
                    $('input[name=id]').val(id);
                    $('input[name=company_id]').val(response.data.load.company_id);
                    $('input[name=carrier_company_name]').val(response.data.load.carrier_company_name);
                    $('input[name=email]').val(response.data.load.email);
                    // $('input[name=description]').val(response.data.load.description);
                    $('input[name=contacts]').val(response.data.load.contacts);
                    $('select[name="company_id"]').empty();
                    $.each(response.data.companies.data.data, function(key, company) {

                                console.log(company.id);
                                $('select[name="company_id"]').append(`<option value="${company.id}" ${company.id == response.data.load.company_id ? 'selected' : ''}>${company.company_title}</option>`)

                    });
                }else{
                    toastr.error(response.message)
                }


            },
            error: function(xhr, status, error) {
                console.log(status);
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
            url: 'delete-carriers/'+id,
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
        $('#addFrom')[0].reset();
    }
    function editElement(){
        $('.add-lang-title').css('display', 'none');
        $('.edit-lang-title').css('display', 'block');
        $('.btn-save-changes').css('display', 'block');
        $('.btn-add').css('display', 'none');

    }

    $('#showModal').modal({
        backdrop: 'static',
        keyboard: false
    })


    $('#syncLectures').on('click', function() {

        $.ajax({
            url: route('admin.lectures.sync'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#syncLectures').text('Processing...');
                $("#syncLectures").prop("disabled", true);
            },
            success: function(response) {
                if (response==1){
                    toastr.success('Lectures synced successfully');
                }
            },

            complete: function(data) {
                $("#syncLectures").html("Sync Lectures");
                $("#syncLectures").prop("disabled", false);
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



