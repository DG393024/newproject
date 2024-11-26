  
$(document).ready(function() {
    $("#user-form").validate({
        rules: {
            name: {required: true},
             email: {required: true,email: true},
             phone: {required: true},
            role_id: {required: true},
            description: {required: true},
             profile_image: {required: true}
        },
        messages: {
            name: {required: "Please enter name."},
            role_id: {required: "Please select a role."},
            email: {required: "Please enter email.",email: "Please enter valid email."},
            phone: {required: "Please enter phone.",number: "Please enter valid phone."},
            description: {required: "Please enter description."},
            profile_image: {required: "Please upload a profile picture."}
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);  // Insert error message after the element
        },
        submitHandler: function(form, event){
            event.preventDefault();
            $('#user-form input, #user-form select').on('input change', function() {
                $(this).next('.error-message').remove();
            });

            var formData = new FormData(form);
            $.ajax({
                url: USER_SAVE_URL,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    if(response.status == 'error'){
                        $.each(response.errors, function(field, messages) {
                            // Remove any existing error message for the field
                            $("#" + field).next('.error-message').remove();
                            // Append the error message after the relevant input field
                            $("#" + field).after('<span class="error-message" style="color: red;">' + messages[0] + '</span>');
                        });
                    } else{
                        $('form#user-form').trigger("reset"); // form reset
                        $('form#user-form select').trigger("change"); //select change
                        $("#user_table").html(response.userTableView);
                    }
                }
            });
        }
    });
});