@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold">
        <i class="fa-solid fa-clipboard-list mr-2"></i>My requests
    </h1>
    <a href="/requests/create" class="bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg transition-colors min-h-[44px] flex items-center justify-center font-medium">
        <i class="fa-solid fa-plus mr-2"></i>Create request
    </a>
</div>

<div class="mb-6 bg-white rounded-lg p-4 sm:p-6 shadow-lg">
    <h2 class="font-semibold mb-2 flex items-center">
        <i class="fa-solid fa-link text-accent-500 mr-2"></i>Matching donations
    </h2>
    <p class="text-sm text-gray-600">No matches right now. (Accept/confirm actions will be added later)</p>
</div>

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


