@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold">
        <i class="fa-solid fa-tasks mr-2"></i>Available delivery tasks
    </h1>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
        <button class="px-4 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors min-h-[44px]">
            <i class="fa-solid fa-rotate mr-2"></i>Refresh
        </button>
        <a href="/volunteer/tasks" class="px-4 py-2 text-sm rounded-lg bg-primary-700 hover:bg-primary-800 text-white transition-colors min-h-[44px] flex items-center justify-center">
            <i class="fa-solid fa-clipboard-check mr-2"></i>Go to My Tasks
        </a>
    </div>
</div>

<div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold">Tasks list</h2>
        <div class="text-sm text-gray-500 hidden sm:block">View as list / map (later)</div>
    </div>

    <!-- Mobile Card View -->
    <div class="block lg:hidden space-y-4">
        @forelse(($availableTasks ?? []) as $task)
        <div class="border border-gray-200 rounded-lg p-4 space-y-3">
            <div class="font-semibold text-lg">
                <i class="fa-solid fa-hand-holding-heart mr-1 text-primary-700"></i>
                {{ optional($task->donation)->id ? 'Donation #' . $task->donation->id : '—' }}
            </div>
            <div class="text-sm text-gray-600 space-y-1">
                <div><i class="fa-solid fa-location-dot fa-fw mr-1"></i><strong>Pickup:</strong> {{ $task->pickup_location }}</div>
                <div><i class="fa-solid fa-location-dot fa-fw mr-1"></i><strong>Drop-off:</strong> {{ $task->dropoff_location }}</div>
                <div><span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium">{{ $task->status }}</span></div>
            </div>
            <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}" class="pt-2 border-t">
                @csrf
                <button type="submit" class="w-full bg-accent-500 hover:bg-accent-600 text-white px-4 py-3 rounded-lg transition-colors min-h-[44px] font-medium">
                    <i class="fa-solid fa-hand mr-2"></i>Claim Task
                </button>
            </form>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <i class="fa-solid fa-inbox fa-3x mb-4 opacity-50"></i>
            <p>No tasks available right now</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b-2 border-gray-200">
                    <th class="py-3 px-2"><i class="fa-solid fa-hand-holding-heart mr-1"></i>Donation</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-location-dot mr-1"></i>Pickup location</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-location-dot mr-1"></i>Drop-off location</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                    <th class="py-3 px-2"><i class="fa-solid fa-hand mr-1"></i>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($availableTasks ?? []) as $task)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-2">{{ optional($task->donation)->id ? 'Donation #' . $task->donation->id : '—' }}</td>
                    <td class="py-3 px-2">{{ $task->pickup_location }}</td>
                    <td class="py-3 px-2">{{ $task->dropoff_location }}</td>
                    <td class="py-3 px-2"><span class="px-3 py-1 rounded-full bg-gray-100 text-xs font-medium">{{ $task->status }}</span></td>
                    <td class="py-3 px-2">
                        <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg bg-accent-500 hover:bg-accent-600 text-white transition-colors">
                                <i class="fa-solid fa-hand mr-1"></i>Claim
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="py-12 text-center text-gray-500" colspan="5">
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
