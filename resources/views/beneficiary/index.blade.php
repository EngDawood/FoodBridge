@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
            <i class="fa-solid fa-clipboard-list mr-2"></i>Beneficiary Dashboard
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">Track your food requests and get notified</p>
    </div>
    <a href="/requests/create" class="bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] flex items-center justify-center font-medium shadow-lg">
        <i class="fa-solid fa-plus mr-2"></i>Create request
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Requests -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-500 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-clipboard-list text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $totalRequests }}</div>
        <div class="text-primary-100 text-xs sm:text-sm">Total requests</div>
    </div>

    <!-- Pending Requests -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-clock text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $pendingRequests }}</div>
        <div class="text-yellow-100 text-xs sm:text-sm">Pending</div>
    </div>

    <!-- Matched Requests -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-link text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $matchedRequests }}</div>
        <div class="text-blue-100 text-xs sm:text-sm">Matched</div>
    </div>

    <!-- Fulfilled Requests -->
    <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-check-circle text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $fulfilledRequests }}</div>
        <div class="text-green-100 text-xs sm:text-sm">Fulfilled</div>
    </div>
</div>

<!-- Request Tracking Timeline -->
<div class="mb-6 bg-white rounded-lg p-4 sm:p-6 shadow-lg border-l-4 border-primary-500">
    <h2 class="font-semibold mb-4 flex items-center text-lg">
        <i class="fa-solid fa-timeline text-primary-700 mr-2"></i>Request Progress Tracker
    </h2>
    @if($requests->where('status', '!=', 'fulfilled')->count() > 0)
    <div class="space-y-4">
        @foreach($requests->where('status', '!=', 'fulfilled')->take(3) as $request)
        <div class="border-l-4 {{ $request->status === 'pending' ? 'border-yellow-400' : ($request->status === 'matched' ? 'border-blue-400' : 'border-green-400') }} pl-4 py-2">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-gray-800">{{ \App\Helpers\FoodTypes::display($request->food_type) }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-medium
                    {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($request->status === 'matched' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                    {{ ucfirst($request->status) }}
                </span>
            </div>

            <!-- Progress Bar -->
            <div class="relative pt-1">
                <div class="flex mb-2 items-center justify-between">
                    <div class="text-xs text-gray-600">Progress</div>
                    <div class="text-xs font-semibold text-gray-700">
                        {{ $request->status === 'pending' ? '33%' : ($request->status === 'matched' ? '66%' : '100%') }}
                    </div>
                </div>
                <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-200">
                    <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center
                        {{ $request->status === 'pending' ? 'bg-yellow-400 w-1/3' : ($request->status === 'matched' ? 'bg-blue-500 w-2/3' : 'bg-green-500 w-full') }}">
                    </div>
                </div>
            </div>

            <!-- Status Steps -->
            <div class="flex justify-between mt-3 text-xs">
                <div class="flex items-center {{ $request->status !== 'pending' ? 'text-green-600' : 'text-gray-500' }}">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    <span>Requested</span>
                </div>
                <div class="flex items-center {{ $request->status === 'matched' || $request->status === 'scheduled' ? 'text-blue-600' : 'text-gray-400' }}">
                    <i class="fa-solid {{ $request->status === 'matched' || $request->status === 'scheduled' ? 'fa-circle-check' : 'fa-circle' }} mr-1"></i>
                    <span>Matched</span>
                </div>
                <div class="flex items-center {{ $request->status === 'fulfilled' ? 'text-green-600' : 'text-gray-400' }}">
                    <i class="fa-solid {{ $request->status === 'fulfilled' ? 'fa-circle-check' : 'fa-circle' }} mr-1"></i>
                    <span>Delivered</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-sm text-gray-600">No active requests to track.</p>
    @endif
</div>

<!-- Upcoming Pickups -->
@if($upcomingPickups->count() > 0)
<div class="mb-6 bg-gradient-to-r from-blue-50 to-primary-50 rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-4 flex items-center text-lg">
        <i class="fa-solid fa-calendar-check text-blue-600 mr-2"></i>Upcoming Scheduled Pickups
    </h2>
    <div class="space-y-3">
        @foreach($upcomingPickups as $pickup)
        <div class="bg-white rounded-lg p-4 shadow border-l-4 border-blue-500">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800 mb-1">{{ \App\Helpers\FoodTypes::display($pickup->food_type) }}</h3>
                    <p class="text-sm text-gray-600">
                        <i class="fa-solid fa-box mr-1"></i>{{ $pickup->quantity }} units
                    </p>
                    @if($pickup->donation && $pickup->donation->pickup_time)
                    <p class="text-sm text-blue-600 mt-2">
                        <i class="fa-solid fa-clock mr-1"></i>
                        Pickup: {{ $pickup->donation->pickup_time->format('M d, Y h:i A') }}
                        <span class="text-xs text-gray-500">({{ $pickup->donation->pickup_time->diffForHumans() }})</span>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Match Suggestions -->
@if(count($matchSuggestions) > 0)
<div class="mb-6 bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-4 flex items-center text-lg">
        <i class="fa-solid fa-magic text-accent-500 mr-2"></i>Available Matches for Your Requests
    </h2>
    <div class="space-y-4">
        @foreach($matchSuggestions as $suggestion)
        <div class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 mb-3">
                <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>
                {{ \App\Helpers\FoodTypes::display($suggestion['request']->food_type) }}
                <span class="text-sm text-gray-500">({{ $suggestion['request']->quantity }} units needed)</span>
            </h3>
            <div class="space-y-2">
                @foreach($suggestion['matches']->take(2) as $match)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700">
                            {{ $match->quantity }} units available
                            @if($match->donor)
                            • From {{ $match->donor->name }}
                            @endif
                        </p>
                        @if($match->donor && $match->donor->location)
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fa-solid fa-location-dot mr-1"></i>{{ $match->donor->location }}
                        </p>
                        @endif
                    </div>
                    <a href="{{ route('requests.matches', $suggestion['request']) }}" class="ml-3 px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white text-sm rounded-lg transition-colors">
                        View
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-4 flex items-center">
        <i class="fa-solid fa-list text-primary-700 mr-2"></i>Requests list
    </h2>

    <!-- Mobile Card View -->
    <div class="block lg:hidden space-y-4">
        @forelse($requests as $request)
        <div class="border border-gray-200 rounded-lg p-4 space-y-3">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="font-semibold text-lg mb-1">
                        <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>
                        {{ \App\Helpers\FoodTypes::display($request->food_type) }}
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div><i class="fa-solid fa-hashtag mr-1"></i>Quantity: {{ $request->quantity }}</div>
                        @if($request->note)
                        <div class="mt-2">
                            <i class="fa-solid fa-sticky-note mr-1"></i>
                            <span class="italic text-gray-500">{{ $request->note }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium whitespace-nowrap">
                    {{ __($request->status) }}
                </span>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 pt-3 border-t">
                <a href="{{ route('requests.edit', $request) }}" class="flex-1 text-center bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg transition-colors min-h-[44px] flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Edit
                </a>
                <a href="{{ route('requests.matches', $request) }}" class="flex-1 text-center bg-primary-50 hover:bg-primary-100 text-primary-800 px-4 py-2 rounded-lg transition-colors min-h-[44px] flex items-center justify-center">
                    <i class="fa-solid fa-eye mr-2"></i>Matches
                </a>
                <form method="POST" action="{{ route('requests.destroy', $request) }}" onsubmit="return confirm('Delete request?');" class="flex-1">
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
            <p>No requests yet</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b-2 border-gray-200">
                    <th class="py-3 px-2"><i class="fa-solid fa-utensils mr-1"></i>Food type</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-sticky-note mr-1"></i>Note</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-gear mr-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-2">{{ \App\Helpers\FoodTypes::display($request->food_type) }}</td>
                    <td class="py-3 px-2">{{ $request->quantity }}</td>
                    <td class="py-3 px-2">{{ $request->note ?: '—' }}</td>
                    <td class="py-3 px-2"><span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium">{{ __($request->status) }}</span></td>
                    <td class="py-3 px-2">
                        <div class="flex gap-2">
                            <a href="{{ route('requests.edit', $request) }}" class="text-blue-600 hover:text-blue-800"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                            <form method="POST" action="{{ route('requests.destroy', $request) }}" onsubmit="return confirm('Delete request?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                            </form>
                            <a href="{{ route('requests.matches', $request) }}" class="text-primary-800 hover:text-primary-900"><i class="fa-solid fa-eye mr-1"></i>View matching donations</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-500">
                        <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
                        <p>No requests yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $requests->links() }}</div>
</div>
@endsection


