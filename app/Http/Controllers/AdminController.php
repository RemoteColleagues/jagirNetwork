<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
     /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
  /**
     * Show the admin dashboard with user details.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('profile')
                     ->where('role', 'user')
                     ->paginate(10); // Fetch 10 users per page
    
        return view('admin.users', compact('users'));
    }

    // Show the details of a specific user
    public function show(User $user)
    {
        // Eager load the profile data along with the user
        $user->load('profile');
        return view('admin.users_details', compact('user'));
    }
    
}
