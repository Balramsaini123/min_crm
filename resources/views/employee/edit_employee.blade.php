@extends('admin.layout')
@section('content')
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Edit Employee</h4>
          </div>
          <div class="card-body">
            <form id="employeeForm" action="{{ route('employees.update', ['employee' => $employee_data->id]) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ $employee_data->first_name }}" >
                <div class="invalid-feedback" id="first_name_error">@error('first_name'){{ $message }}@enderror</div>
              </div>
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ $employee_data->last_name }}" >
                <div class="invalid-feedback" id="last_name_error">@error('last_name'){{ $message }}@enderror</div>
              </div>
              <div class="form-group">
                <label for="company_name">Company Name</label>
                <select class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" >
                  <option value="">Select Company</option>
                  @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $employee_data->company_id == $company->id ? 'selected' : '' }}>{{ $company->companies_name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback" id="company_name_error">@error('company_name'){{ $message }}@enderror</div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $employee_data->email }}" >
                <div class="invalid-feedback" id="email_error">@error('email'){{ $message }}@enderror</div>
              </div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $employee_data->phone }}" >
                <div class="invalid-feedback" id="phone_error">@error('phone'){{ $message }}@enderror</div>
              </div>
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
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
  </script>
@endsection
