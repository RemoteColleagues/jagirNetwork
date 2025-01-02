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
        // Fetch all users with role 'user' along with their profile details
        $users = User::with('profile')  // Eager load userProfile relationship
                    ->where('role', 'user')  // Only users with role 'user'
                    ->get();

        return view('admin.users', compact('users'));  // Pass data to the view
    }
}
