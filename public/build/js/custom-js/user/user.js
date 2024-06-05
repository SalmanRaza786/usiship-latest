
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
                $('.btn-submit').text('Saving...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(response) {


                if (response.status==true) {
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#addFrom')[0].reset();
                    $('.btn-close').click();
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);

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


    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });


    $('#roleTable').on('click', '.btn-edit', function() {
        editElement();
        var id = $(this).attr('data');
        $.ajax({
            url: 'edit-user/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                 // console.log(response.data.roles);
                if(response.status==true){
                    $('input[name=id]').val(response.data.users.id);
                    $('input[name=first_name]').val(response.data.users.name);
                    $('input[name=email]').val(response.data.users.email);
                    $('input[name=contact]').val(response.data.users.phone);
                    $('input[name=password_confirmation]').val(response.data.users.password);
                    $('input[name=password]').val(response.data.users.password);

                    $('select[name="status"]')
                        .html(
                            `<option value="1" ${response.data.users.status == 'Active' ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data.users.status== 'In-Active' ? 'selected' : ''}>In-Active</option>`
                        )
                    $('select[name="roles"]').empty();
                    $.each(response.data.roles, function(key, role) {
                        $.each(role, function(key, role) {
                            $('select[name="roles"]').append(`<option value="${role.id}" ${role.id == response.data.users.role_id ? 'selected' : ''}>${role.name}</option>`)

                        });

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
            url: 'delete-user/'+id,
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




});


