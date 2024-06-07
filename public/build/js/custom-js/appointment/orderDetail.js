


$(document).ready(function(){


    $('.btn-action').click(function() {

    $('.btn-confirm-order').val($(this).attr('data'));
    $('#confirmText').text($(this).attr('btn-text'));
    $('.tab-carrier').click();

    });


    $('.btn-confirm-order').click(function() {

        const statusId = $(this).val();
        const orderId=$('input[name=order_id]').val();
        alert(orderId);

        $.ajax({
            url: route('admin.change.order.status',{orderId:orderId,orderStatus:statusId}),
            method: 'GET',
            dataType: 'JSON',
            cache:false,
            processData: false,
            beforeSend: function(data) {
                $(".btn-confirm-order").text('Processing');
                $(".btn-confirm-order").prop("disabled", true);
            },
            success: function(response) {
                if (response.status) {
                    $('input[name=current_status_id]').val(statusId);
                    checkOrderStatus();
                    $('.btn-close').click();
                    toastr.success(response.message);


                }
            },

            complete: function(data) {

                $(".btn-confirm-order").text('Yes');
                $(".btn-confirm-order").prop("disabled", false);
            },

            error: function(err) {

                //toastr.error(err.responseJSON.message);
            }
        });
    });


    checkOrderStatus()
    function checkOrderStatus(){
       const currentStatusId= $('input[name=current_status_id]').val();


       if(currentStatusId==6){

           $('.recv-package-section').addClass('d-none');
           $('.completed-section').addClass('d-none');
           $('.progress-section').addClass('d-none');
           $('.rejected-section').addClass('d-none');
           $('.accepted-section').addClass('d-none');
           $('.requested-section').removeClass('d-none');
           $('.arrived-section').addClass('d-none');
           $('.requested-package-section').addClass('d-none');
       }

        if(currentStatusId==1){
            $('.recv-package-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').removeClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
        }

        if(currentStatusId==2){

            $('.recv-package-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').removeClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
        }

        if(currentStatusId==8){

            $('.recv-package-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.requested-package-section').removeClass('d-none');

        }

        if(currentStatusId==9){

            $('.recv-package-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
            $('.arrived-section').removeClass('d-none');
        }

        if(currentStatusId==3){

            $('.recv-package-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.progress-section').removeClass('d-none');
        }

        if(currentStatusId==10){
            $('.recv-package-section').addClass('d-none');
            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.completed-section').removeClass('d-none');
        }


        if(currentStatusId==11){

            $('.requested-section').addClass('d-none');
            $('.accepted-section').addClass('d-none');
            $('.rejected-section').addClass('d-none');
            $('.requested-package-section').addClass('d-none');
            $('.arrived-section').addClass('d-none');
            $('.progress-section').addClass('d-none');
            $('.completed-section').addClass('d-none');
            $('.recv-package-section').removeClass('d-none');
        }



    }
    $('#orderConfirmModal').modal({
        backdrop: 'static',
        keyboard: false
    })

    $('.btn-undo').click(function() {


        const orderId=$('input[name=id]').val();

        $.ajax({
            url: route('admin.undo.order.status',{orderId:orderId}),
            method: 'GET',
            dataType: 'JSON',
            cache:false,
            processData: false,
            success: function(response) {
                console.log('response',response);
                if (response.status) {
                    $('input[name=current_status_id]').val(response.data);
                    checkOrderStatus();
                    toastr.success(response.message);
                }
            },
            error: function(err) {

                //toastr.error(err.responseJSON.message);
            }
        });
    });


})


