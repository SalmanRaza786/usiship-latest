

$(document).ready(function(){




    $('#filter').on('click', function() {
        $('#roleTable').DataTable().ajax.reload();
    });


    $('#roleTable').on('click', '.btn-assign', function() {
        $('input[name=w_order_id]').val($(this).attr('data'));
    });

    $('#AssignForm').on('submit', function(e) {
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
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);
                    $('.btn-close').click();
                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-submit").html("Assign Picker");
                $(".btn-submit").prop("disabled", false);
            },

            error: function() {
                $('.btn-submit').text('Assign Picker');
                $(".btn-submit").prop("disabled", false);
            }
        });
    });

    $('.btn-import').click(function() {

        $.ajax({
            url: 'import-work-orders',
            method: 'GET',
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.btn-import').text('Importing Order From WHMS wait...');
                $(".btn-import").prop("disabled", true);
            },
            success: function(response) {

                if (response.status==true) {
                    $('#roleTable').DataTable().ajax.reload();
                    toastr.success(response.message);

                }
                if (response.status==false) {
                    toastr.error(response.message);
                }
            },

            complete: function(data) {
                $(".btn-import").html("Import WMS Orders");
                $(".btn-import").prop("disabled", false);
            },

            error: function(a,b,error) {
                $('.btn-import').text('Import WMS Orders');
                $(".btn-import").prop("disabled", false);
                toastr.error(error);
            }
        });
    })

//code for operational hours
    let currentIndex = 0;
    let data = '';
    $('#roleTable').on('click', '.btn-schedule', function() {
        var loadTypeId = $(this).attr('data');
        fnGetDockWiseOperationalHours(1,loadTypeId);
    });
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
        console.log("slotDate",slotDate);
        $('input[name="opra_id"]').val(opId);
        $('input[name="order_date"]').val(slotDate);
        $('.btn-oprational-hour').removeClass('btn-dark').addClass('btn-outline-dark');
        $(this).removeClass('btn-outline-dark').addClass('btn-dark');
    });




});


