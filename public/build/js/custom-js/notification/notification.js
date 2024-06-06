$(document).ready(function(){
    var unreadMessage=0;
    $('#unreadMessage').text(unreadMessage);
    window.Echo.channel("chats").listen("MessageEvent", (event) => {
        console.log(event);
        console.log('abc')

        var notificationHtml='';
        notificationHtml+='<div class="text-reset notification-item d-block dropdown-item position-relative">'+
            '<div class="d-flex">'+
            '<div class="avatar-xs me-3">'+
            '<span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">'+
            '<i class="ri-notification-4-line"></i>'+
            '</span>'+
            '</div>'+
            '<div class="flex-1">'+
            '<a href="#!" class="stretched-link">'+
            '<h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the conversation   </h6>'+

            ' </a>'+
            ' <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">'+
            '<span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>'+
            '</p>'+
            '</div>'+
            '</div>'+
            ' </div>';

        unreadMessage=21;
        $('#unreadMessage').text(unreadMessage);
        $('#notificationArea').html(notificationHtml);
    });

});
