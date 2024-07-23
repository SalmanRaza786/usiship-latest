
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
                $('.btn-submit').text('Processings...');
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


    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });

    $('#roleTable').on('click', '.btn-edit', function() {
        editElement();
        var id = $(this).attr('data');
        $.ajax({
            url: 'edit-load-type/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {

                    if(response.status==true){


                        $('input[name=hidden_load_type_id]').val(id);
                        $('input[name=hidden_wh_id_load_type]').val(response.data.load.wh_id);

                        $('select[name="direction"]').empty();
                        $('select[name="direction"]').append(`<option value="">Choose One</option>`);

                        $.each(response.data.ltMaterial.direction, function(key, row) {
                            $('select[name="direction"]').append(`<option value="${row.id}" ${row.id == response.data.load.direction_id ? 'selected' : ''}>${row.value}</option>`);
                        });

                        $('select[name="operation"]').empty();
                        $('select[name="operation"]').append(`<option value="">Choose One</option>`);

                        $.each(response.data.ltMaterial.operations, function(key, row) {
                            $('select[name="operation"]').append(`<option value="${row.id}" ${row.id == response.data.load.operation_id ? 'selected' : ''}>${row.value}</option>`);
                        });

                        $('select[name="equipment_type"]').empty();
                        $('select[name="equipment_type"]').append(`<option value="">Choose One</option>`);

                        $.each(response.data.ltMaterial.equipmentType, function(key, row) {
                            $('select[name="equipment_type"]').append(`<option value="${row.id}" ${row.id == response.data.load.equipment_type_id ? 'selected' : ''}>${row.value}</option>`);
                        });

                        $('select[name="trans_mode"]').empty();
                        $('select[name="trans_mode"]').append(`<option value="">Choose One</option>`);

                        $.each(response.data.ltMaterial.transportationMode, function(key, row) {
                            $('select[name="trans_mode"]').append(`<option value="${row.id}" ${row.id == response.data.load.trans_mode_id ? 'selected' : ''}>${row.value}</option>`);
                        });

                    $('select[name="status"]')
                        .html(
                            `<option value="">Choose One</option>`+
                            `<option value="1" ${response.data.load.status == '1' ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data.load.status== '2' ? 'selected' : ''}>In-Active</option>`
                        )

                        $('select[name="duration"]')
                            .html(
                                `<option  value = "" > Choose  One </option>`+
                                 `<option value="30" ${response.data.load.duration == '30' ? 'selected' : ''}>30 Minutes</option>`+
                                `<option value="60" ${response.data.load.duration == '60' ? 'selected' : ''}>60 Minutes</option>`+
                                `<option value="90" ${response.data.load.duration == '90' ? 'selected' : ''}>90 Minutes</option>`+
                                `<option value="120" ${response.data.load.duration == '120' ? 'selected' : ''}>120 Minutes</option>`+
                                `<option value="150 ${response.data.load.duration == '150' ? 'selected' : ''}">150 Minutes</option>`+
                                `<option value="180" ${response.data.load.duration == '180' ? 'selected' : ''}>180 Minutes</option>`+
                                `<option value="210" ${response.data.load.duration == '210' ? 'selected' : ''}>210 Minutes</option>`+
                                `<option value="240" ${response.data.load.duration == '240' ? 'selected' : ''}>240 Minutes</option>`
                    )

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

    //var initialFormState = $('#addForm').clone();
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


