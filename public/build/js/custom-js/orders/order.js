

$(document).ready(function(){

    $('.wareHouse').change(function() {

        var whId = $('select[name=whId]').val();
        getWareHouseSlots(whId);
        getWhFormFields(whId);

        $.ajax({
            type: 'ajax',
            method: 'get',

            url: route('admin.wh.loadType.list'),
            data:{wh_id:whId},
            async: false,
            dataType: 'json',
            success: function(response) {
                var html = '<option value="">Choose One</option>';
                $.each(response.data, function (key, row) {

                     html += '<option value="' + row.id+'">' + row.direction.value+ '-' + row.operation.value + '-'+  row.eq_type.value +'-' +row.trans_mode.value+'</option>';
                });
                $('#whLoadTypes').html(html);
            },
            error: function() {
                toastr.error('data not found');
            }

        });
    });


    $('.loadType').change(function() {
        var whId = $('select[name=whId]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url:route('admin.wh.dock.list'),
            data:{wh_id:whId},
            async: false,
            dataType: 'json',
            success: function(response) {
                var html = '<option value="">Choose One</option>';
                $.each(response.data, function (key, row) {
                    html += '<option value="' + row.id+'">' + row.title+'</option>';
                });
                $('#whDocks').html(html);
            },
            error: function() {
                toastr.error('data not found');
            }

        });
    });

    function getWareHouseSlots(whId){

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: route('wh.hours.list'),
            data:{wh_id:whId},
            async: false,
            dataType: 'json',
            success: function(response) {
                var html = '<option value="">Choose One</option>';
                // $.each(response.data, function (key, row) {
                //     console.log('row',row);
                //     html += '<option value="' + row.id+'">' + row.direction.value+ '-' + row.operation.value + '-'+  row.eq_type.value +'-' +row.trans_mode.value+'</option>';
                // });
                // $('#whLoadTypes').html(html);
            },
            error: function() {
                toastr.error('data not found');
            }

        });
    }

    function getWhFormFields(whId){

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: route('admin.wh.fields'),
            data:{wh_id:whId},
            async: false,
            dataType: 'json',
            success: function(response) {
                console.log('response form',response.data);
                var html = '';
                $.each(response.data, function (key, row) {
                    html += '<div class="col-6">'+
                        '<div class="mb-3">'+
                        '<label class="form-label">'+row.custom_fields.label+'</label>'+
                        '<input type="'+row.custom_fields.input_type+'" name="field_name[]" placeholder="'+row.custom_fields.place_holder+'" class="form-control">'+
                        '</div>'+
                        ' </div>';
                });
                $('#formFields').html(html);
            },
            error: function() {
                toastr.error('data not found');
            }

        });
    }

});


