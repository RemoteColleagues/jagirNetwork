@extends('users.layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Users list</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact </th>
                <th>Age</th>
                <th>Address </th>
                <th>Degree</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contact }}</td>
        
                    <td>{{ $user->profile ? $user->profile->age : 'N/A' }}</td>
                    <td>{{ $user->profile ? $user->profile->address : 'N/A' }}</td>
                    <td>{{ $user->profile ? $user->profile->degree : 'N/A' }}</td>
        
                    <td>
                        <!-- View button to redirect to the user's details page -->
                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
