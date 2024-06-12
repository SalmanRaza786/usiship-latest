
$(document).ready(function(){
    checkOffLoading();

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
                    toastr.success(response.message);
                    $(".btn-submit").addClass('d-none');
                    $('#offloadingContainer').removeClass('d-none');
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }

            },
            complete: function(data) {
                $(".btn-submit").html("Start Off Loading Now");
                $(".btn-submit").prop("disabled", false);
            },
            error: function() {
                // toastr.error('something went wrong');
                $('.btn-submit').text('Start Off Loading Now');
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

    $('.btn-modal-close').click(function() {
        addElement();
    });

    function addElement(){
        $('.btn-save-changes').css('display', 'none');
        $('.btn-add').css('display', 'block');
        $('.add-lang-title').css('display', 'block');
        $('.edit-lang-title').css('display', 'none');
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
            previewContainer.empty();
            $.each(files, function(index, file) {
                if (!file.type.startsWith('image/')) {
                    toastr.error('Only image files are allowed!');
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
        var myfiles = $('#' + inputId)[0].files;
        var offLoadingId = $('#off_loading_id').val();

        $.each(myfiles, function(index, file) {
            formData.append(inputId + '[]', file);
        });
        formData.append('off_loading_id',offLoadingId);

        $.ajax({
            url: '/admin/upload-images',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.status == true) {
                    toastr.success(response.message);
                    $('#input' + inputId).val(response.data.created_at);
                    $('#' + inputId).prop('disabled', true);
                } else if (response.status == false) {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                toastr.error(error);
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

    function checkOffLoading() {
        var orderCheckinId = $('#order_checkin_id').val();

        $.ajax({
            url: '/admin/check-order-checkin-id',
            type: 'GET',
            data: { order_checkin_id: orderCheckinId },
            success: function(response) {
                console.log(response.data.filemedia);
                if(response.status==true)
                {
                    if (response.data) {
                        displayImages(response.data.filemedia);
                        $('#off_loading_id').val(response.data.id);
                        $(".btn-submit").addClass('d-none');
                        $('#offloadingContainer').removeClass('d-none');
                    } else {
                        $('#offloadingContainer').addClass('d-none');
                        $('.btn-submit').removeClass('d-none');
                    }
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }

            },
            error: function(error) {
                console.error(error);
                toastr.error(error);
            }
        });
    }
    function displayImages(data) {
        var baseUrl ='{{URL::("public/storage/")}}';
        data.forEach(function(image) {
            var img = $('<img>').attr('src', '/storage/uploads/' + image.file_name).attr('alt', 'Image Preview').attr('class','avatar-sm rounded object-fit-cover');
            var div = $('<div>').addClass('preview').append(img);

            $('#'+image.field_name+'Preview').append(div);
            $('#input' + image.field_name).val(image.created_at);
            $('#' + image.field_name).prop('disabled', true);

            // if (image.field_name === 'containerImages') {
            //
            // } else if (image.field_name === 'sealImages') {
            //     $('#sealImagesPreview').append(div);
            // }
        });
    }


});


