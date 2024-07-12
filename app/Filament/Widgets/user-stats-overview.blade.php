@props([
    'stats'
])

<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    @foreach ($stats as $stat)
        @if ($stat->label !== 'Current Time' && $stat->label !== 'Current Date' && $stat->label !== 'Current Day')
            <x-filament::stats-card
                :label="$stat->label"
                :value="$stat->value"
                :chart="$stat->chart"
                :color="$stat->color"
            />
        @elseif ($stat->label === 'Current Time')
            <div class="p-4 bg-primary text-white rounded-lg">
                <div class="text-sm">{{ $stat->label }}</div>
                <div id="live-clock" class="text-2xl">{{ $stat->value }}</div>
            </div>
        @elseif ($stat->label === 'Current Date')
            <div class="p-4 bg-primary text-white rounded-lg">
                <div class="text-sm">{{ $stat->label }}</div>
                <div id="live-date" class="text-2xl">{{ $stat->value }}</div>
            </div>
        @elseif ($stat->label === 'Current Day')
            <div class="p-4 bg-primary text-white rounded-lg">
                <div class="text-sm">{{ $stat->label }}</div>
                <div id="live-day" class="text-2xl">{{ $stat->value }}</div>
            </div>
        @endif
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const currentTime = `${hours}:${minutes}:${seconds}`;
            document.getElementById('live-clock').innerText = currentTime;
        }
        
        function updateDate() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            const day = String(now.getDate()).padStart(2, '0');
            const currentDate = `${year}-${month}-${day}`;
            document.getElementById('live-date').innerText = currentDate;
        }
        
        function updateDay() {
            const now = new Date();
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const currentDay = days[now.getDay()];
            document.getElementById('live-day').innerText = currentDay;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Initial call to set the clock immediately
        updateDate();  // Initial call to set the date immediately
        updateDay();   // Initial call to set the day immediately
    });
</script>
