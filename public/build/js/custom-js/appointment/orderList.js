
function editElement(){
    $('.add-lang-title').css('display', 'none');
    $('.edit-lang-title').css('display', 'block');
    $('.btn-save-changes').css('display', 'block');
    $('.btn-add').css('display', 'none');

}
$('#roleTable').on('click', '.btn-edit', function() {

    editElement();
    var id = $(this).attr('data');

    $.ajax({
        url: 'edit-appointment/'+id,
        type: 'GET',
        async: false,
        dataType: 'json',
        data: { id: id },
        success: function(response) {
                console.log('response',response);
            if(response.status==true){
                $('input[name=order_id]').val(response.data.load.id);
                var html = '';
                var baseUrl = "URL::asset('storage')" ;
                if (response.data.load.order_form.length > 0) {
                    $.each(response.data.load.order_form, function (key, row) {
                        html += '<div class="mb-3">'+
                            '<label for="validationCustom01" class="form-label">'+row.custom_fields.label+'</label>'+
                           '<input type="'+row.custom_fields.input_type+'" value="'+row.form_value+'" class="form-control" name="customfield['+row.custom_fields.id+']" id="'+row.custom_fields.id+'" placeholder="'+row.custom_fields.place_holder+'" '+(row.custom_fields.require_type == "Yes"? "required":"" )+'  >'+
                         //   '<input type="'+row.custom_fields.input_type+'" class="form-control" name="customfield[' + row.custom_fields.id + ']"  placeholder="'+row.custom_fields.place_holder+'" '+(row.custom_fields.require_type == 'Yes' ? 'required' : '')+' />'+
                            '</div>';
                    });

                    $('#editForm').html(html);
                }
            }else {
                toastr.error(response.message)
                var html = '<div class="text-center mt-3">'+
                    '<h4>'+response.message+'</h4>'+
                '</div>';
                $('#editForm').html(html);
                $('.btn-submit').addClass('d-none');
            }


        },
        error: function (xhr, status, error) {

            toastr.error(error);
        }
    });
});

var reschedualData = '';
var dataWeek = '';
var currentIndex = 0;
$('#roleTable').on('click', '.btn-reschedule', function() {
    editElement();
    var id = $(this).attr('data');
    getRescheduleHors(id);
});

function getRescheduleHors(id){
    $.ajax({
        url: route('scheduling.edit',{id:id}),
        type: 'GET',
        async: false,
        dataType: 'json',

        success: function(response) {
            console.log(response);
            if(response.status==true){
                reschedualData = response.data;
                dataWeek = response.data.warehouse[0].operationalHours;
                $('input[name="id"]').val(id);
                 ShowOperationHours(reschedualData,currentIndex);
            }else{
                toastr.error(response.message)
                var html = '<div class="text-center mt-3">'+
                    '<h4>'+response.message+'</h4>'+
                    '</div>';
                $('#showErrorMsg').html(html);
                $('#rescheduleContainer').addClass('d-none');
                $('.btn-submit').addClass('d-none');
            }
        },
        error: function(xhr, status, error) {

            toastr.error(error);
        }
    });
}

$('#UpdateForm').on('submit', function(e) {
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
                // $('#UpdateForm')[0].reset();
                 $('#roleTable').DataTable().ajax.reload();
                $('.btn-close').click();
                $('.btn-submit').text('Save Changes');
                $(".btn-submit").prop("disabled", false);
            }
            if (response.status==false) {
                toastr.error(response.message);
            }
        },
        complete: function(data) {
            $(".btn-submit").html("Save Changes");
            $(".btn-submit").prop("disabled", false);
        },
        error: function() {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Save Changes');
            $(".btn-submit").prop("disabled", false);
        }
    });

});
$('#rescheduleForm').on('submit', function(e) {
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
                $('#rescheduleForm')[0].reset();
                $('#roleTable').DataTable().ajax.reload();
                $('.btn-close').click();
                $('.btn-submit').text('Save Changes');
                $(".btn-submit").prop("disabled", false);
                window.location.reload();
            }
            if (response.status==false) {
                toastr.error(response.message);
            }
        },
        complete: function(data) {
            $(".btn-submit").html("Save Changes");
            $(".btn-submit").prop("disabled", false);
        },
        error: function() {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Save Changes');
            $(".btn-submit").prop("disabled", false);
        }
    });

});

