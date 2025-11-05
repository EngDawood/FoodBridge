@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
    <h1 class="text-xl sm:text-2xl font-bold mb-6 flex items-center">
        <i class="fa-solid fa-plus mr-2"></i>Add donation
    </h1>
    <form method="POST" action="{{ route('donations.store') }}">
        @csrf
        <div class="flex flex-col space-y-4 md:space-y-0 md:grid md:grid-cols-2 md:gap-4">
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>Food type
                </label>
                <select name="food_type" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" required>
                    <option value="">Select food type</option>
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-hashtag mr-1 text-primary-700"></i>Quantity
                </label>
                <input name="quantity" type="number" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all" min="1" required>
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-calendar mr-1 text-primary-700"></i>Expiration date
                </label>
                <input name="expiration_date" type="date" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-clock mr-1 text-primary-700"></i>Pickup time
                </label>
                <input name="pickup_time" type="datetime-local" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>
        </div>
        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <button class="w-full sm:w-auto bg-primary-700 hover:bg-primary-800 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] font-medium">
                <i class="fa-solid fa-floppy-disk mr-2"></i>Save
            </button>
            <a href="/donations" class="w-full sm:w-auto text-center px-6 py-3 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors min-h-[44px] flex items-center justify-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection


