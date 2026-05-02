<div style="position: fixed; top: 0; left: 0; right: 0; z-index: 5000; padding: 16px 24px 16px; background: linear-gradient(to bottom, #F2F2F2, rgba(242, 242, 242, 0.95), transparent); pointer-events: none;">
    <div class="flex justify-between items-center pointer-events-auto">
        <!-- Left Side -->
        <div class="flex items-center space-x-3">
            {{ $left ?? '' }}
        </div>

        <!-- Center Side (Optional) -->
        @if(isset($center))
            <div class="flex items-center">
                {{ $center }}
            </div>
        @endif

        <!-- Right Side -->
        <div class="flex items-center space-x-3">
            {{ $right ?? '' }}
        </div>
    </div>
</div>
