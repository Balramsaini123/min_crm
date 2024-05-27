    $(document).ready(function() {
        $('#loginForm').on('submit', function(event) {
            // Clear previous errors
            $('#emailError').text('');
            $('#passwordError').text('');

            let email = $('#email').val().trim();
            let password = $('#password').val().trim();
            let valid = true;

            // Validate email
            if (email === '') {
                $('#emailError').text('Email is required.');
                valid = false;
            } else if (!validateEmail(email)) {
                $('#emailError').text('Invalid email format.');
                valid = false;
            }

            // Validate password
            if (password === '') {
                $('#passwordError').text('Password is required.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
