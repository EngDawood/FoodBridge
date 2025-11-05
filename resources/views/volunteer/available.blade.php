@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
            <i class="fa-solid fa-tasks mr-2"></i>Available Delivery Tasks
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">Claim tasks and help deliver food to those in need</p>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <a href="/volunteer/tasks" class="px-6 py-3 rounded-lg bg-primary-700 hover:bg-primary-800 text-white transition-colors min-h-[44px] flex items-center justify-center font-medium shadow-lg">
            <i class="fa-solid fa-clipboard-check mr-2"></i>My Tasks
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Available -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-500 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-tasks text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $totalAvailable }}</div>
        <div class="text-primary-100 text-xs sm:text-sm">Available tasks</div>
    </div>

    <!-- High Priority -->
    <div class="bg-gradient-to-br from-red-600 to-red-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-exclamation-triangle text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $highPriority }}</div>
        <div class="text-red-100 text-xs sm:text-sm">Urgent</div>
    </div>

    <!-- Medium Priority -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-clock text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $mediumPriority }}</div>
        <div class="text-yellow-100 text-xs sm:text-sm">Medium</div>
    </div>

    <!-- Low Priority -->
    <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-check-circle text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $lowPriority }}</div>
        <div class="text-green-100 text-xs sm:text-sm">Low</div>
    </div>
</div>

<div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold text-lg">
            <i class="fa-solid fa-list text-primary-700 mr-2"></i>Tasks List
        </h2>
        <div class="text-sm text-gray-500">Sorted by urgency</div>
    </div>

    <!-- Mobile Card View -->
    <div class="block lg:hidden space-y-4">
        @forelse(($availableTasks ?? []) as $task)
        <div class="border-2 rounded-lg p-4 space-y-3
            {{ $task->urgencyColor === 'red' ? 'border-red-400 bg-red-50' : ($task->urgencyColor === 'yellow' ? 'border-yellow-400 bg-yellow-50' : 'border-green-400 bg-green-50') }}">

            <!-- Priority Badge -->
            <div class="flex items-center justify-between">
                <span class="px-3 py-1 rounded-full text-xs font-bold
                    {{ $task->urgencyColor === 'red' ? 'bg-red-600 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white') }}">
                    <i class="fa-solid fa-flag mr-1"></i>{{ $task->urgencyLabel }} Priority
                </span>
                <span class="text-xs text-gray-600">Score: {{ $task->priority }}/10</span>
            </div>

            <div class="font-semibold text-lg">
                <i class="fa-solid fa-box mr-1 text-primary-700"></i>
                {{ optional($task->donation)->food_type ? \App\Helpers\FoodTypes::display($task->donation->food_type) : 'Food Delivery' }}
            </div>

            <div class="text-sm space-y-2">
                @if($task->donation && $task->donation->quantity)
                <div class="text-gray-700">
                    <i class="fa-solid fa-hashtag fa-fw mr-1"></i><strong>Quantity:</strong> {{ $task->donation->quantity }} units
                </div>
                @endif

                <div class="text-gray-700">
                    <i class="fa-solid fa-location-dot fa-fw mr-1 text-primary-600"></i><strong>Pickup:</strong> {{ $task->pickup_location }}
                </div>
                <div class="text-gray-700">
                    <i class="fa-solid fa-location-dot fa-fw mr-1 text-accent-600"></i><strong>Drop-off:</strong> {{ $task->dropoff_location }}
                </div>

                @if($task->donation && $task->donation->pickup_time)
                <div class="text-gray-700">
                    <i class="fa-solid fa-clock fa-fw mr-1"></i><strong>Pickup Time:</strong> {{ $task->donation->pickup_time->format('M d, h:i A') }}
                    <span class="text-xs">({{ $task->donation->pickup_time->diffForHumans() }})</span>
                </div>
                @endif
            </div>

            <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}" class="pt-3 border-t">
                @csrf
                <button type="submit" class="w-full px-4 py-3 rounded-lg transition-colors min-h-[44px] font-medium
                    {{ $task->urgencyColor === 'red' ? 'bg-red-600 hover:bg-red-700 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-green-600 hover:bg-green-700 text-white') }}">
                    <i class="fa-solid fa-hand mr-2"></i>Claim This Task
                </button>
            </form>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
            <p>No tasks available right now</p>
            <p class="text-sm mt-2">Check back later for new delivery opportunities</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b-2 border-gray-200">
                    <th class="py-3 px-2"><i class="fa-solid fa-flag mr-1"></i>Priority</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-utensils mr-1"></i>Food Type</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-hashtag mr-1"></i>Qty</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-location-dot mr-1"></i>Pickup</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-location-dot mr-1"></i>Drop-off</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-clock mr-1"></i>Pickup Time</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-hand mr-1"></i>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($availableTasks ?? []) as $task)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $task->urgencyColor === 'red' ? 'bg-red-600 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white') }}">
                            {{ $task->urgencyLabel }}
                        </span>
                    </td>
                    <td class="py-3 px-2 font-medium">{{ optional($task->donation)->food_type ? \App\Helpers\FoodTypes::display($task->donation->food_type) : '—' }}</td>
                    <td class="py-3 px-2">{{ optional($task->donation)->quantity ?? '—' }}</td>
                    <td class="py-3 px-2">{{ $task->pickup_location }}</td>
                    <td class="py-3 px-2">{{ $task->dropoff_location }}</td>
                    <td class="py-3 px-2">
                        @if($task->donation && $task->donation->pickup_time)
                            {{ $task->donation->pickup_time->format('M d, h:i A') }}
                            <div class="text-xs text-gray-500">{{ $task->donation->pickup_time->diffForHumans() }}</div>
                        @else
                            —
                        @endif
                    </td>
                    <td class="py-3 px-2">
                        <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg transition-colors
                                {{ $task->urgencyColor === 'red' ? 'bg-red-600 hover:bg-red-700 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-green-600 hover:bg-green-700 text-white') }}">
                                <i class="fa-solid fa-hand mr-1"></i>Claim
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="py-12 text-center text-gray-500" colspan="7">
                        <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
                        <p>No tasks available right now</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
