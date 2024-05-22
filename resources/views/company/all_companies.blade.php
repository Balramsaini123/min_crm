@extends('admin.layout')
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-6">
            <h2>Companies list</h2>
            @if($message = Session::get('success'))
                <div id="success-message" class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('companies.create') }}" class="btn btn-success">Add Company</a>
            <a href="{{ route('deleted_companies') }}" class="btn btn-danger">Deleted Companies</a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <form method="GET" action="{{ route('companies.index') }}" class="form-inline">
                <div class="form-group mb-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search for a company" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm ml-2 mb-2">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="background-color: #f2f2f2;">Logo</th>
                        <th style="background-color: #f2f2f2;">Company name</th>
                        <th style="background-color: #f2f2f2;">Email</th>
                        <th style="background-color: #f2f2f2;">Company Website</th>
                        <th style="background-color: #f2f2f2;">Employees List</th>
                        <th style="background-color: #f2f2f2;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td><img src="{{ $company->logo }}" alt="logo" style="width:50px"></td>
                            <td>{{ $company->companies_name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->website }}</td>
                            <td><a href="{{ route('companies.showEmployeeList', ['id' => $company->id]) }}" class="btn btn-primary">View Employees List</a></td>
                            <td>
                                <div style="display:flex">
                                    <a href="{{ route('companies.edit', ['company' => $company->id]) }}" class="btn btn-primary">Edit</a>&nbsp;&nbsp;
                                    <form action="{{ route('companies.destroy', ['company' => $company->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this company and its employees?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($companies->isEmpty())
                <h3 style="text-align: center;margin-top: 50px;">Companies not found!</h3>
            @endif
            <div class="container">
                {{ $companies->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
