@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 flex items-center">
        <i class="fa-solid fa-user mr-2"></i>Profile
    </h1>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <div class="flex flex-col space-y-4 md:space-y-0 md:grid md:grid-cols-2 md:gap-4">
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-user mr-1 text-primary-700"></i>Name
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-user-tag mr-1 text-primary-700"></i>Role
                </label>
                @if($user->role === 'admin')
                    <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('role') border-red-500 @enderror">
                        <option value="donor" {{ old('role', $user->role) === 'donor' ? 'selected' : '' }}>Donor</option>
                        <option value="beneficiary" {{ old('role', $user->role) === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                        <option value="volunteer" {{ old('role', $user->role) === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                @else
                    <input type="text" value="{{ ucfirst($user->role) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-600" readonly>
                @endif
                @error('role')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2 flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-envelope mr-1 text-primary-700"></i>Email
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2 flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-location-dot mr-1 text-primary-700"></i>Location
                </label>
                <input type="text" name="location" value="{{ old('location', $user->location) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('location') border-red-500 @enderror" placeholder="City, district">
                @error('location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="mt-6 w-full sm:w-auto bg-success-600 hover:bg-[#1B5E20] text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] font-medium">
            <i class="fa-solid fa-floppy-disk mr-2"></i>Save Changes
        </button>
    </form>
    <hr class="my-8 border-gray-200">
    <div class="bg-gray-50 rounded-lg p-4">
        <h2 class="font-semibold text-lg mb-2 flex items-center">
            <i class="fa-solid fa-star mr-2 text-accent-500"></i>Ratings
        </h2>
        <p class="text-sm text-gray-600">Coming soon...</p>
    </div>
</div>
@endsection
