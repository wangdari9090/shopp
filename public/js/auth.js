$(document).ready(function() {
    const $emailInput = $('input[name="email"]');
    const $errorDiv = $('#email_error');

    $emailInput.on('blur', function() {
        validateEmail();
    });

    // Stop form submission if user presses Enter while in email field
    $emailInput.on('keypress', function(e) {
        if (e.which === 13) { 
            e.preventDefault();
            validateEmail();
        }
    });

    function validateEmail() {
        let email = $emailInput.val();
        let url = $emailInput.data('url');
        let token = $('meta[name="csrf-token"]').attr('content');

        if (!email || !url) return;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                email: email,
                _token: token
            },
            success: function() {
                $errorDiv.text('');
                $emailInput.removeClass('is-invalid').addClass('is-valid');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $emailInput.removeClass('is-valid').addClass('is-invalid');
                    let errors = xhr.responseJSON.errors;
                    if (errors && errors.email) {
                        $errorDiv.text(errors.email[0]);
                    }
                }
            }
        });
    }
});