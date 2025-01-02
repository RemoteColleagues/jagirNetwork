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
                <th>Profile Image</th>
                <th>Age</th>
                <th>Degree</th>
                <th>Skills</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->userProfile && $user->userProfile->profile_image)
                            <img src="{{ asset('storage/' . $user->userProfile->profile_image) }}" alt="Profile Image" width="50">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $user->userProfile ? $user->userProfile->age : 'N/A' }}</td>
                    <td>{{ $user->userProfile ? $user->userProfile->degree : 'N/A' }}</td>
                    <td>
                        @if ($user->userProfile && is_array($user->userProfile->skills))
                            {{ implode(', ', $user->userProfile->skills) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">View</a> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
