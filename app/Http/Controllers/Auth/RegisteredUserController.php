<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
        
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        
            'first_line' => 'required|string|max:255',
            'second_line' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'post_code' => 'required|string|max:20',
        
            'full_time' => 'boolean',
            'part_time' => 'boolean',
        
            'role_id' => 'nullable|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);
        
        $user = User::create([
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_line' => $request->first_line,
            'second_line' => $request->second_line,
            'town' => $request->town,
            'city' => $request->city,
            'county' => $request->county,
            'country' => $request->country,
            'post_code' => $request->post_code,
            'full_time' => $request->full_time ?? false,
            'part_time' => $request->part_time ?? false,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
