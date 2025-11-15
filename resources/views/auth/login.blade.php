@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 flex items-center">
        <i class="fa-solid fa-right-to-bracket mr-2"></i>Log in
    </h1>
    @php($chosenRole = $role ?? null)
    @if(!$chosenRole)
        <div class="mb-6 grid grid-cols-2 gap-2 text-sm">
            <a class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors text-center min-h-[44px] flex items-center justify-center @if(request()->is('login/admin')) bg-gray-100 font-medium @endif" href="{{ route('login.role', ['role' => 'admin']) }}">Admin</a>
            <a class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors text-center min-h-[44px] flex items-center justify-center @if(request()->is('login/donor')) bg-gray-100 font-medium @endif" href="{{ route('login.role', ['role' => 'donor']) }}">Donor</a>
            <a class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors text-center min-h-[44px] flex items-center justify-center @if(request()->is('login/beneficiary')) bg-gray-100 font-medium @endif" href="{{ route('login.role', ['role' => 'beneficiary']) }}">Beneficiary</a>
            <a class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors text-center min-h-[44px] flex items-center justify-center @if(request()->is('login/volunteer')) bg-gray-100 font-medium @endif" href="{{ route('login.role', ['role' => 'volunteer']) }}">Volunteer</a>
        </div>
    @else
        <div class="mb-6 text-sm bg-primary-50 border border-primary-200 rounded-lg p-3">
            <span class="text-primary-900">Logging in as <strong>{{ ucfirst($chosenRole) }}</strong></span>
            <a class="ml-2 text-primary-700 hover:text-primary-900 underline font-medium" href="{{ route('login') }}">Switch role</a>
        </div>
    @endif
    @if($chosenRole && $errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ $chosenRole ? route('login.role.post', ['role' => $chosenRole]) : route('login.post') }}" @if(!$chosenRole) style="display: none;" @endif>
        @csrf
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-envelope mr-1 text-primary-700"></i>Email
            </label>
            <input name="email" type="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" required>
            @error('email')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fa-solid fa-lock mr-1 text-primary-700"></i>Password
            </label>
            <div class="relative">
                <input id="login-password" name="password" type="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" required>
                <button type="button" id="login-password-toggle" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6 flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" class="rounded w-4 h-4 text-primary-700 focus:ring-primary-500">
            <label for="remember" class="text-sm text-gray-700 select-none cursor-pointer">Remember me</label>
        </div>
        <button class="w-full bg-primary-700 hover:bg-primary-800 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] font-medium">
            <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign in
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginPasswordInput = document.getElementById('login-password');
    const loginPasswordToggle = document.getElementById('login-password-toggle');

    if (loginPasswordToggle && loginPasswordInput) {
        loginPasswordToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isPassword = loginPasswordInput.type === 'password';
            loginPasswordInput.type = isPassword ? 'text' : 'password';

            const icon = loginPasswordToggle.querySelector('i');
            if (isPassword) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
});
</script>
@endpush
