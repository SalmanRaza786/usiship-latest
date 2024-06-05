


$(document).ready(function(){

    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
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
                $('.btn-submit').text('Saving...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    toastr.success(response.message);
                    var routeUrl =route('admin.practice.config');
                    window.location.href = routeUrl;


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
    //translationForm
    $('#translationForm').on('submit', function(e) {
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
                    $('#translationForm')[0].reset();
                    $('.btn-close').click();

                }
                if (response.status==false) {
                    toastr.error(response.message);
                    $('.btn-submit').text('Save Changes');
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

    $('#roleTable').on('click', '.btn-delete', function() {
        var id = $(this).attr('data');
        $('.confirm-delete').val(id);
    });

    $('.confirm-delete').click(function() {
        var id = $(this).val();
        $.ajax({
            url: "delete-practice-config/"+id,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            async: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status==true) {
                    toastr.success(response.message);
                    $('#roleTable').DataTable().ajax.reload();
                    $('.btn-close').click();

                }
                if (response.status==false) {
                    toastr.error(response.message);
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
                }
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

    $('#roleTable').on('click', '.btn-edit', function() {
        editElement();
        var course_id = $(this).attr('data');
        var id = $(this).attr('editId');

        $.ajax({
            url: 'edit-course/'+id,
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {

                if(response.status==true){

                    $('input[name=id]').val(course_id);
                    $('input[name=full_name]').val(response.data.full_name);
                    $('input[name=short_name]').val(response.data.course.short_name);
                    $('select[name="status"]')
                        .html(
                            `<option value="1" ${response.data.course.status == 'Active' ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data.course.status== 'In-Active' ? 'selected' : ''}>In-Active</option>`
                        )

                    $('select[name="dir"]')
                        .html(
                            `<option value="ltr" ${response.data.dir == 'ltr' ? 'selected' : ''}>LTR</option>`+
                            `<option value="rtl" ${response.data.dir== 'rtl' ? 'selected' : ''}>RTL</option>`
                        )
                }else{
                    toastr.error(response.message)
                }


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
    $('#roleTable').on('click', '.btn-translation', function() {
        var configId = $(this).attr('data');
        var id = $(this).attr('editId');
        $.ajax({
            url: 'get-practice-config-translation/'+id+'/'+configId,
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {

                if(response.status==true){

                    var html ='';
                    var navHtml ='';
                    var title = '';
                    var desc = '';
                    var activeClass = '';
                    var navActiveClass = '';
                    var defaultTranslation = '';
                    var defaultDesc = '';

                    $.each(response.data.lang, function(key, lang) {
                        (key== 0)?navActiveClass='active':navActiveClass='';
                        navHtml +='<a class="nav-link '+navActiveClass+'"  id="custom-v-pills-profile-tab-'+lang.short_code+'" data-bs-toggle="pill" href="#custom-v-pills-profile-'+lang.short_code+'" role="tab" aria-controls="custom-v-pills-profile" aria-selected="false" tabindex="-1">'+lang.title+'</a>';
                    });


                    $.each(response.data.lang, function(key, lang) {

                        if(lang.short_code=='en'){
                            defaultTranslation=lang.practice_config_translations[0].p_title;
                        }

                        if(lang.short_code=='en'){
                            defaultDesc=lang.practice_config_translations[0].p_desc;
                        }

                        (lang.practice_config_translations.length > 0)?title=lang.practice_config_translations[0].p_title:title=defaultTranslation;
                        (lang.practice_config_translations.length > 0)?desc=lang.practice_config_translations[0].p_desc:desc=defaultDesc;
                        (key== 0)?activeClass='active show':activeClass='';

                            html +='<div class="tab-pane fade '+activeClass+'" id="custom-v-pills-profile-'+lang.short_code+'" role="tabpanel" aria-labelledby="custom-v-pills-profile-tab-'+lang.short_code+'">' +
                                '<div class="mb-4">' +
                                '<input type="hidden" name="lang[]" value="'+lang.short_code+'">'+
                                '<div class="mb-3">'+
                                '<label for="fullName" class="form-label">Title</label>' +
                                '<input type="text" class="form-control" id="fullName" placeholder="Title" name="title[]" required dir="'+lang.direction+'" value="'+title+'">' +
                                '</div>' +
                                '<div class="mb-3">'+
                                '<label for="fullName" class="form-label">Description</label>' +
                                '<textarea type="text" class="form-control" id="fullName" placeholder="Description" name="desc[]" required dir="'+lang.direction+'">'+desc+'</textarea>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            });


                    $('#course-translation-section').html(html);
                    $('#course-nav-section').html(navHtml);
                    $('#translationTitle').text(response.data.editData.p_title);
                    $('input[name=t_config_id]').val(configId);

                }else{
                    toastr.error(response.message)
                }
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

    $('.btn-modal-close').click(function() {
        addElement();
    });


    function addElement(){
        $('.btn-save-changes').css('display', 'none');
        $('.btn-add').css('display', 'block');
        $('.add-lang-title').css('display', 'block');
        $('.edit-lang-title').css('display', 'none');
        // $('#addForm')[0].reset();
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

