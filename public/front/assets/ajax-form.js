$(document).ready(function() {
    // Form submission
    $('#contact-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // AJAX form validation
        var isValid = true;
        $('#contact-form input, #contact-form textarea').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).css('border', '1px solid red'); // Add red border to empty fields
                $(this).attr('title', 'This field is required'); // Tooltip for empty fields
            } else {
                $(this).css('border', ''); // Reset border
                $(this).removeAttr('title'); // Remove tooltip
            }
        });

        if (!isValid) {
            alert('Please fill in all fields.');
            return false;
        }

        // Collect form data
        var formData = $('#contact-form').serialize();

        // AJAX request
        $.ajax({
            url: 'assets/mail.php', // PHP file to send email
            type: 'POST',
            data: formData,
            success: function(response) {
                // Show response message
                $('.ajax-response').html(response);
                // Show success message and reset the form
                alert('Form submitted successfully!');
                $('#contact-form')[0].reset(); // Reset the form
            },
            error: function() {
                alert('There was an error sending the form.');
            }
        });
    });
});
