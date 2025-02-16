<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
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
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);
        $password = Str::random(8);

        $user = $this->userRepository->create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => bcrypt($password),
            'role_id' => $request->validated()['role_id'],
            'department_id' => $request->validated()['department_id'],
            'job_title_id' => $request->validated()['job_title_id']
        ]);

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
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $oldRole = $user->role->name;
        $this->userRepository->update($user, $request->validated());
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
}