$('#uploadForm').on('submit', function(e) {
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
                $('#uploadForm')[0].reset();
                $('.btn-close').click();
                $('.btn-submit').text('Upload');
                $(".btn-submit").prop("disabled", false);
            }
            if (response.status==false) {
                toastr.error(response.message);
            }
        },
        complete: function(data) {
            $(".btn-submit").html("Upload");
            $(".btn-submit").prop("disabled", false);
        },
        error: function() {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Upload');
            $(".btn-submit").prop("disabled", false);
        }
    });

});
$('#PackagingForm').on('submit', function(e) {
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
                $('.btn-submit').text('Submit');
                $(".btn-submit").prop("disabled", false);
            }
            if (response.status==false) {
                toastr.error(response.message);
            }
        },
        complete: function(data) {
            $(".btn-submit").html("Submit");
            $(".btn-submit").prop("disabled", false);
        },
        error: function() {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Submit');
            $(".btn-submit").prop("disabled", false);
        }
    });

});


function ShowOperationHours(dataPerms,startIndex)
{
    var data = dataPerms.warehouse[0].operationalHours;
    var orderDate = dataPerms.order.order_date;
    var orderslot = dataPerms.order.operational_hour_id;

    const startDate = data[0].date;
    const endDate =data[data.length - 1].date;
    const endIndex = Math.min(startIndex + 7, data.length);
    $('#current-week-range').text(`${startDate} - ${endDate}`);
    const container = $('#dates-container');
    container.empty(); // Clear previous content

    for (let i = startIndex; i < endIndex; i++) {
        const daySchedule = data[i];
        const card = $('<div class="col"><div class="card"><div class="card-header text-center"><strong>' + daySchedule.day + '</strong><br>' + daySchedule.date + '</div><div class="card-body"></div></div></div>');
        const cardBody = card.find('.card-body');

        if (daySchedule.availableSlots.length > 0) {
            daySchedule.availableSlots.forEach(slot => {

                cardBody.append('<div class="time-slot"><button type="button" slotDate="'+daySchedule.date+'"  data-value="' + slot.id + '" data-nexttab="pills-finish"  class="'+ ((daySchedule.date == orderDate && slot.id == orderslot)?"btn btn-dark btn-block btn-oprational-hour":"btn btn-outline-dark btn-block btn-oprational-hour") +' ">' + slot.working_hour + '</button></div>');
            });
        } else {
            cardBody.append('<div class="availability">No availability</div>');
        }

        container.append(card);

    }

}
function showNextWeek() {
    if (currentIndex + 7 < reschedualData.warehouse[0].operationalHours.length) {
        currentIndex += 7;
        ShowOperationHours(reschedualData, currentIndex);
    }
}
function showPreviousWeek() {
    if (currentIndex - 7 >= 0) {
        currentIndex -= 7;
        ShowOperationHours(reschedualData, currentIndex);
    }
}
$('#next-week').click(showNextWeek);
$('#prev-week').click(showPreviousWeek);



$('#dates-container').on('click', '.btn-oprational-hour', function(){
    var opId = $(this).data('value');
    var slotDate = $(this).attr('slotDate');
    $('input[name="opra_id"]').val(opId);
    $('input[name="order_date"]').val(slotDate);
    $('.btn-oprational-hour').removeClass('btn-dark').addClass('btn-outline-dark');
    $(this).removeClass('btn-outline-dark').addClass('btn-dark');
});


$('#roleTable').on('click', '.btn-delete', function() {
    var id = $(this).attr('data');
    $('.confirm-delete').val(id);
});


//btn-upload packging list
$('#roleTable').on('click', '.btn-upload', function() {
    var id = $(this).attr('data');
    $('input[name="id"]').val(id);
});


//btn-image-upload packginglist
$('#packagingTable').on('click', '.btn-image-upload', function() {
    var id = $(this).attr('data');
    $('input[name="packging_id"]').val(id);
});

//btn-delete
$('.confirm-delete').click(function() {
    var id = $(this).val();
    $.ajax({
        url: 'cancel-appointment/'+id,
        type: 'get',
        async: false,
        dataType: 'json',
        success: function(response) {
                console.log(response);
            if(response.status==true) {
                toastr.success(response.message);
                $('#roleTable').DataTable().ajax.reload();
                $('.btn-close').click();
            }else {
                toastr.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            var errors = xhr.responseJSON.errors;
            toastr.error(error);

        }
    });
});


//btn-reschedule
$('#btn-reschedule').click(function() {
    var orderId = $('input[name=hidden_order_id]').val();
    getRescheduleHors(orderId);

});
$('#btn-upload_pack_list').click(function() {
    var id = $(this).attr('data');
    $('input[name="id"]').val(id);
    $('#showModalUpoad').modal('show');
});

$('#editOrderButton').on('click', function() {
    $('input').removeAttr('readonly');
    $('#updateButtonArea').removeClass('d-none');
});


