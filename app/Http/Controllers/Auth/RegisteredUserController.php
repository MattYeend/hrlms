<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
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

        Log::log(Log::ACTION_REGISTER_USER, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ], $user->id);

        return to_route('dashboard');
    }

    private function userBasicInfo(): array
    {
        return [
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
                'string',
                'max:255',
                Rule::unique('users', 'slug'),
            ],
        ];
    }

    private function addressInfo(): array
    {
        return [
            'first_line' => 'required|string|max:255',
            'second_line' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'post_code' => 'required|string|max:20',
        ];
    }

    private function employmentInfo(): array
    {
        return [
            'full_time' => 'boolean',
            'part_time' => 'boolean',
            'role_id' => 'nullable|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }

    private function userValidationRules(): array
    {
        return array_merge(
            $this->userBasicInfo(),
            $this->addressInfo(),
            $this->employmentInfo()
        );
    }

    private function validateUser(Request $request): array
    {
        return $request->validate($this->userValidationRules());
    }

    private function createUser(array $data): User
    {
        $slug = $data['slug'] ?? ($data['name'] ?? null);
        $slug = $slug ? Str::slug($slug) : uniqid('user-', true);

        return User::create(array_merge(
            $this->extractBasicUserFields($data, $slug),
            $this->extractAddressFields($data),
            $this->extractEmploymentFields($data),
            $this->extractAuditFields()
        ));
    }

    private function extractBasicUserFields(array $data, string $slug): array
    {
        return [
            'title' => $data['title'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'slug' => $slug,
        ];
    }

    private function extractAddressFields(array $data): array
    {
        return [
            'first_line' => $data['first_line'],
            'second_line' => $data['second_line'] ?? null,
            'town' => $data['town'] ?? null,
            'city' => $data['city'] ?? null,
            'county' => $data['county'] ?? null,
            'country' => $data['country'] ?? null,
            'post_code' => $data['post_code'],
        ];
    }

    private function extractEmploymentFields(array $data): array
    {
        return [
            'full_time' => $data['full_time'] ?? false,
            'part_time' => $data['part_time'] ?? false,
            'role_id' => $data['role_id'] ?? null,
            'department_id' => $data['department_id'] ?? null,
        ];
    }

    private function extractAuditFields(): array
    {
        $userId = auth()->id();
        return [
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}
