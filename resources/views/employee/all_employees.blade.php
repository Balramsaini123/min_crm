@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Employee List</h4>
                    @if($message = Session::get('success'))
                        <div id="success-message" class="alert alert-success">
                            {{ $message }}

                        </div>
                    @endif
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('employees.create') }}" class="btn btn-success"
                        style="float: left; margin-top: 10px;">Add Employee</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="employee_table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr id="row_{{ $employee->id }}">
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ $employee->company->companies_name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>
                                        <div style="display:flex">
                                        <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}"
                                            class="btn btn-primary editBtn">Edit</a>&nbsp;&nbsp;
                                        <form
                                            action="{{ route('employees.destroy', ['employee' => $employee->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this company and its employees?')">Delete</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS and dependencies (jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#employee_table').DataTable();

        $('.editBtn').click(function () {
            var id = $(this).data('id');
            var row = $('#row_' + id);
            var editForm = row.find('.editForm');
            var editBtn = row.find('.editBtn');

            // Toggle visibility of edit form and button
            editForm.toggleClass('d-none');
            editBtn.toggleClass('d-none');
        });
    });

</script>
@endsection
