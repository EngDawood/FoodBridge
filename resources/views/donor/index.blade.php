@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold">
        <i class="fa-solid fa-hand-holding-heart mr-2"></i>My donations
    </h1>
    <a href="/donations/create" class="bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] flex items-center justify-center font-medium">
        <i class="fa-solid fa-plus mr-2"></i>Add donation
    </a>
</div>

<div class="mb-6 bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-2 flex items-center">
        <i class="fa-solid fa-bell text-accent-500 mr-2"></i>Matching alerts
    </h2>
    <p class="text-sm text-gray-600">No alerts right now.</p>
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


