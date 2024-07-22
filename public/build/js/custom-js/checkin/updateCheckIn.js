
$(document).ready(function(){

    $('#UpdateCheckInForm').on('submit', function(e) {

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
                console.log('response',response);
                if (response.status==true) {
                    toastr.success(response.message);
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
                $('.btn-submit').text('Close Arrivals');
                $(".btn-submit").prop("disabled", false);
            }
        });


    });

});


