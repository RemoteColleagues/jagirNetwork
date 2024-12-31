@extends('users.layouts.sidebar')

@section('title', 'Profile')

@section('content')
<style>
    .small-input {
        width: 250px;
        margin-right: 10px;
    }
    .card {
        margin-bottom: 20px;
    }
    .experience-group {
        width: 300px;
    }
    button {
        display: flex;
        align-items: center;
    }
    button i {
        margin-right: 5px;
    }
    @media (max-width: 767px) {
        .d-flex {
            flex-direction: column;
        }
        .small-input, .experience-group {
            width: 100%;
        }
        .btn {
            width: 100%;
            margin-top: 10px;
        }
    }
</style>

<div class="container mt-4">
  

    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" onclick="toggleCard(this)">
            <h5>Basic Information</h5>
            <i class="bi bi-chevron-down toggle-arrow" onclick="toggleCard(this)"></i>
        </div>
        <div class="card-body card-content d-none">
            <form method="POST" action="{{ route('user.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" class="form-control" placeholder="Enter your full name" value="{{ $user->fullname ?? '' }}" name="fullname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter your email" value="{{ $user->email ?? '' }}" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="text" id="contact" class="form-control" placeholder="Enter your Contact Number" value="{{ $user->contact ?? '' }}" name="contact">
                        </div>
                
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                        </div>
                    </div>
                </div>
        
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
        
    </div>
    
    <form id="profileForm" method="POST" enctype="multipart/form-data" action="{{ route('user.details.store') }}">
        @csrf

        <!-- Other Details -->
        <div class="card">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center" onclick="toggleCard(this)">
                <h5>Other Details</h5>
                <i class="bi bi-chevron-down toggle-arrow"></i>
            </div>
            <div class="card-body card-content">
                <div class="row mb-3">
                    <div class="col-md-4 text-center">
                        <img id="profilePreview" src="{{ old('dob',$userProfile->profile_image ?? '') }}" alt="Profile Image" class="rounded-circle img-thumbnail">
                        <input type="file" id="profileInput" name="profile_image" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" id="age" name="age" class="form-control" placeholder="Enter your age" 
                                value="{{ old('age', $userProfile->age ?? '') }}">               
                                         </div>
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob',$userProfile->dob ?? '') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="otherAddress" class="form-label">Full Address (City, State, Country)</label>
                            <textarea id="otherAddress" name="address" class="form-control" rows="2" placeholder="Enter Your Address">{{ old('address',$userProfile->address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary next-btn mt-3">Next</button>
            </div>
        </div>

        <!-- Education -->
        <div class="card">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center" onclick="toggleCard(this)">
                <h5>Education</h5>
                <i class="bi bi-chevron-down toggle-arrow"></i>
            </div>
            <div class="card-body card-content d-none">
                <div class="mb-3">
                    <label for="degree" class="form-label">Last Completed Education Degree</label>
                    <input type="text" id="degree" name="degree" class="form-control" placeholder="Enter your degree" value="{{ old('degree',$userProfile->degree ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="cgpa" class="form-label">Marks/CGPA</label>
                    <input type="text" id="cgpa" name="cgpa" class="form-control" placeholder="Enter your marks or CGPA" value="{{ old('cgpa',$userProfile->cgpa ?? '') }}">
                </div>
                <button type="button" class="btn btn-primary next-btn mt-3">Next</button>
            </div>
        </div>

        <!-- Skills -->
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center" onclick="toggleCard(this)">
                <h5>Skills</h5>
                <i class="bi bi-chevron-down toggle-arrow"></i>
            </div>
            <div class="card-body card-content d-none">
                <div id="skillsContainer">
                    <!-- Loop through the skills and display them -->
                    @php     
                        $skills = json_decode($userProfile->skills);
                    @endphp
        
                    @foreach($skills as $index => $skill)
                        @if($index % 2 == 0)
                            <div class="mb-3 skill-group">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <label for="skill_{{ $index }}" class="form-label">Skill</label>
                                        <input type="text" id="skill_{{ $index }}" name="skills[]" class="form-control small-input" value="{{ $skill }}" readonly>                 
                                    </div>
                                    <div class="mt-2 experience-group ml-3 flex-grow-1">
                                        <label for="experience_{{ $index }}" class="form-label">Experience</label>
                                        <input type="text" id="experience_{{ $index }}" name="experience[]" class="form-control" value="{{ $skills[$index + 1] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary mt-3" onclick="addNewSkill()">Add Another Skill</button>
                <button type="button" class="btn btn-primary next-btn mt-3">Next</button>
            </div>
        </div>
        <!-- Upload CV -->
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center" onclick="toggleCard(this)">
                <h5>Upload CV</h5>
                <i class="bi bi-chevron-down toggle-arrow"></i>
            </div>
            <div class="card-body card-content d-none">
                <div class="mb-3">
                    <label for="cv" class="form-label">CV File</label>
                    <input type="file" id="cv" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">Describe More About You</label>
                    <textarea id="about" name="about" class="form-control" rows="5" placeholder="Tell us more about yourself">value="{{ old('about',$userProfile->about ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allCardContents = document.querySelectorAll('.card-content');
        allCardContents.forEach(function (cardContent, index) {
            if (index !== 0) {
                cardContent.classList.add('d-none');
            }
        });

        const nextButtons = document.querySelectorAll('.next-btn');
        nextButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const currentCard = btn.closest('.card');
                const nextCard = currentCard.nextElementSibling;
                if (nextCard && nextCard.classList.contains('card')) {
                    currentCard.querySelector('.card-content').classList.add('d-none');
                    nextCard.querySelector('.card-content').classList.remove('d-none');
                }
            });
        });
    });

    function toggleCard(header) {
        const cardContent = header.closest('.card').querySelector('.card-content');
        cardContent.classList.toggle('d-none');
    }

    function previewImage(event) {
        const preview = document.getElementById('profilePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    let skillCounter = 1;
    
    function addExperienceOption(event) {
        const input = event.target;
        const skillGroup = input.closest('.skill-group');
        const experienceGroup = skillGroup.querySelector('.experience-group');
    
        if (input.value.trim() !== '') {
            experienceGroup.classList.remove('d-none');
        } else {
            experienceGroup.classList.add('d-none');
        }
    }
    
    function addNewSkill() {
    const skillsContainer = document.getElementById('skillsContainer');

    const newSkillGroup = document.createElement('div');
    newSkillGroup.classList.add('mb-3', 'skill-group');

    newSkillGroup.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <label for="skill_${skillCounter}" class="form-label">Skill</label>
                <input type="text" id="skill_${skillCounter}" name="skills[]" class="form-control small-input" placeholder="Enter a skill" oninput="addExperienceOption(event)">
            </div>
            <div class="mt-2 d-none experience-group ml-3 flex-grow-1">
                <label for="experience_${skillCounter}" class="form-label">Experience</label>
                <input type="text" id="experience_${skillCounter}" name="experience[]" class="form-control" placeholder="Describe your experience">
            </div>
            <button type="button" class="btn btn-danger ml-3" onclick="removeSkill(event)">
                <i class="bi bi-trash"></i> Remove
            </button>
        </div>
    `;

    skillsContainer.appendChild(newSkillGroup);
    skillCounter++;
}


    function removeSkill(event) {
        const skillGroup = event.target.closest('.skill-group');
        skillGroup.remove();
    }
</script>
@endsection
