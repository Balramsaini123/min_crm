    document.getElementById('employeeForm').addEventListener('submit', function(event) {
      // Clear previous error messages
      document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
      document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

      // Validation flags
      let valid = true;

      // Validate First Name
      const firstName = document.getElementById('first_name');
      if (firstName.value.trim() === '') {
        valid = false;
        firstName.classList.add('is-invalid');
        document.getElementById('first_name_error').textContent = 'First name is required.';
      }

      // Validate Last Name
      const lastName = document.getElementById('last_name');
      if (lastName.value.trim() === '') {
        valid = false;
        lastName.classList.add('is-invalid');
        document.getElementById('last_name_error').textContent = 'Last name is required.';
      }

      // Validate Company Name
      const companyName = document.getElementById('company_name');
      if (companyName.value.trim() === '') {
        valid = false;
        companyName.classList.add('is-invalid');
        document.getElementById('company_name_error').textContent = 'Company name is required.';
      }

      // Validate Email
      const email = document.getElementById('email');
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value.trim())) {
        valid = false;
        email.classList.add('is-invalid');
        document.getElementById('email_error').textContent = 'Please enter a valid email address.';
      }

      // Validate Phone
      const phone = document.getElementById('phone');
      const phonePattern = /^[0-9]+$/;
      if (!phonePattern.test(phone.value.trim())) {
        valid = false;
        phone.classList.add('is-invalid');
        document.getElementById('phone_error').textContent = 'Please enter a valid phone number.';
      }

      // If any validation fails, prevent form submission
      if (!valid) {
        event.preventDefault();
      }
    });

    // Function to clear error on input
    function clearError(event) {
      const element = event.target;
      element.classList.remove('is-invalid');
      const errorElement = document.getElementById(element.id + '_error');
      if (errorElement) {
        errorElement.textContent = '';
      }
    }

    // Add event listeners to inputs
    document.getElementById('first_name').addEventListener('input', clearError);
    document.getElementById('last_name').addEventListener('input', clearError);
    document.getElementById('company_name').addEventListener('input', clearError);
    document.getElementById('email').addEventListener('input', clearError);
    document.getElementById('phone').addEventListener('input', clearError);
