@extends('users.layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome to the Jagir Network, {{ $user->fullname }}!</p>
@endsection
