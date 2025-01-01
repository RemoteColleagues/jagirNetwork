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
    $profile = $user->profile; 
    $userProfile = UserProfile::where('user_id', $user_id)->first();

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
            'skills.*.name' => 'nullable|string|max:100',
            'skills.*.experience' => 'nullable|string|max:100',
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
    
        // Format skills as an associative array
        $skills = [];
        if ($request->has('skills') && is_array($request->skills)) {
            foreach ($request->skills as $skill) {
                if (!empty($skill['name']) && !empty($skill['experience'])) {
                    $skills[$skill['name']] = $skill['experience'];
                }
            }
        }
    
        // Store skills in JSON format
        $userProfile->skills = json_encode($skills);
    
        // Handle profile image upload and store full path in DB
        if ($request->hasFile('profile_image')) {
            // Store the file in the public storage directory
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            
            // Generate the full URL for the file
            $userProfile->profile_image = asset('storage/' . $profileImagePath);
        }
    
        // Handle CV file upload and store full path in DB
        if ($request->hasFile('cv_file')) {
            // Store the file in the public storage directory
            $cvFilePath = $request->file('cv_file')->store('cv_files', 'public');
            
            // Generate the full URL for the file
            $userProfile->cv_file = asset('storage/' . $cvFilePath);
        }
    
        // Save the profile
        $userProfile->save();
    
        // Return response with the profile data in full URL format
        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'Profile updated successfully!',
                'userProfile' => $userProfile, // Including the full URLs in response
            ]);
        }
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');

    }
    
    
    
   
  // In your controller method
public function deleteSkill($id)
{
    try {
        $userProfile = auth()->user()->profile; // Accessing the profile via the relationship
        $skills = json_decode($userProfile->skills, true);

        // The skill and experience are stored sequentially, so we need to remove two consecutive items
        $index = $id * 2; // The skill index will be 2 times the given ID
        if (isset($skills[$index])) {
            array_splice($skills, $index, 2); // Remove skill and its associated experience
            $userProfile->skills = json_encode($skills);
            $userProfile->save();
        }

        return response()->json(['success' => true, 'message' => 'Skill deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete skill']);
    }
}

    
    
  
}
