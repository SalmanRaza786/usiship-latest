$(document).ready(function(){


    $('#my-form').on('submit', function(e) {
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
            success: function(data) {

                if (data.status==true) {
                    toastr.success(data.message);

                }
                if (data.status==false) {
                    toastr.error(response.message);

                }
            },

            complete: function(data) {
                $(".btn-submit").html("Save Changes");
                $(".btn-submit").prop("disabled", false);
            },

            error: function(e) {
                toastr.error('error',e);
            }
        });
    });
});
