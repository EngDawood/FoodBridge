@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
            <i class="fa-solid fa-clipboard-check mr-2"></i>My Tasks
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">Manage your delivery tasks and track progress</p>
    </div>
    <a href="/volunteer/available" class="px-6 py-3 rounded-lg bg-accent-500 hover:bg-accent-600 text-white transition-colors min-h-[44px] flex items-center justify-center font-medium shadow-lg">
        <i class="fa-solid fa-search mr-2"></i>Browse Available
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Tasks -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-500 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-tasks text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $totalTasks }}</div>
        <div class="text-primary-100 text-xs sm:text-sm">Total tasks</div>
    </div>

    <!-- Assigned Tasks -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-clock text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $assignedCount }}</div>
        <div class="text-yellow-100 text-xs sm:text-sm">Assigned</div>
    </div>

    <!-- In Progress -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-spinner text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $inProgressCount }}</div>
        <div class="text-blue-100 text-xs sm:text-sm">In progress</div>
    </div>

    <!-- Completed -->
    <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl shadow-lg p-4 sm:p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-2 sm:mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-2 sm:p-3">
                <i class="fa-solid fa-check-circle text-lg sm:text-2xl"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl font-bold mb-1">{{ $completedCount }}</div>
        <div class="text-green-100 text-xs sm:text-sm">Completed</div>
    </div>
</div>

<!-- Task Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
    <!-- Assigned Column -->
    <div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg border-t-4 border-yellow-500">
        <h2 class="font-semibold text-lg mb-4 flex items-center">
            <i class="fa-solid fa-clock text-yellow-500 mr-2"></i>Assigned
        </h2>
        <div class="space-y-3">
            @forelse(($grouped['assigned'] ?? []) as $task)
            <div class="border-2 rounded-lg p-3 space-y-2
                {{ $task->urgencyColor === 'red' ? 'border-red-300 bg-red-50' : ($task->urgencyColor === 'yellow' ? 'border-yellow-300 bg-yellow-50' : 'border-green-300 bg-green-50') }}">

                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $task->urgencyColor === 'red' ? 'bg-red-600 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white') }}">
                        <i class="fa-solid fa-flag mr-1"></i>{{ $task->urgencyLabel }}
                    </span>
                </div>

                <div class="text-sm font-semibold text-gray-800">
                    {{ optional($task->donation)->food_type ? \App\Helpers\FoodTypes::display($task->donation->food_type) : 'Food Delivery' }}
                </div>

                @if($task->donation && $task->donation->quantity)
                <div class="text-xs text-gray-600">
                    <i class="fa-solid fa-hashtag mr-1"></i>{{ $task->donation->quantity }} units
                </div>
                @endif

                <div class="text-xs text-gray-600 space-y-1">
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1 text-primary-600"></i>{{ $task->pickup_location }}</div>
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1 text-accent-600"></i>{{ $task->dropoff_location }}</div>
                </div>

                @if($task->donation && $task->donation->pickup_time)
                <div class="text-xs text-gray-700">
                    <i class="fa-solid fa-clock fa-fw mr-1"></i>{{ $task->donation->pickup_time->format('M d, h:i A') }}
                </div>
                @endif

                <form method="post" action="{{ route('volunteer.tasks.start', ['task' => $task->id]) }}" class="pt-2 border-t">
                    @csrf
                    <button class="w-full px-3 py-2 text-sm rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors font-medium">
                        <i class="fa-solid fa-play mr-1"></i>Start Task
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-inbox fa-2x mb-2 opacity-50"></i>
                <p class="text-sm">No assigned tasks</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- In Progress Column -->
    <div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg border-t-4 border-blue-500">
        <h2 class="font-semibold text-lg mb-4 flex items-center">
            <i class="fa-solid fa-spinner text-blue-500 mr-2"></i>In Progress
        </h2>
        <div class="space-y-3">
            @forelse(($grouped['in_progress'] ?? []) as $task)
            <div class="border-2 rounded-lg p-3 space-y-2
                {{ $task->urgencyColor === 'red' ? 'border-red-300 bg-red-50' : ($task->urgencyColor === 'yellow' ? 'border-yellow-300 bg-yellow-50' : 'border-green-300 bg-green-50') }}">

                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $task->urgencyColor === 'red' ? 'bg-red-600 text-white' : ($task->urgencyColor === 'yellow' ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white') }}">
                        <i class="fa-solid fa-flag mr-1"></i>{{ $task->urgencyLabel }}
                    </span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">
                        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i>Active
                    </span>
                </div>

                <div class="text-sm font-semibold text-gray-800">
                    {{ optional($task->donation)->food_type ? \App\Helpers\FoodTypes::display($task->donation->food_type) : 'Food Delivery' }}
                </div>

                @if($task->donation && $task->donation->quantity)
                <div class="text-xs text-gray-600">
                    <i class="fa-solid fa-hashtag mr-1"></i>{{ $task->donation->quantity }} units
                </div>
                @endif

                <div class="text-xs text-gray-600 space-y-1">
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1 text-primary-600"></i>{{ $task->pickup_location }}</div>
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1 text-accent-600"></i>{{ $task->dropoff_location }}</div>
                </div>

                <form method="post" action="{{ route('volunteer.tasks.complete', ['task' => $task->id]) }}" class="pt-2 border-t">
                    @csrf
                    <button class="w-full px-3 py-2 text-sm rounded-lg bg-green-600 hover:bg-green-700 text-white transition-colors font-medium">
                        <i class="fa-solid fa-check-circle mr-1"></i>Mark as Delivered
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-inbox fa-2x mb-2 opacity-50"></i>
                <p class="text-sm">No tasks in progress</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Completed Column -->
    <div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg border-t-4 border-green-500">
        <h2 class="font-semibold text-lg mb-4 flex items-center">
            <i class="fa-solid fa-check-circle text-green-500 mr-2"></i>Completed
        </h2>
        <div class="space-y-3 max-h-[600px] overflow-y-auto">
            @forelse(($grouped['completed'] ?? []) as $task)
            <div class="border border-gray-200 rounded-lg p-3 space-y-2 bg-gray-50">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                        <i class="fa-solid fa-check mr-1"></i>Done
                    </span>
                </div>

                <div class="text-sm font-semibold text-gray-700">
                    {{ optional($task->donation)->food_type ? \App\Helpers\FoodTypes::display($task->donation->food_type) : 'Food Delivery' }}
                </div>

                @if($task->donation && $task->donation->quantity)
                <div class="text-xs text-gray-600">
                    <i class="fa-solid fa-hashtag mr-1"></i>{{ $task->donation->quantity }} units
                </div>
                @endif

                <div class="text-xs text-gray-500 space-y-1">
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1"></i>{{ $task->pickup_location }}</div>
                    <div><i class="fa-solid fa-location-dot fa-fw mr-1"></i>{{ $task->dropoff_location }}</div>
                </div>

                <div class="text-xs text-green-600 font-medium pt-2 border-t">
                    <i class="fa-solid fa-circle-check mr-1"></i>Completed
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <i class="fa-solid fa-inbox fa-2x mb-2 opacity-50"></i>
                <p class="text-sm">No completed tasks yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
