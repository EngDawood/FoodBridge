# Blade Components

This directory contains reusable Blade components for the FoodBridge application.

## Skeleton Loading Components

Skeleton components provide visual feedback while content is loading, improving perceived performance.

### skeleton-card.blade.php

A loading placeholder for card-based layouts (e.g., dashboard stat cards).

**Usage:**
```blade
<!-- While data is loading -->
@if($loading)
    @include('components.skeleton-card')
@else
    <!-- Actual card content -->
@endif
```

**Example in Dashboard:**
```blade
@if(!isset($totalUsers))
    @include('components.skeleton-card')
@else
    <div class="bg-gradient-to-br from-primary-900 to-primary-800 rounded-xl shadow-lg p-5 sm:p-6 text-white">
        <!-- Card content -->
    </div>
@endif
```

### skeleton-table.blade.php

A loading placeholder for table layouts (e.g., donations list, requests list).

**Usage:**
```blade
<!-- While data is loading -->
@if($loading)
    @include('components.skeleton-table')
@else
    <table class="w-full text-sm">
        <!-- Table content -->
    </table>
@endif
```

**Example in Donor Index:**
```blade
@if(!isset($donations))
    @include('components.skeleton-table')
@else
    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="w-full text-sm">
            <!-- Table rows -->
        </table>
    </div>
@endif
```

## Implementation Notes

### When to Use Skeleton Loaders

1. **Initial Page Load**: When fetching data from the server
2. **AJAX Requests**: When dynamically loading content without page refresh
3. **Infinite Scroll**: When loading more items in a list
4. **Slow Networks**: Particularly beneficial for users on slower connections

### Best Practices

- **Match Layout**: Skeleton should approximate the final content layout
- **Animation**: The `animate-pulse` class provides subtle pulsing animation
- **Accessibility**: Skeletons are purely visual and don't require ARIA labels
- **Duration**: Show for at least 300ms to avoid jarring flashes

### Future Enhancements

Consider creating skeletons for:
- Form inputs (skeleton-form.blade.php)
- Navigation items (skeleton-nav.blade.php)
- List items (skeleton-list-item.blade.php)
- Image placeholders (skeleton-image.blade.php)
