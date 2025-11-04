<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request, ?string $role = null)
    {
        $allowed = ['admin', 'donor', 'beneficiary', 'volunteer'];
        $role = $role && in_array($role, $allowed, true) ? $role : null;
        return view('auth.login', [
            'role' => $role,
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            // Disallow self-assigning admin on signup 
            'role' => ['required', 'in:donor,beneficiary,volunteer'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'location' => $validated['location'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user)->with('status', 'Account created successfully');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(auth()->user());
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function loginForRole(Request $request, string $role)
    {
        $allowed = ['admin', 'donor', 'beneficiary', 'volunteer'];
        if (!in_array($role, $allowed, true)) {
            return redirect()->route('login');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (auth()->user()->role !== $role) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                abort(403);
            }
            return $this->redirectByRole(auth()->user());
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    protected function redirectByRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'donor':
                return redirect()->route('donations.index');
            case 'beneficiary':
                return redirect()->route('requests.index');
            case 'volunteer':
                return redirect()->route('volunteer.tasks');
            default:
                return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        } catch (\Exception $e) {
            // If session is already invalid/expired, just logout and redirect
            // This handles 419 errors gracefully
            Auth::logout();
        }
        
        return redirect('/');
    }

    public function showProfile()
    {
        return view('profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Base validation rules - never allow role changes via profile update
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'location' => ['nullable', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        // Explicitly prevent role changes - role updates should only happen via admin promotion
        $user->update($validated);

        return redirect()->route('profile')->with('status', 'Profile updated successfully');
    }
}


