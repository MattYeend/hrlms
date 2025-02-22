<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Log;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\UserNotification;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userRepository->getAll();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        $departments = Department::all();
        return view('users.create', compact('roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $password = Str::random(8);

        $userData = [
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => bcrypt($password),
            'role_id' => $request->validated()['role_id'],
            'department_id' => $request->validated()['department_id'],
            'job_title_id' => $request->validated()['job_title_id']
        ];
    
        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $userData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        // CV
        if ($request->hasFile('cv')) {
            $cvFilename = $request->file('cv')->getClientOriginalName();
            $userData['cv_path'] = $request->file('cv')->storeAs('cvs', $cvFilename, 'public');
        }
    
        // Cover Letter
        if ($request->hasFile('cover_letter')) {
            $coverLetterFilename = $request->file('cover_letter')->getClientOriginalName();
            $userData['cover_letter'] = $request->file('cover_letter')->storeAs('cover_letters', $coverLetterFilename, 'public');
        }
    
        $user = $this->userRepository->create($userData);

        $user->notify(new UserNotification(
            'user_created',
            'Welcome to HR & LMS! Your account has been created.',
            $user->email,
            $password
        ));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        $departments = Department::all();
        return view('users.edit', compact('user', 'roles', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $oldRole = $user->role->name;
        
        $updatedData = $request->validated();

        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $updatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        // CV
        if ($request->hasFile('cv')) {
            $cvFilename = $request->file('cv')->getClientOriginalName();
            $updatedData['cv_path'] = $request->file('cv')->storeAs('cvs', $cvFilename, 'public');
        }
    
        // Cover Letter
        if ($request->hasFile('cover_letter')) {
            $coverLetterFilename = $request->file('cover_letter')->getClientOriginalName();
            $updatedData['cover_letter'] = $request->file('cover_letter')->storeAs('cover_letters', $coverLetterFilename, 'public');
        }
    
        // Update user via repository
        $this->userRepository->update($user, $updatedData);
        $newRole = $user->role->name;
    
        if ($oldRole !== $newRole) {
            $user->notify(new UserNotification(
                'role_changed',
                'Your role has been updated.',
                null, 
                null, 
                ['new_role' => $newRole]
            ));
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userRepository->delete($user);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function uploadProfilePicture(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->hasFile('profile_picture')){
            $id = $user->id;
            $isNewPictureUpload = !$user->profile_picture;

            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures');
            $user->profile_picture = $profilePicturePath;
            $user->save();

            if($isNewPictureUpload){
                Log::log(Log::ACTION_PROFILE_PICTURE_UPLOAD, ['user' => $user], null, $id);
            }else{
                Log::log(Log::ACTION_PROFILE_PICTURE_CHANGE, ['user' => $user], null, $id);
            }
        }

        return redirect()->back()->with('success', __('users.picture_upload_success'));
    }

    public function uploadCv(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        if($request->hasFile('cv')){
            $id = $user->id;
            $isNewCVUpload = !$user->cv;

            $cvPath = $request->file('cv')->store('cvs');
            $user->cv = $cvPath;
            $user->save();

            if($isNewCVUpload){
                Log::log(Log::ACTION_CV_UPLOAD, ['user' => $user], null, $id);
            }else{
                Log::log(Log::ACTION_CV_CHANGE, ['user' => $user], null, $id);
            }
        }

        return redirect()->back()->with('success', __('users.cv_upload_success'));
    }

    public function uploadCoverLetter(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'cover_letter' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        if($request->hasFile('cover_letter')){
            $id = $user->id;
            $isNewCoverLetterUpload = !$user->cover_letter;

            $coverLetterPath = $request->file('cover_letter')->store('cover_letters');
            $user->cover_letter = $coverLetterPath;
            $user->save();

            if($isNewCoverLetterUpload){
                Log::log(Log::ACTION_COVER_LETTER_UPLOAD, ['user' => $user], null, $id);
            }else{
                Log::log(Log::ACTION_COVER_LETTER_CHANGE, ['user' => $user], null, $id);
            }
        }

        return redirect()->back()->with('success', __('users.cover_letter_upload_success'));
    }
}
