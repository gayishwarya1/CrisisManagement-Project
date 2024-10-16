$(document).ready(function() {
  $('#feedbackForm').submit(function(event) {
    event.preventDefault(); // Prevent default form submission

    // Serialize form data
    var formData = $(this).serialize();

    // Submit the form via AJAX
    $.ajax({
      type: 'POST',
      url: 'process_feedback.php',
      data: formData,
      success: function(response) {
        // Check response for success or error messages
        if (response.includes('success')) {
          $('.sent-message').fadeIn().html(response); // Show success message
          $('#feedbackForm')[0].reset(); // Reset form fields
        } else {
          $('.error-message').fadeIn().html(response); // Show error message
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error); // Log AJAX error
        $('.error-message').fadeIn().html('Error occurred. Please try again.'); // Show generic error message
      }
    });
  });
});
