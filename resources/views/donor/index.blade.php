@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
            <i class="fa-solid fa-hand-holding-heart mr-2"></i>Donor Dashboard
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">Track your donations and make a difference</p>
    </div>
    <a href="/donations/create" class="bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] flex items-center justify-center font-medium shadow-lg">
        <i class="fa-solid fa-plus mr-2"></i>Add donation
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Donations Card -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-500 rounded-xl shadow-lg p-5 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2.5 sm:p-3">
                <i class="fa-solid fa-hand-holding-heart text-xl sm:text-2xl"></i>
            </div>
            <span class="text-primary-100 text-xs font-semibold uppercase tracking-wider">Total</span>
        </div>
        <div class="text-3xl sm:text-4xl font-bold mb-1 sm:mb-2">{{ $totalDonations }}</div>
        <div class="text-primary-100 text-xs sm:text-sm">Total donations posted</div>
    </div>

    <!-- Active Donations Card -->
    <div class="bg-gradient-to-br from-accent-600 to-accent-400 rounded-xl shadow-lg p-5 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2.5 sm:p-3">
                <i class="fa-solid fa-clock text-xl sm:text-2xl"></i>
            </div>
            <span class="text-accent-100 text-xs font-semibold uppercase tracking-wider">Active</span>
        </div>
        <div class="text-3xl sm:text-4xl font-bold mb-1 sm:mb-2">{{ $activeDonations }}</div>
        <div class="text-accent-100 text-xs sm:text-sm">Currently active</div>
    </div>

    <!-- Completed Donations Card -->
    <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl shadow-lg p-5 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2.5 sm:p-3">
                <i class="fa-solid fa-check-circle text-xl sm:text-2xl"></i>
            </div>
            <span class="text-green-100 text-xs font-semibold uppercase tracking-wider">Completed</span>
        </div>
        <div class="text-3xl sm:text-4xl font-bold mb-1 sm:mb-2">{{ $completedDonations }}</div>
        <div class="text-green-100 text-xs sm:text-sm">Successfully delivered</div>
    </div>

    <!-- Average Rating Card -->
    <div class="bg-gradient-to-br from-yellow-500 to-orange-400 rounded-xl shadow-lg p-5 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2.5 sm:p-3">
                <i class="fa-solid fa-star text-xl sm:text-2xl"></i>
            </div>
            <span class="text-yellow-100 text-xs font-semibold uppercase tracking-wider">Rating</span>
        </div>
        <div class="text-3xl sm:text-4xl font-bold mb-1 sm:mb-2">{{ number_format($averageRating, 1) }}</div>
        <div class="text-yellow-100 text-xs sm:text-sm flex items-center">
            <span class="mr-1">Average rating</span>
            @for($i = 1; $i <= 5; $i++)
                <i class="fa-solid fa-star text-xs {{ $i <= round($averageRating) ? 'text-yellow-200' : 'text-yellow-300 opacity-30' }}"></i>
            @endfor
        </div>
    </div>
</div>

<div class="mb-6 bg-white rounded-lg p-4 sm:p-6 shadow-lg border-l-4 border-accent-500">
    <h2 class="font-semibold mb-3 flex items-center text-lg">
        <i class="fa-solid fa-bell text-accent-500 mr-2"></i>Recent Activity
    </h2>
    @if($pendingDonations->count() > 0)
    <div class="space-y-2">
        @foreach($pendingDonations as $pending)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
            <div class="flex items-center space-x-3">
                <div class="bg-accent-100 rounded-full p-2">
                    <i class="fa-solid fa-utensils text-accent-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">{{ \App\Helpers\FoodTypes::display($pending->food_type) }}</p>
                    <p class="text-xs text-gray-500">{{ $pending->quantity }} units • {{ $pending->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <a href="{{ route('donations.matches', $pending) }}" class="text-accent-600 hover:text-accent-700 text-sm font-medium">
                Find matches <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-sm text-gray-600">No pending donations. All caught up!</p>
    @endif
</div>

<div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-4 flex items-center">
        <i class="fa-solid fa-list text-primary-700 mr-2"></i>Donations list
    </h2>

    <!-- Mobile Card View -->
    <div class="block lg:hidden space-y-4">
        @forelse($donations as $donation)
        <div class="border border-gray-200 rounded-lg p-4 space-y-3">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="font-semibold text-lg mb-1">
                        <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>
                        {{ \App\Helpers\FoodTypes::display($donation->food_type) }}
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div><i class="fa-solid fa-hashtag mr-1"></i>Quantity: {{ $donation->quantity }}</div>
                        <div><i class="fa-solid fa-calendar mr-1"></i>Expires: {{ optional($donation->expiration_date)->format('Y-m-d') ?: '—' }}</div>
                        <div><i class="fa-solid fa-clock mr-1"></i>Pickup: {{ optional($donation->pickup_time)->format('Y-m-d H:i') ?: '—' }}</div>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium whitespace-nowrap">
                    {{ __($donation->status) }}
                </span>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 pt-3 border-t">
                <a href="{{ route('donations.edit', $donation) }}" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-colors min-h-[44px] flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Edit
                </a>
                <a href="{{ route('donations.matches', $donation) }}" class="flex-1 text-center bg-primary-50 hover:bg-primary-100 text-primary-800 px-4 py-2 rounded-lg transition-colors min-h-[44px] flex items-center justify-center">
                    <i class="fa-solid fa-link mr-2"></i>Matches
                </a>
                <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Delete donation?');" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg transition-colors min-h-[44px]">
                        <i class="fa-solid fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
            <p>No donations yet</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b-2 border-gray-200">
                    <th class="py-3 px-2"><i class="fa-solid fa-utensils mr-1"></i>Food</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-calendar mr-1"></i>Expires</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-clock mr-1"></i>Pickup time</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-gear mr-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-2">{{ \App\Helpers\FoodTypes::display($donation->food_type) }}</td>
                    <td class="py-3 px-2">{{ $donation->quantity }}</td>
                    <td class="py-3 px-2">{{ optional($donation->expiration_date)->format('Y-m-d') ?: '—' }}</td>
                    <td class="py-3 px-2">{{ optional($donation->pickup_time)->format('Y-m-d H:i') ?: '—' }}</td>
                    <td class="py-3 px-2"><span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium">{{ __($donation->status) }}</span></td>
                    <td class="py-3 px-2">
                        <div class="flex gap-2">
                            <a href="{{ route('donations.edit', $donation) }}" class="text-blue-600 hover:text-blue-800"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                            <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Delete donation?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                            </form>
                            <a href="{{ route('donations.matches', $donation) }}" class="text-primary-800 hover:text-primary-900"><i class="fa-solid fa-link mr-1"></i>Matches</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-500">
                        <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
                        <p>No donations yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $donations->links() }}</div>
</div>
@endsection


