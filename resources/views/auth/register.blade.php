@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 flex items-center">
        <i class="fa-solid fa-user-plus mr-2"></i>Create account
    </h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-user mr-1 text-primary-700"></i>Name
            </label>
            <input name="name" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-envelope mr-1 text-primary-700"></i>Email
            </label>
            <input name="email" type="email" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-lock mr-1 text-primary-700"></i>Password
            </label>
            <input name="password" type="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-user-tag mr-1 text-primary-700"></i>Role
            </label>
            <select name="role" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" required>
                <option value="donor" {{ old('role') === 'donor' ? 'selected' : '' }}>Donor</option>
                <option value="beneficiary" {{ old('role') === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                <option value="volunteer" {{ old('role') === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-location-dot mr-1 text-primary-700"></i>Location <span class="text-gray-500 font-normal">(optional)</span>
            </label>
            <input name="location" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" value="{{ old('location') }}">
        </div>
        <button class="w-full bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] font-medium">
            <i class="fa-solid fa-user-plus mr-2"></i>Sign up
        </button>
    </form>
</div>
@endsection


