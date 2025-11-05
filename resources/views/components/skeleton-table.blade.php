<!-- Skeleton Loading Table Component -->
<div class="bg-white rounded p-4 shadow animate-pulse">
    <div class="bg-gray-300 h-6 w-48 mb-4 rounded"></div>
    <div class="space-y-3">
        @for ($i = 0; $i < 5; $i++)
        <div class="flex gap-4">
            <div class="bg-gray-200 h-4 flex-1 rounded"></div>
            <div class="bg-gray-200 h-4 flex-1 rounded"></div>
            <div class="bg-gray-200 h-4 flex-1 rounded"></div>
            <div class="bg-gray-200 h-4 w-20 rounded"></div>
        </div>
        @endfor
    </div>
</div>
