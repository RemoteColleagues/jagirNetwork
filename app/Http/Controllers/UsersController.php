<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    //
    // Show the registration form (Web only)
    public function showRegistrationForm()
    {
        return view('users/register');
    }

    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|unique:users,contact',
            'password' => 'required|min:6|confirmed',
        ]);
    
        // Create the user
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
        ]);
    
        // Handle JSON request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully!',
                'data' => $user,
            ], 201);
        }
    
        // Handle web request
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    public function showLoginForm()
    {
        return view('users/login');
    }
     // Handle login request
    //  public function login(Request $request)
    //  {
    //      // Validate the request
    //      $request->validate([
    //          'email' => 'required|email',
    //          'password' => 'required',
    //      ]);
 
    //      // Check credentials
    //      $user = User::where('email', $request->email)->first();
 
    //      if (!$user || !Hash::check($request->password, $user->password)) {
    //         return back()->withErrors([
    //             'email' => 'The provided credentials are incorrect.'
    //         ])->withInput();
    //     }
 
    //      // Log the user in
    //      Auth::login($user);
 
    //      if ($request->expectsJson()) {
    //          // API response
    //          return response()->json([
    //              'success' => true,
    //              'message' => 'Login successful!',
    //              'data' => $user,
    //          ], 200);
    //      }
 
    //      // Redirect to dashboard or home page
    //      return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    //  }

    public function login(Request $request)
{
    // Validate the request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Check credentials
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Log the user in
    Auth::login($user);

    // Generate the token
    $token = $user->createToken('YourAppName')->plainTextToken;
    if ($request->expectsJson()) {
                 // API response
                 return response()->json([
                     'success' => true,
                     'message' => 'Login successful!',
                     'data' => $user,
                     'token' => $token

                 ], 200);
             }

    return redirect()->route('dashboard')->with('success', 'Logged in successfully!');

}

     public function dashboard()
{
    return view('users.dashboard'); // Ensure you have a 'dashboard.blade.php' view
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'contact' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string',  // Make sure passwords match
        ]);
        $user = User::findOrFail($id);
        $user->fullname = $validated['fullname'];
        $user->contact = $validated['contact'];

        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        // return view('users.profile', compact('user'));

        return redirect()->route('profile', $user->id)->with('success', 'Profile updated successfully!');
    }

}
