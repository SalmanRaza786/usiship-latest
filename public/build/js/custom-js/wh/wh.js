

$(document).ready(function(){

var editLoadTypeId=[];
var editAssignedFieldId=0;



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
            url: 'delete-wh/'+id,
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
        resetLoadTypeForm();
    });
    function addElement(){
        $('.btn-save-changes').css('display', 'none');
        $('.btn-add').css('display', 'block');
        $('.add-lang-title').css('display', 'block');
        $('.edit-lang-title').css('display', 'none');

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


    var targetSection='';
    $('.btn-add-row').on('click',function(){
        const fromData=$(this).attr('fromData');
        const toData=$(this).attr('toData');

        targetSection=toData;
        addNewRow(fromData,toData);

    })

    function addNewRow(fromData,toData){
        $(toData).append($(fromData).clone());
    }

    $(document).on('click', targetSection + ' .delete-row', function() {
        $(this).closest('.input-group').remove();
    });





    $("#btn-save-wh-info").click(function(){

        $.ajax({
            url: $('#whInfoForm').attr('action'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#whInfoForm").serialize(),
            dataType: 'JSON',
            cache:false,
            processData: false,
            beforeSend: function() {
                $('#btn-save-wh-info').text('Processing...');
                $("#btn-save-wh-info").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    $('#btnWorkingHours').click();

                    $('input[name=id]').val(response.data.id);
                    $('input[name=hidden_wh_id_load_type]').val(response.data.id);
                    $('input[name=hidden_wh_id_dock]').val(response.data.id);
                    $('input[name=hidden_wh_id_fields]').val(response.data.id);
                }
                if (response.status==false) {
                    $.each(response.data, function (key, row) {
                    toastr.error(row);
                    });
                }
            },

            complete: function(data) {

                $('#btn-save-wh-info').text('Save & Continue to Load Types');
                $("#btn-save-wh-info").prop("disabled", false);
            },

            error: function(err) {;
                toastr.error(err.responseJSON.message);
            }
        });
    });

    getLoadTypeAccordingWareHouse($('input[name=id]').val());

    function getLoadTypeAccordingWareHouse(whId){
        $.ajax({
            url: route('wh.loadType.list'),
            type: 'GET',
            async: false,
            dataType: 'json',
            data:{wh_id:whId},
            success: function(response) {

                if(response.status) {
                    loadTypeForMultiSelect(response.data);
                    var html = '';
                    $.each(response.data, function (key, row) {

                        html += '<tr>' +
                            '<td>' + row.direction.value + '</td>' +
                            '<td>' + row.operation.value + '</td>' +
                            '<td>' + row.eq_type.value + '</td>' +
                            '<td>' + row.trans_mode.value + '</td>' +
                            '<td>' + row.duration + ' Minutes</td>' +
                            '<td>';
                        if (row.status == 1) {
                            html +='<span class="badge badge-soft-success text-uppercase">Active</span>';
                        } else  {
                            html +='<span class="badge badge-soft-danger text-uppercase">InActive</span>';
                        }

                        html +='</td>';
                        if(row.wh_id > 0) {
                            html +='<td>' +
                            '<a href="#" class="btn-edit-load"  data="' + row.id + '"  data-bs-toggle="modal" data-bs-target="#loadTypeModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>' +
                            '<a href="#" class="btn-delete-load"  data="' + row.id + '"  data-bs-toggle="modal" data-bs-target="#deleteLoadTypeModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>' +
                            '</td>';
                        }else{
                            html +='<td>-</td>';
                        }
                            '</tr>';


                    });
                    $('#loadTypeTable').html(html);
                }
                else{
                    toastr.error('Record not exist');
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
    }


    $('#loadTypeTable').on('click', '.btn-edit-load', function() {

        var loadId = $(this).attr('data');

        $.ajax({
            url:route('admin.load.edit',{id:loadId}),
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {

                if(response.status==true){

                    $('input[name=hidden_wh_id_load_type]').val(response.data.load.wh_id);
                    $('input[name=hidden_load_type_id]').val(loadId);


                    $('select[name="direction"]').empty(); // Clear existing options
                    $('select[name="direction"]').append(`<option value="">Choose One</option>`);

                    $.each(response.data.ltMaterial.direction, function(key, row) {
                        $('select[name="direction"]').append(`<option value="${row.id}" ${row.id == response.data.load.direction_id ? 'selected' : ''}>${row.value}</option>`);
                    });

                    $('select[name="operation"]').empty(); // Clear existing options
                    $('select[name="operation"]').append(`<option value="">Choose One</option>`);
                    $.each(response.data.ltMaterial.operations, function(key, row) {
                        $('select[name="operation"]').append(`<option value="${row.id}" ${row.id == response.data.load.operation_id ? 'selected' : ''}>${row.value}</option>`);
                    });

                    $('select[name="equipment_type"]').empty(); // Clear existing options
                    $('select[name="equipment_type"]').append(`<option value="">Choose One</option>`);
                    $.each(response.data.ltMaterial.equipmentType, function(key, row) {
                        $('select[name="equipment_type"]').append(`<option value="${row.id}" ${row.id == response.data.load.equipment_type_id ? 'selected' : ''}>${row.value}</option>`);
                    });

                    $('select[name="trans_mode"]').empty(); // Clear existing options
                    $('select[name="trans_mode"]').append(`<option value="">Choose One</option>`);
                    $.each(response.data.ltMaterial.transportationMode, function(key, row) {
                        $('select[name="trans_mode"]').append(`<option value="${row.id}" ${row.id == response.data.load.trans_mode_id ? 'selected' : ''}>${row.value}</option>`);
                    });


                    $('select[name="status"]')
                        .html(
                            `<option value="1">Choose One</option>`+
                            `<option value="1" ${response.data.load.status == 1 ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data.load.status== 2 ? 'selected' : ''}>In-Active</option>`
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



    $('#addLoadTypeForm').on('submit', function(e) {
        e.preventDefault();


        if($('input[name=hidden_wh_id_load_type]').val()==0){
            toastr.error('Please add ware house info first');
        return true;
        }

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
            success: function(data) {


                if (data.status==true) {
                    getLoadTypeAccordingWareHouse(data.data.wh_id);
                    toastr.success(data.message);
                    $('#addLoadTypeForm')[0].reset();
                    $('.btn-close').click();
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);

                }
                if (data.status==false) {
                    toastr.error(data.message);
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
                }
            },

            complete: function(data) {
                $(".btn-submit").html("Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {;
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });

    $('#loadTypeModal').modal({
        backdrop: 'static',
        keyboard: false
    })

    $('#addDockInfo').on('submit', function(e) {
        e.preventDefault();


        if($('input[name=id]').val()==0){
            toastr.error('Please add ware house info first');
            return true;
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'JSON',

            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn-submit').text('Saving...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(data) {

                if (data.status==true) {
                    getDockList(data.data.wh_id);
                    toastr.success(data.message);

                    $('.btn-dock-close').click();
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);

                }
                if (data.status==false) {
                    toastr.error(data.message);
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
                }
            },

            complete: function(data) {
                $(".btn-submit").html("Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {;
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });


    getDockList($('input[name=id]').val());

    function getDockList(whId){

        if(whId==0){
            return true;
        }

        $.ajax({
            url:route('admin.wh.dock.list'),
            type: 'GET',
            async: false,
            dataType: 'json',
            data:{wh_id:whId},
            success: function(response) {

                if(response.status) {
                    var html = '';
                    $.each(response.data, function (key, row) {
                        html += '<tr>' +
                            '<td>' + row.loadType + '</td>' +
                            '<td>' + row.title + '</td>' +
                            '<td>' + row.slot + '</td>' +
                            '<td>' + row.schedule_limit + '</td>' +
                            '<td>' + row.schedule_cancel + '</td>' +
                            '<td>';
                        if (row.status == "Active") {
                            html +='<span class="badge badge-soft-success text-uppercase">Active</span>';
                        } else  {
                            html +='<span class="badge badge-soft-danger text-uppercase">InActive</span>';
                        }

                        html +='</td>' +
                            '<td>' +
                            '<a href="#" class="btn-edit-dock"  data="'+ row.id + '"  data-bs-toggle="modal" data-bs-target="#dockModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>' +
                            '<a href="#" class="btn-delete-dock"  data="' + row.id + '"  data-bs-toggle="modal" data-bs-target="#deleteDockModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>' +
                            '</td>' +
                            '</tr>';
                    });
                    $('#dockTable').html(html);
                }else{
                    $('#dockTable').html('');
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
    }


    $('#assignFieldsForm').on('submit', function(e) {
        e.preventDefault();

        if($('input[name=hidden_wh_id_fields]').val()==0){
            toastr.error('Please add ware house info first');
            return true;
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn-submit').text('Saving...');
                $(".btn-submit").prop("disabled", true);
            },
            success: function(data) {

                if (data.status==true) {
                    getAssignedFieldsList(data.data.wh_id);

                    toastr.success(data.message);
                    //$('#assignFieldsForm')[0].reset();
                    $('.btn-close').click();
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);

                }
                if (data.status==false) {
                    toastr.error(data.message);
                    $('.btn-submit').text('Save');
                    $(".btn-submit").prop("disabled", false);
                }
            },

            complete: function(data) {
                $(".btn-submit").html("Save");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {;
                $('.btn-submit').text('Save');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });

    getAssignedFieldsList($('input[name=hidden_wh_id_fields]').val());
    function getAssignedFieldsList(whId){

        if(whId==0){
            return true;
        }

        $.ajax({
            url: route('admin.wh.assign.fields.list'),
            type: 'GET',
            async: false,
            dataType: 'json',
            data:{wh_id:whId},
            success: function(response) {

                if(response.status) {
                    var html = '';
                    $.each(response.data, function (key, row) {

                        html += '<tr>' +
                            '<td>' + row.custom_fields.label + '</td>' +
                            '<td>' + row.custom_fields.place_holder + '</td>' +
                            '<td>' + row.custom_fields.description + '</td>' +


                            '<td>';
                        if (row.status == "Active") {
                            html +='<span class="badge badge-soft-success text-uppercase">Active</span>';
                        } else  {
                            html +='<span class="badge badge-soft-danger text-uppercase">InActive</span>';
                        }

                        html +='</td>' +
                            '<td>' +
                            '<a href="#" class="btn-edit-fields"  data="' + row.id + '"  data-bs-toggle="modal" data-bs-target="#customFieldModal"><i class="ri-pencil-fill text-primary fs-4"></i></a>' +
                            '<a href="#" class="btn-delete-fields"  data="' + row.id + '"  data-bs-toggle="modal" data-bs-target="#deleteAssignedFieldsModal"><i class="ri-delete-bin-fill text-danger fs-4"></i></a>' +
                            '</td>' +
                            '</tr>';
                    });
                    $('#fieldsTable').html(html);
                }
                else{
                    toastr.error('Record not exist');
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
    }

    function loadTypeForMultiSelect(loadTypeData){

        var html = '';
        html += '<select  class="form-select" data-choices data-choices-removeItem multiple id="loadTypeDropdown" required data-trigger  name="load_type_id[]">' +
            '<option value="">Choose One</option>';

        $.each(loadTypeData, function (key, row) {
            let isSelected = '';
                if(editLoadTypeId.length > 0) {
                    const foundObject = editLoadTypeId.find(item => item.id === row.id);
                    if (foundObject != undefined) {
                        isSelected = 'selected';
                    }
                }
            html += '<option value="' + row.id + '" ' + isSelected + '>' + row.direction.value + '(' + row.operation.value + ',' + row.duration + ' Minutes)</option>';
        });

        html +='</select>';
        $('#loadTypeSelectBoxDropdown').html(html);
        initLoadTypeDropdown();
    }
    function initLoadTypeDropdown(){

        new Choices('#loadTypeDropdown', {
            removeItemButton: true,
        });
    }

    // Edit Dock
    $('#dockTable').on('click', '.btn-edit-dock', function() {

        var dockId = $(this).attr('data');

        $.ajax({
            url:route('admin.dock.edit',{id:dockId}),
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {

                editLoadTypeId=response.data.dock_load_types;
                getLoadTypeAccordingWareHouse(response.data.wh_id);


                if(response.status==true){

                    $('input[name=hidden_wh_id_dock]').val(response.data.wh_id);

                    $('input[name=hidden_dock_id]').val(dockId);
                    $('input[name=doc_title]').val(response.data.title);
                    $('input[name=slot]').val(response.data.slot);
                    $('input[name=reschedule_before]').val(response.data.cancel_before);

                    $('#dockStatus')
                        .html(
                            `<option value="" >Choose One</option>`+
                            `<option value="1" ${response.data.status == 'Active' ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data.status== 'InActive' ? 'selected' : ''}>In-Active</option>`
                        )

                    $('select[name="schedule_limit"]')
                        .html( `<option value="" >Choose One</option>`+
                            `<option value="1" ${response.data.schedule_limit == 1 ? 'selected' : ''}>One</option>`+
                                `<option value="2" ${response.data.schedule_limit == 2 ? 'selected' : ''}>Two</option>`+
                                `<option value="3" ${response.data.schedule_limit == 3 ? 'selected' : ''}>Three</option>`+
                                `<option value="4" ${response.data.schedule_limit == 4 ? 'selected' : ''}>Four</option>`+
                                `<option value="5" ${response.data.schedule_limit == 5 ? 'selected' : ''}>Five</option>`+
                               ` <option value="6" ${response.data.schedule_limit == 6 ? 'selected' : ''}>Six</option>`+
                                `<option value="7" ${response.data.schedule_limit == 7 ? 'selected' : ''}>Seven</option>`+
                                `<option value="8" ${response.data.schedule_limit == 8 ? 'selected' : ''}>Eight</option>`+
                                `<option value="9" ${response.data.schedule_limit == 9 ? 'selected' : ''}>Nine</option>`+
                                `<option value="10" ${response.data.schedule_limit == 10 ? 'selected' : ''}>Ten</option>`+
                                `<option value="11" ${response.data.schedule_limit == 11 ? 'selected' : ''}>Eleven</option>`+
                                `<option value="12" ${response.data.schedule_limit == 12 ? 'selected' : ''}>Twelve</option>`+
                                `<option value="13" ${response.data.schedule_limit == 13 ? 'selected' : ''}>Thirteen</option>`+
                                `<option value="14" ${response.data.schedule_limit == 14 ? 'selected' : ''}>Fourteen</option>`+
                                `<option value="15" ${response.data.schedule_limit == 15 ? 'selected' : ''}>Fifteen</option>`+
                                ` <option value="16" ${response.data.schedule_limit == 16 ? 'selected' : ''}>Sixteen</option>`+
                                `<option value="17" ${response.data.schedule_limit == 17 ? 'selected' : ''}>Seventeen</option>`+
                                `<option value="18" ${response.data.schedule_limit == 18 ? 'selected' : ''}>Eighteen</option>`+
                                ` <option value="19" ${response.data.schedule_limit == 19 ? 'selected' : ''}>Nineteen</option>`+
                                `<option value="20" ${response.data.schedule_limit == 20 ? 'selected' : ''}>Twenty</option>`+
                                `<option value="21" ${response.data.schedule_limit == 21 ? 'selected' : ''}>Twenty One</option>`+
                                `<option value="22" ${response.data.schedule_limit == 22 ? 'selected' : ''}>Twenty Two</option>`+
                                `<option  value="23" ${response.data.schedule_limit == 23 ? 'selected' : ''}>Twenty Three</option>`+
                                `<option value="24" ${response.data.schedule_limit == 24 ? 'selected' : ''}>Twenty Four</option>`+
                                `<option value="25" ${response.data.schedule_limit == 25 ? 'selected' : ''}>Twenty Five</option>`+
                                `<option value="26" ${response.data.schedule_limit == 26 ? 'selected' : ''}>Twenty Six</option>`+
                                `<option value="27" ${response.data.schedule_limit == 27 ? 'selected' : ''}>Twenty Seven</option>`+
                                `<option value="28" ${response.data.schedule_limit == 28 ? 'selected' : ''}>Twenty Eight</option>`+
                                `<option value="29" ${response.data.schedule_limit == 29 ? 'selected' : ''}>Twenty Nine</option>`+
                                `<option value="30" ${response.data.schedule_limit == 30 ? 'selected' : ''}>Thirty</option>`
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


    // Edit Fileds
    $('#fieldsTable').on('click', '.btn-edit-fields', function() {

        var assignFieldId = $(this).attr('data');


        $.ajax({
            url: route('admin.wh.assign.fields.edit',{id:assignFieldId}),
            type: 'GET',
            async: false,
            dataType: 'json',

            success: function(response) {


                editAssignedFieldId=response.data['assignedFields'].field_id;
                customFieldsForMultiSelect(response.data['customFields']);


                if(response.status==true){

                    $('input[name=hidden_assigned_field_id]').val(assignFieldId);
                    $('input[name=hidden_wh_id_fields]').val(response.data['assignedFields'].wh_id);

                    $('select[name="status"]')
                        .html(
                            `<option value="">Choose One</option>`+
                            `<option value="1" ${response.data['assignedFields'].status == 'Active' ? 'selected' : ''}>Active</option>`+
                            `<option value="2" ${response.data['assignedFields'].status== 'In-Active' ? 'selected' : ''}>In-Active</option>`
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


    // Multi Select Custom Fields
    function customFieldsForMultiSelect(fieldsData){


        var html = '';
        html += '<select  class="form-select" data-choices data-choices-removeItem multiple id="customFieldDropdown" required data-trigger  name="field_id[]">' +
            '<option value="">Choose One</option>';

        $.each(fieldsData, function (key, row) {

            let isSelected = '';
            if (editAssignedFieldId > 0 && editAssignedFieldId == row.id) {
                isSelected = 'selected';
            }
            html += '<option value="' + row.id + '" ' + isSelected + '>' + row.label + '(' + row.place_holder +')</option>';
        });


        html +='</select>';


        $('#defaultCustomFieldDropDown').html(html);
        initFieldsForMultiSelect();
    }
    function initFieldsForMultiSelect(){

        new Choices('#customFieldDropdown', {
            removeItemButton: true,
        });
    }
    getAllCustomFields();
    function getAllCustomFields(){

        $.ajax({
            url:route('admin.custom.field.list'),
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {

                if(response.status) {
                    customFieldsForMultiSelect(response.data);
                }
                else{
                    toastr.error('Record not exist');
                }
            },
            error: function(xhr, status, error) {
                if(xhr.responseText){
                    //toastr.error(xhr.responseText);
                }
                if(xhr.responseJSON.message){
                    //toastr.error(xhr.responseJSON.message);
                }
            }
        });
    }


    $('#fieldsTable').on('click', '.btn-delete-fields', function() {
        var id = $(this).attr('data');
        $('.confirm-delete-assigned-fields').val(id);
    });
    $('.confirm-delete-assigned-fields').click(function() {
        var id = $(this).val();

        $.ajax({
            url:route('admin.wh.assign.fields.delete',{id:id}),
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            async: false,
            dataType: 'json',
            success: function(response) {

                if (response.status==true) {
                    getAssignedFieldsList(response.data.wh_id);
                    $('.btn-close').click();
                    toastr.success(response.message);

                }
                if (response.status==false) {
                    toastr.error(response.message);

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
    $('#loadTypeTable').on('click', '.btn-delete-load', function() {
        var id = $(this).attr('data');
        $('.confirm-delete-load').val(id);
    });
    $('.confirm-delete-load').click(function() {
        var id = $(this).val();
        $.ajax({
            url:route('admin.load.delete',{id:id}),
            type: 'get',
            async: false,
            dataType: 'json',
            success: function(response) {

if(response.status) {
    getLoadTypeAccordingWareHouse($('input[name=id]').val());
    $('.btn-close').click();
    toastr.success(response.message);
}
                if(!response.status) {
                    toastr.error(response.message);
                }

            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                toastr.success(error);

            }
        });
    });


// delte dock
    $('#dockTable').on('click', '.btn-delete-dock', function() {
        var id = $(this).attr('data');
        $('.confirm-delete-dock').val(id);
    });
    $('.confirm-delete-dock').click(function() {
        var id = $(this).val();

        $.ajax({
            url:route('admin.dock.delete',{id:id}),
            type: 'get',
            async: false,
            dataType: 'json',
            success: function(response) {

                getDockList($('input[name=id]').val());
                $('.btn-close').click();
                toastr.success(response.message);

            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                toastr.success(error);

            }
        });
    });


    $('.btn-dock-close').click(function() {
        resetDock();
    });
    function resetDock() {
        $('#addDockInfo').find('input').val('');
        $('#addDockInfo').find('option').prop('selected', false);
        $('input[name=hidden_dock_id]').val(0);
        $('input[name=hidden_wh_id_dock]').val($('input[name=id]').val());

    }


    function resetLoadTypeForm() {

        $('#addLoadTypeForm')[0].reset();
        $('#addLoadTypeForm').find('option').prop('selected', false);
        $('input[name=hidden_wh_id_load_type]').val($('input[name=id]').val());

            // $('select[name="direction"]').find('option').prop('selected', false);

    }

    //btn-filed-close
    $('.btn-filed-close').click(function() {
        resetFieldForm();
    });

    function resetFieldForm() {
        $('#assignFieldsForm').find('input').val('');
        $('#assignFieldsForm').find('option').prop('selected', false);
        $('input[name=hidden_assigned_field_id]').val(0);
        $('input[name=hidden_wh_id_fields]').val($('input[name=id]').val());

    }

});


