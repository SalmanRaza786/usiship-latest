



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
                    toastr.success(response.message);
                    $('.btn-close').click();
                    $('#roleTable').DataTable().ajax.reload();
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
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
        $.ajax({
            url: 'edit-companies/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',
            data: { id: id },
            success: function(response) {

                if(response.status==true){
                    $('input[name=id]').val(id);
                    $('input[name=company_title]').val(response.data.load.company_title);
                    $('input[name=email]').val(response.data.load.email);
                    $('input[name=contact]').val(response.data.load.contact);
                    $('input[name=address]').val(response.data.load.address);

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
            url: 'delete-companies/'+id,
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
    });




