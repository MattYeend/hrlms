<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

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
        $validated = $this->validateUser($request);
        $user = $this->createUser($validated);

        event(new Registered($user));
        Auth::login($user);

        return to_route('dashboard');
    }

    private function validateUser(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'slug' => [
                'required',
                'string', 'max:255',
                Rule::unique('users', 'slug'),
            ],
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
    }

    private function createUser(array $data): User
    {
        $slug = $data['slug'] ?? null;

        if (empty($slug)) {
            $slug = isset($data['name']) ? Str::slug($data['name']) : null;
        }
    
        if (empty($slug)) {
            $slug = uniqid('user-', true);
        }
        return User::create([
            'title' => $data['title'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'slug' => $slug,
            'first_line' => $data['first_line'],
            'second_line' => $data['second_line'] ?? null,
            'town' => $data['town'] ?? null,
            'city' => $data['city'] ?? null,
            'county' => $data['county'] ?? null,
            'country' => $data['country'] ?? null,
            'post_code' => $data['post_code'],
            'full_time' => $data['full_time'] ?? false,
            'part_time' => $data['part_time'] ?? false,
            'role_id' => $data['role_id'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'created_by' => auth()->id() ?? null,
            'updated_by' => auth()->id() ?? null,
        ]);
    }
}
