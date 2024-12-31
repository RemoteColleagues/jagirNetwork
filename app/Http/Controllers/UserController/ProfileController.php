<?php

namespace App\Http\Controllers\UserController;

use id;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    /**
     * Display the user profile (Web).
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
{
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    $user_id = auth()->id();
    $profile = $user->profile;  // Will return null if no profile exists
    $userProfile = UserProfile::where('user_id', $user_id)->first();

    // If the profile doesn't exist, handle it gracefully
    if (!$profile) {
        $profile = null;
    }
    
    if ($request->expectsJson()) {
        // Return the data as JSON
        return response()->json([
            'userProfile' => $userProfile,
        ]);
    }

    return view('users.profile', compact('user', 'profile', 'userProfile'));
}

    /**
     * Update the user profile (API).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'age' => 'nullable|integer',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'cgpa' => 'nullable|string|max:50',
            'about' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string|max:100',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        // Get the logged-in user's ID
        $user_id = auth()->id();

        // Check if a profile exists; if not, create a new one
        $userProfile = UserProfile::firstOrNew(['user_id' => $user_id]);

        // Update the profile data
        $userProfile->age = $request->age;
        $userProfile->dob = $request->dob;
        $userProfile->address = $request->address;
        $userProfile->degree = $request->degree;
        $userProfile->cgpa = $request->cgpa;
        $userProfile->about = $request->about;
        $userProfile->skills = json_encode($request->skills);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $userProfile->profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Handle CV file upload
        if ($request->hasFile('cv_file')) {
            $userProfile->cv_file = $request->file('cv_file')->store('cv_files', 'public');
        }

        // Save the profile
        $userProfile->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Profile updated successfully!']);
        }
    
        return redirect()->route(route: 'profile')->with('success', 'Profile updated successfully!');
    }
   

    
  
}
