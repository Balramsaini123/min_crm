@extends('admin.layout')
@section('content')
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
                 @if($errors->any())
                    <div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                 @endif
          <div class="card-header">
            <h4>Add Company</h4>
          </div>
          <div class="card-body">
            <form id="companyForm" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" >
                <div class="invalid-feedback" id="company_name_error"></div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" >
                <div class="invalid-feedback" id="email_error"></div>
              </div>
              <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
                <div class="invalid-feedback" id="logo_error"></div>
              </div>
              <div class="form-group">
                <label for="website">Website</label>
                <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}">
                <div class="invalid-feedback" id="website_error"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
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

      // Validate Logo
      const logo = document.getElementById('logo');
    
        if (!logo.value) {
          valid = false;
          logo.classList.add('is-invalid');
          document.getElementById('logo_error').textContent = 'Please upload a valid image file.';
        
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
    document.getElementById('company_name').addEventListener('input', clearError);
    document.getElementById('email').addEventListener('input', clearError);
    document.getElementById('logo').addEventListener('change', clearError);
    document.getElementById('website').addEventListener('input', clearError);
  </script>
@endsection
