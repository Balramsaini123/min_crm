@extends('admin.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="col-6">
        <h2> Deleted Companies list</h2>
        @if($message = Session::get('success'))
            <div id="success-message" class="alert alert-success">
                {{ $message }}

            </div>
        @endif
</div>
        <div class="col-6 text-right">
            
        </div>
        <table>
            <thead>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2;">Logo</th>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2;">Company name</th>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2;">Email</th>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2;">Company Website</th>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2;">Action</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach($deletedRecords as $company)
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><img src="{{ $company->logo }}"
                                alt="logo" style="width:50px"></td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{{ $company->companies_name }}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{{ $company->email }}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{{ $company->website }}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">
                               <div style="display:flex"><a
                                href="{{ route('restore.company', ['company' => $company->id]) }}"
                                class="btn btn-primary">Restore</a>&nbsp;&nbsp;
                                
</div>
                        </td>



                        <!-- Add more table cells for additional data fields -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($deletedRecords->isEmpty())
            <h3  style="text-align: center;margin-top: 50px;">Companies not found!</h3>
        @endif
    </div>
</div>
@endsection
