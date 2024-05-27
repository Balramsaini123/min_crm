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
            <form id="companyFormcreate" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
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
@endsection
