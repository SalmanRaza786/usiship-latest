$(document).ready(function(){

    var customerId=$('meta[name="user_id"]').attr('content');

    $('.notificationCounter').text(0);

    window.Echo.channel("clientNotificationChannel").listen("ClientNotificationEvent", (e) => {


        if(e.notificationData.length > 0){
            $('empty-notification-elem').addClass('d-none');
            fnShowNotifications(e.notificationData,1);
        }else{
            $('empty-notification-elem').removeClass('d-none');
        }


    });

    function fnShowNotifications(notificationData,isShowToast){
        var notificationHtml='';
        $.each(notificationData, function(key, row) {

            if(isShowToast==1) {
                $('.toast').toast('show');
                $('.created-at').text(row.created_at);
                $('.notification-text').text(row.content);
            }

            var url =  route('admin.roles.permissions', ':role_id');

            notificationHtml+='<div class="text-reset notification-item d-block dropdown-item position-relative btn-read-notification" data="'+row.id+'">'+
                '<div class="d-flex">'+
                '<div class="avatar-xs me-3">'+
                '<span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">'+
                '<i class="ri-notification-4-line"></i>'+
                '</span>'+
                '</div>'+
                '<div class="flex-1">'+
                '<a href="'+route(row.url,{ id: row.target_model_id })+'"  class="stretched-link">'+
                // '<h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the conversation   </h6>'+
                '<h6 class="mt-0 mb-2 fs-13 lh-base">'+row.content+'</h6>'+

                ' </a>'+
                ' <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">'+
                '<span><i class="mdi mdi-clock-outline"></i>'+row.created_at+'</span>'+
                '</p>'+
                '</div>'+
                '</div>'+
                ' </div>';

        });
        $('.notificationCounter').text(notificationData.length);
        $('#notificationArea').html(notificationHtml);
    }

    $('#notificationArea').on('click', '.btn-read-notification', function() {

        var id = $(this).attr('data');

        $.ajax({
            url: route('notification.read',{id:id}),
            type: 'GET',
            async: false,
            dataType: 'json',
            success: function(response) {
                //toastr.success('mark as read successfully');
                getUnreadNotifications();
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    });

    getUnreadNotifications();
    function getUnreadNotifications(){

        $.ajax({
            url: route('notification.unread'),
            type: 'GET',
            async: false,
            dataType: 'json',
            data:{type:2,notifiableId:customerId},
            success: function(response) {

                fnShowNotifications(response.data,0);
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    }

    function showToast() {
        var toastHtml = `
            <div class="toast" id="myToast">
                <div class="toast-header">
                    <img src="assets/images/logo-sm.png" class="rounded me-2" alt="..." height="20">
                    <strong class="me-auto">New Order</strong>
                    <small>just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-bg-light">
                    Order ID: 1<br>
                    Customer:'Salman'
                </div>
            </div>
        `;

        var toastContainer = $('#toastPlacement');
        toastContainer.html(toastHtml);
        var toastEl = new bootstrap.Toast($('#myToast'));
        toastEl.show();
        toastEl._element.addEventListener('hidden.bs.toast', function () {
            toastContainer.hide();
        });
    }

    //pusher notification
    var pusher = new Pusher('121222f0a05680423bbe', {
        encrypted: true,
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('clientNotificationChannel');
    channel.bind('App\\Events\\ClientNotificationEvent', function(e) {

        if(e.notificationData[0].notifiType==2 && e.notificationData[0].notifiableId == customerId){
        if(e.notificationData.length > 0){
            $('empty-notification-elem').addClass('d-none');
            fnShowNotifications(e.notificationData,1);
        }
        else{
            $('empty-notification-elem').removeClass('d-none');
        }
        }

    });


    $('.btn-nofify').on('click', function() {
        getUnreadNotifications();
    });


});
