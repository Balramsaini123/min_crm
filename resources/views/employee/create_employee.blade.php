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
            <h4>Add Employee</h4>
          </div>
          <div class="card-body">
            <form id="employeeForm" action="{{ route('employees.store') }} " method="POST">
              @csrf
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" >
                <div id="first_name_error" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" >
                <div id="last_name_error" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label for="company_name">Company Name</label>
                <select class="form-control" id="company_name" name="company_name" >
                  <option value="">Select Company</option>
                  @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->companies_name }}</option>
                  @endforeach
                </select>
                <div id="company_name_error" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" >
                <div id="email_error" class="invalid-feedback"></div>
              </div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" >
                <div id="phone_error" class="invalid-feedback"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#employeeForm').submit(function(event) {
        var errors = false;
        var firstName = $('#first_name').val();
        var lastName = $('#last_name').val();
        var companyName = $('#company_name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();

        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        // Validate first name
        if (firstName.trim() === '') {
          $('#first_name').addClass('is-invalid');
          $('#first_name_error').text('First name is required.');
          errors = true;
        }

        // Validate last name
        if (lastName.trim() === '') {
          $('#last_name').addClass('is-invalid');
          $('#last_name_error').text('Last name is required.');
          errors = true;
        }

        // Validate company name
        if (companyName === '') {
          $('#company_name').addClass('is-invalid');
          $('#company_name_error').text('Company name is required.');
          errors = true;
        }

        // Validate email
        if (email.trim() === '') {
          $('#email').addClass('is-invalid');
          $('#email_error').text('Email is required.');
          errors = true;
        } else if (!isValidEmail(email)) {
          $('#email').addClass('is-invalid');
          $('#email_error').text('Invalid email format.');
          errors = true;
        }

        // Validate phone
        if (phone.trim() === '') {
          $('#phone').addClass('is-invalid');
          $('#phone_error').text('Phone number is required.');
          errors = true;
        }

        if (errors) {
          event.preventDefault(); // Prevent form submission if there are errors
        }
      });

      // Email validation function
      function isValidEmail(email) {
        var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        return emailRegex.test(email);
      }
    });
  </script>
@endsection
