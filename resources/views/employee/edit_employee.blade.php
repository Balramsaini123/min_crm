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
@endsection
