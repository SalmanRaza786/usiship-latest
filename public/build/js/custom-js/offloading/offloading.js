
$(document).ready(function(){
    checkOffLoading();
    checkInputs();
    function checkInputs() {
        let allFilled = true;
        let allDisabled = true;

        $('input[type="text"]').each(function() {
            if ($(this).val() === '') {
                allFilled = false;
            }
        });

        $('input[type="file"]').each(function() {
            if (!$(this).prop('disabled')) {
                allDisabled = false;
            }
        });

        return allFilled;
        if (allFilled && allDisabled) {
            $('.btn-confirm').removeClass('d-none');
        } else {
            $('.btn-confirm').addClass('d-none');
        }
    }

    $('input').on('input', function() {
        checkInputs();
    });



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
                console.log(response);
                if (response.status==true) {

                    $('.btn-close').click();
                    toastr.success(response.message);
                    $(".btn-submit").addClass('d-none');
                    $('#order_id').val(response.data.order_id);
                    $('#offloadingContainer').removeClass('d-none');
                    window.location.reload();
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

            var dbContainerNumber=$('input[name=db_container_number]').val();
            var type_container_number=$('input[name=type_container_number]').val();

            var db_seal_no=$('input[name=db_seal_no]').val();
            var seal_no=$('input[name=seal_no]').val();

            if(inputId=='containerImages') {
                if (dbContainerNumber != type_container_number) {
                    toastr.error('invalid container#');
                    return false;
                }
            }

            if(inputId=='sealImages'){
                if(db_seal_no != seal_no){
                    toastr.error('invalid seal#');
                    return false;
                }
            }

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
        var productStageLoc = $('#product_staged_loc').val();

        var type_container_number=$('input[name=type_container_number]').val();





        //db_seal_no

        $.each(myfiles, function(index, file) {
            formData.append(inputId + '[]', file);
        });
        formData.append('off_loading_id',offLoadingId);
        formData.append('product_staged_loc',productStageLoc);
        formData.append('type_container_number',type_container_number);
        formData.append('seal_no',$('input[name=seal_no]').val());



        $.ajax({
            url: '/admin/off-loading-upload-images',
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

                if(response.status==true)
                {
                    if (response.data) {
                        displayImages(response.data.filemedia);
                        $('input[name=type_container_number]').val(response.data.container_number);
                        $('input[name=seal_no]').val(response.data.seal);

                        $('#off_loading_id').val(response.data.id);
                        $('#product_staged_loc').val(response.data.p_staged_location);
                        $(".btn-submit").addClass('d-none');
                        $('.btn-loading-close').removeClass('d-none');
                        $('#offloadingContainer').removeClass('d-none');
                    } else {
                        $('#offloadingContainer').addClass('d-none');
                        $('.btn-submit').removeClass('d-none');
                        $(".btn-loading-close").addClass('d-none');
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

        data.forEach(function(image) {
            const a = $('<a>').addClass('popup-img d-inline-block').attr('href','/storage/uploads/' + image.file_thumbnail);
            var img = $('<img>').attr('src', '/storage/uploads/' + image.file_thumbnail).attr('alt', 'Image Preview').attr('class','avatar-sm rounded object-fit-cover');
            a.append(img);
            var div = $('<div>').addClass('preview').append(a);

            $('#'+image.field_name+'Preview').append(div);
            $('#input' + image.field_name).val(image.created_at);
            $('#' + image.field_name).prop('disabled', true);

        });
    }

    $('#confirmPackgingList').click(function (){
        var id=$(this).attr('data');
       console.log(id);
       console.log(checkInputs());

       if(checkInputs()){
           window.location.href = route('admin.off-loading.confirm.packaging.list',{id:id});
       }else{
           toastr.error('Fill all fields');
       }
    })


});


