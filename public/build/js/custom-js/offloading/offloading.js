
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

    $('#toggleOffloadingContainer').on('click', function() {
        const container = $('#offloadingContainer');
        if (container.is(':visible')) {
            container.hide();
            $(this).text('Show Offloading Container');
        } else {
            container.show();
            $(this).text('Hide Offloading Container');
        }
    });



    function handleImagePreviews(inputId, previewContainerId) {
        $('#' + inputId).on('change', function(event) {
            const files = event.target.files;
            const previewContainer = $('#' + previewContainerId);
            previewContainer.empty(); // Clear previous previews

            $.each(files, function(index, file) {
                if (!file.type.startsWith('image/')) {
                    alert('Only image files are allowed!');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = $('<div>').addClass('preview');
                    const img = $('<img>').attr('src', e.target.result).attr('alt', 'Image Preview').attr('class','avatar-sm rounded object-fit-cover');
                    div.append(img);
                    previewContainer.append(div);
                };
                reader.readAsDataURL(file);
            });
            uploadImages(inputId, files);
        });
    }
    function uploadImages(inputId, files) {
        const formData = new FormData();
        $.each(files, function(index, file) {
            formData.append(inputId + '[]', file);
        });

        $.ajax({
            url: '/upload-images',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                alert('Images uploaded successfully');
            },
            error: function(error) {
                console.error(error);
                alert('Error uploading images');
            }
        });
    }
    handleImagePreviews('containerImages', 'containerImagesPreview');
    handleImagePreviews('sealImages', 'sealImagesPreview');
    handleImagePreviews('openTimeImages', 'openTimeImagesPreview');
    handleImagePreviews('1stHourImages', '1stHourImagesPreview');
    handleImagePreviews('2ndHourImages', '2ndHourImagesPreview');
    handleImagePreviews('3rdHourImages', '3rdHourImagesPreview');
    handleImagePreviews('4thHourImages', '4thHourImagesPreview');
    handleImagePreviews('5thHourImages', '5thHourImagesPreview');
    handleImagePreviews('6thHourImages', '6thHourImagesPreview');
    handleImagePreviews('7thHourImages', '7thHourImagesPreview');
    handleImagePreviews('8thHourImages', '8thHourImagesPreview');
    handleImagePreviews('productStagedImages', 'productStagedImagesPreview');
    handleImagePreviews('productStagedLocImages', 'productStagedLocImagesPreview');
    handleImagePreviews('singedOffLoadingSlipImages', 'singedOffLoadingSlipImagesPreview');
    handleImagePreviews('palletsImages', 'palletsImagesPreview');




});


