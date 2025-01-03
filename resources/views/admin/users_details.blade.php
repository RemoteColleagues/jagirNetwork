@extends('users.layouts.sidebar')

@section('title', 'User Details')

<style>
    .card {
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .card-body {
        background-color: white;
        padding: 20px;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .table th, .table td {
        text-align: left;
        padding: 10px;
    }
</style>

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">{{ $user->fullname }}'s Profile</h1>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $user->fullname }}'s Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-4">
                        <strong>Email:</strong>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-4">
                        <strong>Contact:</strong>
                        <p>{{ $user->contact?? 'No Contact Availabel'  }}</p>
                    </div>
                    <div class="mb-4">
                        <strong>Date of Birth and Age</strong>
                        <p>{{ optional($user->profile)->dob ? \Carbon\Carbon::parse($user->profile->dob)->format('d-m-Y') : 'Date Not Founc' }}/ {{ $user->profile->age ?? 'No Age' }}</p>
                    
                    </div>
                   
                </div>

                <div class="col-md-4">
                    <!-- Degree and CGPA in same column -->
                    <div class="mb-4">
                        <strong>Last Education and GPA(Marks)</strong>
                        <p>{{ $user->profile->degree ?? 'No Degree Found'  }}/ {{ $user->profile->cgpa ?? 'No Data Found'  }}</p>
                
                    </div>
                 

                    <!-- Skills and Experience in table -->
                    <div class="mb-3">
                        <strong>Skills and Experience:</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Skill</th>
                                    <th>Experience</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($user->profile && $user->profile->skills)
                                @foreach(json_decode($user->profile->skills, true) as $key => $value)
                                    <tr>
                                        <td>{{ ucfirst($key) }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">No skills data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <strong>About:</strong>
                        <p>{{ $user->profile->about ?? 'No Details Found'  }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    @if($user->profile && $user->profile->profile_image)
                    <img src="{{ $user->profile->profile_image }}" alt="Profile Image" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <p>No profile image available</p>
                @endif

                    <!-- CV File -->
                    @if($user->profile && $user->profile->cv_file)
                        <div class="mb-3">
                            <strong>CV:</strong>
                            <a href="{{ asset($user->profile->cv_file) }}" target="_blank" class="btn btn-info">View CV</a>
                        </div>
                    @else
                        <p>No CV available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
