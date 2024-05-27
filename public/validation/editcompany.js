document.getElementById('companyForm').addEventListener('submit', function(event) {
    // Clear previous error messages
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

    // Validation flags
    let valid = true;

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

    // Validate Website
    const website = document.getElementById('website');
    const urlPattern = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;
    if (!urlPattern.test(website.value.trim())) {
        valid = false;
        website.classList.add('is-invalid');
        document.getElementById('website_error').textContent = 'Please enter a valid URL.';
    }

    // If any validation fails, prevent form submission
    if (!valid) {
        event.preventDefault();
    }
});

function clearError(event) {
const element = event.target;
element.classList.remove('is-invalid');
const errorElement = document.getElementById(element.id + '_error');
if (errorElement) {
errorElement.textContent = '';
}
}

// Add event listeners to inputs
document.getElementById('company_name').addEventListener('input', clearError);
document.getElementById('email').addEventListener('input', clearError);
document.getElementById('website').addEventListener('input', clearError);
