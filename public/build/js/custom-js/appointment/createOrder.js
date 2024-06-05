
var allwarehouseList = '';
showLoader();
getWarehouselist()
//get Warehouse data
function getWarehouselist(){
    $.ajax({
        url:route('wh.list.all'),
        type: 'GET',
        async: false,
        dataType: 'json',
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            if(response.status) {
                allwarehouseList = response.data;
                displayWareHouseData(response.data);
            }
            else{
                toastr.error('Record not exist');
            }
        },
        complete: function(data) {
          hideLoader();
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
function displayWareHouseData(data) {
    var html = '';
    if (data.length > 0) {
        $.each(data, function (key, row) {
            html += '<div class="col-md-6 col-lg-12">' +
                '<div class="card mb-0">' +
                '<div class="card-body">' +
                '<div class="d-lg-flex align-items-center">' +
                '<a class="d-flex" type="button" data-bs-toggle="collapse" data-bs-target="#accor_iconExamplecollapse' + key + '" aria-expanded="true" aria-controls="accor_iconExamplecollapse' + key + '">' +
                '<div class="flex-shrink-0">' +
                '<div class="avatar-sm rounded">' +
                '<div class="avatar-title border bg-light text-primary rounded text-uppercase fs-16">WH</div>' +
                '</div>' +
                '</div>' +
                '<div class="ms-lg-3 my-3 my-lg-0">' +
                '<a href="#">' +
                '<h5 class="fs-16 mb-2">' + row.title + '</h5>' +
                '</a>' +
                '<p class="text-muted mb-0">' + row.note + '</p>' +
                '</div>' +
                '<div class="d-flex gap-4 mt-0 text-muted mx-auto">' +
                '<a href="#"><i class="ri-map-pin-2-line text-primary me-1 align-bottom"></i>' + row.address + '</a>' +
                '</div>' +
                '<div class="d-flex flex-wrap gap-2 align-items-center mx-auto my-3 my-lg-0">' +
                '<div class="text-muted">' + row.phone + '</div>' +
                '</div>' +
                '</a>' +
                '<div>' +
                '<button type="button" data-value="' + row.id + '"  class="btn btn-soft-success btn-appointment nexttab btn-label right ms-auto nexttab" data-nexttab="pills-bill-address" whName="'+row.title+'" whAddress="'+row.address+'">Book Appointment</button>' +
                '<a href="#!" class="btn btn-ghost-danger btn-icon custom-toggle active" data-bs-toggle="button">' +
                '<span class="icon-on"><i class="ri-bookmark-line align-bottom"></i></span>' +
                '<span class="icon-off"><i class="ri-bookmark-3-fill align-bottom"></i></span>' +
                '</a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="accordion" id="accordionWithicon">' +
                '<div class="accordion-item">' +
                '<div id="accor_iconExamplecollapse' + key + '" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample' + key + '" data-bs-parent="#accordionWithicon">' +
                '<div class="accordion-body">' +
                '<h6 class="fs-14 mb-1">' + row.email + ' <small class="badge bg-danger-subtle text-danger">' + row.title + '</small></h6>' +
                '<p class="text-muted">' + row.note + '</p>' +
                '<ul class="list-unstyled vstack gap-2 mb-0">'+
                '<li>' +
                '<div class="d-flex">' +
                '<div class="flex-grow-1">' +
                '<h5 class="fs-14 mb-3">Operating hours</h5>'+
                '<div class="table-card">' +
                '<div class="col-lg-4">' +
                '<table class="table mb-0">' +
                '<tbody>' ;
            if (row.wh_working_hours.length > 0) {
                $.each(row.wh_working_hours, function (index, activity) {
                    html +=  '<tr>' +
                        '<td class="fw-medium text-uppercase">' + activity.day_name + '</td>';
                    if (activity.opration_hours_from.length > 0) {
                        $.each(activity.opration_hours_from, function (index, workFrom) {
                            html += '<td>From: ' + workFrom.working_hour + '</td>';
                        });
                    }
                    if (activity.opration_hours_to.length > 0) {
                        $.each(activity.opration_hours_to, function (index, workTo) {
                            html += '<td>To: ' + workTo.working_hour + '</td>';
                        });
                    }
                    html += '</tr>';

                });
            }

            html +=  '</tbody>' +
                '</table>' +
                '</div>'+
                '</div>' +
                '</div>' +
                '</div>' +
                '</li>'+
                '</ul>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        });
    } else {
        html += '<div class="col-md-6 col-lg-12">' +
            '<div class="card mb-0">' +
            '<div class="card-body">' +
            '<div class="noresult" style="display: block;">'+
                '<div class="text-center">'+
                    '<lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"  colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>'+
                    '<h5 class="mt-2">Sorry! No Result Found</h5>'+
                    '<p class="text-muted mb-0"> We did not find any warehouse for your search.</p>'+
                '</div>'+
            '</div>'+
        '</div>' +
        '</div>' +
        '</div>';
    }

    $('#warehouse-list').html(html);
}
function showLoader(){
    $('#myCustomPreLoader').css('display', 'block');
}
function hideLoader(){
    $('#myCustomPreLoader').css('display', 'none');
}

// Search list
var searchElementList = document.getElementById("searchJob");
searchElementList.addEventListener("keyup", function () {
    var inputVal = searchElementList.value.toLowerCase();
    function filterItems(arr, query) {
        return arr.filter(function (el) {
            return el.title.toLowerCase().indexOf(query.toLowerCase()) !== -1 || el.address.toLowerCase().indexOf(query.toLowerCase()) !== -1
        })
    }
    var filterData = filterItems(allwarehouseList, inputVal);
    displayWareHouseData(filterData);
});
$('.btn-appointment').on('click', function() {

    var whId = $(this).data('value');
    var whAddress = $(this).attr('whAddress');
    var whName = $(this).attr('whName');
     $('#wh_name').text(whName);
     $('#wh_address').text(whAddress);
    $('input[name="wh_id"]').val(whId);

     getLoadTypeAccordingWareHouse(whId);
     getWhFormFields(whId);

     //next tab
    let nextTabId = $(this).attr("data-nexttab");
    let nextTabButton = document.querySelector(`[data-bs-target="#${nextTabId}"]`);
    if (nextTabButton) {
        nextTabButton.click();
    }

    });
function getLoadTypeAccordingWareHouse(whId){
    $.ajax({
        url: route('wh.loadType.list'),
        type: 'GET',
        async: false,
        dataType: 'json',
        data:{wh_id:whId},
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            if(response.status) {
                var html = '';
                var noresult = '';
                if (response.data.length > 0) {
                $.each(response.data, function (key, row) {
                    html += '<tr>' +
                        '<td>' + row.direction.value + '</td>' +
                        '<td>' + row.operation.value + '</td>' +
                        '<td>' + row.eq_type.value + '</td>' +
                        '<td>' + row.trans_mode.value + '</td>' +
                        '<td> <button type="button" data-value="' + row.id + '" class="btn btn-sm btn-success btn-dock" data-nexttab="pills-dock">Select</button></td>'+
                        '</tr>';
                });
                } else {
                    noresult += '<div class="col-md-6 col-lg-12">' +
                        '<div class="card mb-0">' +
                        '<div class="card-body">' +
                        '<div class="noresult" style="display: block;">'+
                        '<div class="text-center">'+
                        '<lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"  colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>'+
                        '<h5 class="mt-2">Sorry! No Result Found</h5>'+
                        '<p class="text-muted mb-0"> We did not find any loadtype for your search.</p>'+
                        '</div>'+
                        '</div>'+
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                $('#loadTypeTable').html(html);
                $('#noresult').html(noresult);
            }
            else{
                toastr.error('Record not exist');
            }
        },
        complete: function(data) {
            hideLoader();
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
$('#loadTypeTable').on('click', '.btn-dock', function(){
    var loadTypeId = $(this).data('value');
    getDockAccordingLoadType(loadTypeId);
    let nextTabId = $(this).attr("data-nexttab");
    let nextTabButton = document.querySelector(`[data-bs-target="#${nextTabId}"]`);
    if (nextTabButton) {
        nextTabButton.click();
    }
});
function getDockAccordingLoadType(loadTypeId){

    var whId=$('input[name="wh_id"]').val();

    $.ajax({
        url: route('appointment.loadType.dock.list'),
        type: 'GET',
        async: false,
        dataType: 'json',
        data:{loadtype:loadTypeId,whId:whId},
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {

            if(response.status) {
                $('input[name="load_type_id"]').val(loadTypeId);
                var html = '';
                if(response.data.length > 0){
                    $.each(response.data, function (key, row) {

                        html += ' <div class="col-xxl-4 col-lg-6 ">' +
                            '<div class="card card-body cardBody">' +
                            '  <h4 class="card-title" data-sider-select-id="0b14ace8-c9a5-452b-98e3-796ee4aa81c4">'+row.dock.title+'</h4>' +
                            '  <span class="card-title" data-sider-select-id="0b14ace8-c9a5-452b-98e3-796ee4aa81c4">Duration:'+row.load_type.duration + ' Minutes</span>' +
                            ' <button type="button" data-value="' + row.dock.id + '"  class="btn btn-primary btn-select-dock" data-nexttab="pills-payment">Select Dock</button>' +
                            '</div>' +
                            '</div>';

                    });
                } else {
                    html += '<div class="col-md-6 col-lg-12">' +
                        '<div class="card mb-0">' +
                        '<div class="card-body">' +
                        '<div class="noresult" style="display: block;">'+
                        '<div class="text-center">'+
                        '<lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"  colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>'+
                        '<h5 class="mt-2">Sorry! No Result Found</h5>'+
                        '<p class="text-muted mb-0"> We did not find any Dock for you.</p>'+
                        '</div>'+
                        '</div>'+
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                $('#dock-list').html(html);
            }
            else{
                toastr.error('Record not exist');
            }
        },
        complete: function() {
            hideLoader();
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
$('#dock-list').on('click', '.btn-select-dock', function(){

    var dockID = $(this).data('value');
    const loadTypeId=$('input[name="load_type_id"]').val();
    fnGetDockWiseOperationalHours(dockID,loadTypeId)
    $('input[name="dock_id"]').val(dockID);



    $('.cardBody').removeClass('bg-success text-white');
   $('.card-title').removeClass('text-white');
    $(this).closest('.cardBody').addClass('bg-success text-white');
   $(this).closest('.cardBody').find('.card-title').addClass('text-white');



    let nextTabId = $(this).attr("data-nexttab");
    let nextTabButton = document.querySelector(`[data-bs-target="#${nextTabId}"]`);
    if (nextTabButton) {
        nextTabButton.click();
    }





});
function getWhFormFields(whId){

    $.ajax({
        url: route('wh.fields'),
        type: 'GET',
        async: false,
        dataType: 'json',
        data:{wh_id:whId},
        beforeSend: function() {
            showLoader();
        },
        success: function(response) {
            if(response.status) {
                showFormFields(response.data);

            }

        },
        complete: function(data) {
            hideLoader();
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
function showFormFields(data) {
    var html = '';
    if (data.length > 0) {
        $.each(data, function (key, row) {
            html += '<div class="row mb-3">' +
                '<div class="col-lg-4">' +
                '<label for="nameInput" class="form-label">' + row.custom_fields.label + '</label>' +
                '</div>' +
                '<div class="col-lg-8">' +
                '<input type="'+row.custom_fields.input_type+'" class="form-control" name="customfield[' + row.field_id + ']"  placeholder="'+row.custom_fields.place_holder+'" '+(row.custom_fields.require_type == 'Yes' ? 'required' : '')+' />'+
                '</div>'+
                '</div>';
        });
    }
    $('#detail-form').html(html);
}

//code for operational hours
let currentIndex = 0;
let data = '';

function fnGetDockWiseOperationalHours(dockId,loadTypeId) {

    $.ajax({
        url: route('dock.hours.list'),
        type: 'GET',
        async: false,
        dataType: 'json',
        data:{dockId:dockId,loadTypeId:loadTypeId},
        success: function(response) {

             data =response.data;
             ShowOperationHours(response.data,currentIndex);

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

function showNextWeek() {
    if (currentIndex + 7 < data.length) {
        currentIndex += 7;
        ShowOperationHours(data, currentIndex);
    }
}
function showPreviousWeek() {
    if (currentIndex - 7 >= 0) {
        currentIndex -= 7;
        ShowOperationHours(data, currentIndex);
    }
}
$('#next-week').click(showNextWeek);
$('#prev-week').click(showPreviousWeek);
function ShowOperationHours(data,startIndex)
{


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
            cardBody.append('<div class="time-slot"><button type="button" slotDate="' + daySchedule.date + '"  data-value="' + slot.id + '" data-nexttab="pills-finish"  class="btn btn-outline-dark btn-block btn-oprational-hour">' + slot.working_hour + '</button></div>');

            });
        } else {
            cardBody.append('<div class="availability">No availability</div>');
        }

        container.append(card);

    }

}
//end code for operational hours
$('#dates-container').on('click', '.btn-oprational-hour', function(){
    var opId = $(this).data('value');
    var slotDate = $(this).attr('slotDate');
    $('input[name="opra_id"]').val(opId);
    $('input[name="order_date"]').val(slotDate);
    $('.btn-oprational-hour').removeClass('btn-dark').addClass('btn-outline-dark');
    $(this).removeClass('btn-outline-dark').addClass('btn-dark');

    let nextTabId = $(this).attr("data-nexttab");
    let nextTabButton = document.querySelector(`[data-bs-target="#${nextTabId}"]`);
    if (nextTabButton) {
        nextTabButton.click();
    }
});

$('#OrderForm').on('submit', function(e) {
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
                    var html = " ";


            if (response.status==true) {
                toastr.success(response.message);
                $('#OrderForm')[0].reset();
                html +='<div class="text-center py-5">'+
                    '<div className="mb-4">'+
                    '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>'+
                '</div>'+
                '<h5>Thank you ! Your Order is Completed !</h5>'+
                '<p className="text-muted">You will receive an order confirmation email with details of your order.</p>'+
                '<h3 className="fw-semibold">Order ID: <a  className="text-decoration-underline">'+response.data.order_id+'</a></h3>'+
                    '<button type="button" class="btn btn-primary btn-upload"   data="'+response.data.id+'" data-bs-toggle="modal" data-bs-target="#showModalUpoad">Upload Packaging List</button> '+
                    '</div>';
                $('#congratsMessege').html(html);
                $('.btn-back').addClass('d-none');

            }
            if (response.status == false) {
                toastr.error(response.message);
            }

        },

        complete: function (data) {
            $(".btn-submit").html("Confirm Appointment");
            $(".btn-submit").prop("disabled", false);
        },

        error: function () {
            // toastr.error('something went wrong');
            $('.btn-submit').text('Confirm Appointment');
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

$('#congratsMessege').on('click', '.btn-upload', function() {
    var id = $(this).attr('data');
    $('input[name="id"]').val(id);
});


