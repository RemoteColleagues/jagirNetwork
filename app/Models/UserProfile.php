<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'users_profiles';  // Correct table name


    protected $fillable = [
        'user_id', 'profile_image', 'age', 'dob', 'address', 'degree', 'cgpa', 'skills', 'cv_file', 'about'

    ];
    protected $casts = [
        'skills' => 'array',  // To handle the skills as an array
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profile()
{
    return $this->hasOne(UserProfile::class); // or belongsTo depending on the relationship
}
    
}
