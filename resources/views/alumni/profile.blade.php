@extends('alumni.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-2xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-1 text-sm text-gray-600">
                Update your personal information and contact details
            </p>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('alumni.profile.update') }}" class="space-y-6 px-4 py-5 sm:p-6">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                <p class="mt-1 text-sm text-gray-500">Basic information about yourself</p>
            </div>

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <!-- Student ID (Read Only) -->
                <div class="sm:col-span-1">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <div class="mt-1">
                        <input type="text" name="student_id" id="student_id" 
                               value="{{ $alumni->student_id }}" readonly
                               class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Full Name -->
                <div class="sm:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $alumni->name) }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="sm:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" required
                               value="{{ old('email', $alumni->email) }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone -->
                <div class="sm:col-span-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <div class="mt-1">
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', $alumni->phone) }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('phone') border-red-300 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Gender -->
                <div class="sm:col-span-1">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <div class="mt-1">
                        <select name="gender" id="gender"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('gender') border-red-300 @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Birth Date -->
                <div class="sm:col-span-1">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                    <div class="mt-1">
                        <input type="date" name="birth_date" id="birth_date"
                               value="{{ old('birth_date', $alumni->birth_date ? $alumni->birth_date->format('Y-m-d') : '') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('birth_date') border-red-300 @enderror">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Academic Information</h3>
                <p class="mt-1 text-sm text-gray-500">Your academic details</p>
            </div>

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <!-- Graduation Year (Read Only) -->
                <div class="sm:col-span-1">
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700">Graduation Year</label>
                    <div class="mt-1">
                        <input type="number" name="graduation_year" id="graduation_year" 
                               value="{{ $alumni->graduation_year }}" readonly
                               class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- GPA -->
                <div class="sm:col-span-1">
                    <label for="gpa" class="block text-sm font-medium text-gray-700">GPA</label>
                    <div class="mt-1">
                        <input type="number" name="gpa" id="gpa" step="0.01" min="0" max="4"
                               value="{{ old('gpa', $alumni->gpa) }}"
                               placeholder="e.g., 3.50"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('gpa') border-red-300 @enderror">
                        @error('gpa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <button type="button" onclick="history.back()" 
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Change Password Section -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Change Password</h3>
            <p class="mt-1 text-sm text-gray-500">Update your account password</p>
            
            <div class="mt-6">
                <button type="button" 
                        x-data @click="$dispatch('open-modal', 'change-password')"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div x-data="{ show: false }" 
     @open-modal.window="show = ($event.detail == 'change-password')"
     @close-modal.window="show = false"
     @keydown.escape.window="show = false"
     x-show="show" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             @click="show = false"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="#" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @csrf
                @method('PUT')
                
                <div class="sm:flex sm:items-start">
                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Change Password</h3>
                        
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="new_password" id="new_password" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Password
                    </button>
                    <button type="button" @click="show = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
