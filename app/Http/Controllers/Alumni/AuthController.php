<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Alumni\Models\Alumni;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('alumni.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('alumni')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/alumni/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function showRegister()
    {
        return view('alumni.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|unique:alumni,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:alumni,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1980|max:' . date('Y'),
        ]);

        $alumni = Alumni::create([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'graduation_year' => $request->graduation_year,
        ]);

        Auth::guard('alumni')->login($alumni);

        return redirect('/alumni/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('alumni')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/alumni/login');
    }

    public function dashboard()
    {
        $alumni = Auth::guard('alumni')->user();
        return view('alumni.dashboard', compact('alumni'));
    }

    public function showProfile()
    {
        $alumni = Auth::guard('alumni')->user();
        return view('alumni.profile', compact('alumni'));
    }

    public function updateProfile(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:alumni,email,' . $alumni->alumni_id . ',alumni_id',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'address' => 'nullable|string|max:500',
        ]);

        $alumni->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'gpa' => $request->gpa,
        ]);

        return redirect()->route('alumni.profile')->with('success', 'Profile updated successfully!');
    }
}
