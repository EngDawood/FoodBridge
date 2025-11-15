@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold"><i class="fa-solid fa-file-alt mr-2"></i>{{ $report->title }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.download', $report) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"><i class="fa-solid fa-download mr-1"></i>Download</a>
        <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-arrow-left mr-1"></i>Back</a>
    </div>
</div>

<div class="bg-white rounded shadow p-6 mb-4">
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-600"><i class="fa-solid fa-user-shield mr-1"></i>Created by</p>
            <p class="text-lg font-semibold">{{ $report->admin->name }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600"><i class="fa-solid fa-calendar mr-1"></i>Created at</p>
            <p class="text-lg font-semibold">{{ $report->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <div class="border-t pt-6">
        <h2 class="text-lg font-bold mb-3"><i class="fa-solid fa-align-left mr-1"></i>Content</h2>
        <div class="bg-gray-50 p-4 rounded whitespace-pre-wrap text-sm">{{ $report->content }}</div>
    </div>
</div>

@endsection
