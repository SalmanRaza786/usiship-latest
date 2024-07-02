
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
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('#addForm')[0].reset();


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
            url: 'edit-custom-field/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                 console.log(response.data.load.require_type);
                if(response.status==true){
                    $('input[name=id]').val(id);
                    $('input[name=labal]').val(response.data.load.label);
                    $('input[name=input_type]').val(response.data.load.input_type);
                    $('input[name=place_holder]').val(response.data.load.place_holder);
                    $('#description').val(response.data.load.description);
                    $('input[name=order_by]').val(response.data.load.order_by);

                    if (response.data.load.require_type == 'Yes') {
                        $('input[name=require_type]').prop('checked', true);
                    }

                    $('select[name="input_type"]')
                        .html(`<option value="text" ${response.data.load.input_type == 'text' ? 'selected' : ''}>Text</option>`+
                            `<option value="email" ${response.data.load.input_type == 'email' ? 'selected' : ''}>Email</option>` +
                            `<option value="number" ${response.data.load.input_type == 'number' ? 'selected' : ''}>Number</option>` +
                            ` <option value="file" ${response.data.load.input_type == 'file' ? 'selected' : ''}>File</option>` +
                            ` <option value="date" ${response.data.load.input_type == 'date' ? 'selected' : ''}>Date</option>` +
                            ` <option value="time" ${response.data.load.input_type == 'time' ? 'selected' : ''}>Time</option>`
                )

                } else{
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
            url: 'delete-custom-field/'+id,
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
         $('#addForm')[0].reset();
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


