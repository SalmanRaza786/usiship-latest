
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


    $('#checkInContainerNumber').on('keyup', function() {
        const containerNumber = $('#checkInContainerNumber').val();
        const orderContactId = $('#orderContactId').val();

        $.ajax({
            url: 'get-checkin-container/'+orderContactId,
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {
                if(containerNumber > 0) {
                    if (response.data.vehicle_number != containerNumber) {
                        var errorHtml = '<span style="color:red">Invalid container number</span>'
                        $(".btn-close-arrival").prop("disabled", true);

                    } else {
                        var errorHtml = '<span></span>'
                        $(".btn-close-arrival").prop("disabled", false);
                    }
                    $('#containerError').html(errorHtml);
                }else{
                    var errorHtml = '<span></span>'
                    $('#containerError').html(errorHtml);
                    $(".btn-close-arrival").prop("disabled", false);
                }
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });

    });

    $('#dockTable').on('click', '.btn-delete-media', function() {
        var fileId = $(this).attr('fileId');

        $.ajax({
            url: route('admin.delete.media',{id:fileId}),
            type: 'get',
            async: false,
            dataType: 'json',
            success: function(response) {
                 $('.btn-close').click();
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                toastr.success(error);
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

                console.log('response',response);
                html +='      <div class="row">\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Company Name</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_name" type="text" required value="'+response.company_name+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Company Phone No.</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_phone_no" type="text" required value="'+response.company_phone+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '            <div class="row">\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Driver\'s Name</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_name" type="text" required value="'+response.driver_name+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Driver\'s Phone No.</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="phone_no" type="text" required value="'+response.driver_phone+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '            <div class="row">\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Container/Trailer #</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="vehicle_no" type="text" required value="'+response.vehicle_number+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">Vehicle License Plate #</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="license_no" type="text" required value="'+response.vehicle_licence_plate+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '            <div class="row">\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">BOL #</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_no" multiple type="text" required value="'+response.bol_number+'">\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '                <div class="col-md-6">\n' +
                    '                    <div  class="mt-2">\n' +
                    '                        <label for="formSizeLarge" class="form-label">BOL Image</label>\n' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_image[]" type="file" multiple  required>\n' +
                    '                    </div>\n' +
                    '                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">\n' +
                    '                        <div class="gallery-box card">\n' +
                    '                            <div class="gallery-container">\n' +
                    '                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">\n' +
                    '                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />\n' +
                    '                                    <div class="gallery-overlay">\n' +
                    '                                        <h5 class="overlay-caption">BOL Image</h5>\n' +
                    '                                    </div>' +
                    '                                </a>' +
                    '                            </div>' +
                    '\n' +
                    '                        </div>' +
                    '                    </div>' +
                    '\n' +
                    '                </div>' +
                    '            </div>' +
                    '            <div class="row">' +
                    '                <div class="col-md-6">' +
                    '                    <div  class="mt-2">' +
                    '                        <label for="formSizeLarge" class="form-label">Do #</label>' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_no" type="text" required value="'+response.do_number+'">' +
                    '                    </div>' +
                    '\n' +
                    '                </div>' +
                    '                <div class="col-md-6">' +
                    '                    <div  class="mt-2">' +
                    '                        <label for="formSizeLarge" class="form-label">Do Document</label>' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_document[]" type="file" multiple  accept="image/*" required>' +
                    '                    </div>' +
                    '\n' +
                    '                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">' +
                    '                        <div class="gallery-box card">' +
                    '                            <div class="gallery-container">' +
                    '                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">' +
                    '                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />' +
                    '                                    <div class="gallery-overlay">' +
                    '                                        <h5 class="overlay-caption">BOL Image</h5>' +
                    '                                    </div>' +
                    '                                </a>' +
                    '                            </div>' +
                    '\n' +
                    '                        </div>' +
                    '                    </div>' +
                    '                </div>' +
                    '\n' +
                    '            </div>' +
                    '            <div class="row">' +
                    '                <div class="col-md-6">' +
                    '                    <div  class="mt-2">' +
                    '                        <label for="formSizeLarge" class="form-label">Upload Driver\'s ID</label>' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_id_pic[]" type="file"  accept="image/*" multiple required>' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">' +
                    '                        <div class="gallery-box card">' +
                    '                            <div class="gallery-container">' +
                    '                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">' +
                    '                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />' +
                    '                                    <div class="gallery-overlay">' +
                    '                                        <h5 class="overlay-caption">BOL Image</h5>' +
                    '                                    </div>' +
                    '                                </a>' +
                    '                            </div>' +
                    '\n' +
                    '                        </div>' +
                    '                    </div>' +
                    '                </div>' +
                    '                <div class="col-md-6">' +
                    '                    <div  class="mt-2">' +
                    '                        <label for="formSizeLarge" class="form-label">Upload Driver\'s Other Docs</label>' +
                    '                        <input class="form-control form-control-lg" id="formSizeLarge" name="other_document[]"  accept="image/*" multiple type="file">' +
                    '                    </div>' +
                    '\n' +
                    '                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">' +
                    '                        <div class="gallery-box card">' +
                    '                            <div class="gallery-container">' +
                    '                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">' +
                    '                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />' +
                    '                                    <div class="gallery-overlay">' +
                    '                                        <h5 class="overlay-caption">BOL Image</h5>' +
                    '                                    </div>' +
                    '                                </a>' +
                    '                            </div>' +
                    '\n' +
                    '                        </div>' +
                    '                    </div>' +
                    '                </div>' +
                    '            </div>';


                $('#carrierInfo1').html(html);




            },
            error: function(xhr, status, error) {

                toastr.error(error);
            }
        });
    });



    $('#CarrierVerifyForm').on('submit', function(e) {
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
                    window.location.reload();
                }
                if (response.status==false) {
                    toastr.error(response.message);

                }

            },

            complete: function(data) {
                $(".btn-submit").html("Verify & Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {
                // toastr.error('something went wrong');
                $('.btn-submit').text('Verify & Save');
                $(".btn-submit").prop("disabled", false);
            }
        });


    });


});


