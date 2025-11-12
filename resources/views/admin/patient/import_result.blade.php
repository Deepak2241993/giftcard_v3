@extends('layouts.admin_layout')
@section('body')
<div class="container">
    <h2>Import Result</h2>

    @if(count($skippedData) > 0)
        <div class="alert alert-warning">
            <strong>Note:</strong> These records were skipped because they already exist.
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skippedData as $data)
                    <tr>
                        <td>{{ $data['fname'] }}</td>
                        <td>{{ $data['lname'] }}</td>
                        <td>{{ $data['email'] }}</td>
                        <td>{{ $data['phone'] }}</td>
                        <td>{{ $data['reason'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-success">
            <strong>All records imported successfully!</strong>
        </div>
    @endif

    <a href="{{ route('patient.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
