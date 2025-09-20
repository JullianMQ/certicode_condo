{{-- Certicode Condo Dashboard - Main Overview Page --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard - Certicode Condo')

@section('dashboard-content')
<div class="pt-6 px-4">
    {{-- Maintenance Efficiency Dashboard --}}
    @php
        $maintenanceStats = [
            'submitted' => count(array_filter($maintenance, fn($m) => $m['status'] === 'Submitted')),
            'assigned' => count(array_filter($maintenance, fn($m) => $m['status'] === 'Assigned')),
            'in_progress' => count(array_filter($maintenance, fn($m) => $m['status'] === 'In Progress')),
            'resolved' => count(array_filter($maintenance, fn($m) => $m['status'] === 'Resolved')),
            'total' => count($maintenance)
        ];

        // Calculate efficiency metrics
        $resolvedPercentage = $maintenanceStats['total'] > 0 ? round(($maintenanceStats['resolved'] / $maintenanceStats['total']) * 100, 1) : 0;
        $activeRequests = $maintenanceStats['submitted'] + $maintenanceStats['assigned'] + $maintenanceStats['in_progress'];

        // Generate daily data based on actual maintenance submission dates
        $dailyData = [];

        // Group requests by submission date
        $requestsByDate = [];
        foreach ($maintenance as $request) {
            $date = \Carbon\Carbon::parse($request['submitted_at'])->format('Y-m-d');
            if (!isset($requestsByDate[$date])) {
                $requestsByDate[$date] = [];
            }
            $requestsByDate[$date][] = $request;
        }

        // Create chart data for the actual dates with data
        $dates = ['2025-09-13', '2025-09-14', '2025-09-15', '2025-09-16'];

        foreach ($dates as $date) {
            $dayRequests = $requestsByDate[$date] ?? [];
            $dayResolved = array_filter($dayRequests, function($request) {
                return $request['status'] === 'Resolved';
            });

            $carbonDate = \Carbon\Carbon::parse($date);
            $dailyData[] = [
                'week' => $carbonDate->format('M j'),
                'requests' => count($dayRequests),
                'resolved' => count($dayResolved),
                'date' => $carbonDate->format('M j'),
                'dayName' => $carbonDate->format('D')
            ];
        }

        // Add empty days to make 7 total for better chart layout
        while (count($dailyData) < 7) {
            $dailyData[] = [
                'week' => '-',
                'requests' => 0,
                'resolved' => 0,
                'date' => '',
                'dayName' => ''
            ];
        }

        $weeklyData = $dailyData;
    @endphp

    {{-- Maintenance Efficiency Chart + Recent Maintenance --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
        {{-- Main Maintenance Efficiency Chart (3/4 width) --}}
        <div class="lg:col-span-3 bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                <div class="mb-3 sm:mb-0">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">Maintenance Efficiency</h2>
                    <p class="text-sm sm:text-base font-normal text-gray-500">Equipment monitoring and request resolution tracking</p>
                </div>
                <div class="flex items-center text-green-500 text-base sm:text-lg font-bold">
                    {{ $resolvedPercentage }}% Resolved
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            {{-- Chart Area --}}
            <div class="relative">
                @php
                    $maxRequests = max(array_column($weeklyData, 'requests'));
                    $chartScale = max($maxRequests, 4); // Use actual max or 4, whichever is higher
                @endphp

                {{-- Mobile: Horizontal scroll, Desktop: Full width --}}
                <div class="overflow-x-auto pb-2">
                    <div class="flex items-end justify-between h-40 sm:h-48 lg:h-64 mb-4 min-w-80 sm:min-w-0 px-2 sm:px-4">
                        @foreach($weeklyData as $index => $data)
                            <div class="flex flex-col items-center flex-1 group min-w-0">
                                <div class="relative w-full max-w-6 sm:max-w-8 lg:max-w-12 mx-1">
                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-10">
                                        {{ $data['resolved'] }}/{{ $data['requests'] }} resolved
                                        @if(isset($data['date']) && $data['date'])
                                            <br>{{ $data['date'] }}
                                        @endif
                                    </div>

                                    @if($data['requests'] > 0)
                                        {{-- Always show a container for the bar --}}
                                        <div class="w-full h-full flex flex-col justify-end">
                                            {{-- Resolved requests bar (dark cyan) --}}
                                            @if($data['resolved'] > 0)
                                                <div class="bg-cyan-500 transition-all duration-300 hover:bg-cyan-600 cursor-pointer {{ ($data['requests'] - $data['resolved']) > 0 ? 'rounded-t-lg' : 'rounded-lg' }}"
                                                     style="height: {{ max(($data['resolved'] / $chartScale) * 120, 15) }}px; min-height: 15px;"
                                                     title="Resolved: {{ $data['resolved'] }}">
                                                </div>
                                            @endif

                                            {{-- Pending requests bar (light cyan) --}}
                                            @if(($data['requests'] - $data['resolved']) > 0)
                                                <div class="bg-cyan-200 transition-all duration-300 hover:bg-cyan-300 cursor-pointer {{ $data['resolved'] > 0 ? 'rounded-b-lg' : 'rounded-lg' }}"
                                                     style="height: {{ max((($data['requests'] - $data['resolved']) / $chartScale) * 120, 15) }}px; min-height: 15px;"
                                                     title="Pending: {{ $data['requests'] - $data['resolved'] }}">
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        {{-- Empty state bar --}}
                                        <div class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300"
                                             style="height: 8px"
                                             title="No requests this day">
                                        </div>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-2 text-center min-w-0">
                                    <div class="font-medium truncate">{{ $data['week'] }}</div>
                                    @if(isset($data['dayName']) && $data['dayName'])
                                        <div class="text-xs text-gray-400 hidden sm:block">{{ $data['dayName'] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex items-center justify-center space-x-4 sm:space-x-6 mt-4 pt-2 border-t border-gray-100">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-cyan-500 rounded mr-2"></div>
                    <span class="text-xs sm:text-sm text-gray-600">Resolved</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-cyan-200 rounded mr-2"></div>
                    <span class="text-xs sm:text-sm text-gray-600">Pending</span>
                </div>
            </div>
        </div>

        {{-- Recent Maintenance Requests (1/4 width) --}}
        <div class="lg:col-span-1 bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Recent Maintenance</h3>
                    <span class="text-sm font-normal text-gray-500">Latest requests</span>
                </div>
            </div>
            {{-- Maintenance Requests List --}}
            <div class="space-y-3">
                @foreach(array_slice($maintenance, 0, 4) as $request)
                <div class="border-l-4 border-cyan-500 pl-3 py-2">
                    <div class="text-sm font-medium text-gray-900 truncate">{{ $request['title'] }}</div>
                    <div class="text-xs text-gray-500 mb-1">Unit {{ $request['unit_id'] }}</div>
                    @php
                        $statusColors = [
                            'Resolved' => 'bg-green-100 text-green-800',
                            'In Progress' => 'bg-yellow-100 text-yellow-800',
                            'Assigned' => 'bg-blue-100 text-blue-800',
                            'Submitted' => 'bg-gray-100 text-gray-800'
                        ];
                        $colorClass = $statusColors[$request['status']] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="{{ $colorClass }} text-xs font-medium px-2 py-1 rounded">
                        {{ $request['status'] }}
                    </span>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('maintenance.index') }}" class="text-sm font-medium text-cyan-600 hover:text-cyan-700">View all →</a>
            </div>
        </div>
    </div>

    {{-- Maintenance Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Active Requests --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ $activeRequests }}</span>
                    <h3 class="text-base font-normal text-gray-500">Active Requests</h3>
                </div>
                <div class="flex items-center text-orange-500 text-sm font-bold">
                    {{ $maintenanceStats['total'] > 0 ? round(($activeRequests / $maintenanceStats['total']) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ $maintenanceStats['in_progress'] }}</span>
                    <h3 class="text-base font-normal text-gray-500">In Progress</h3>
                </div>
                <div class="flex items-center text-blue-500 text-sm font-bold">
                    {{ $maintenanceStats['total'] > 0 ? round(($maintenanceStats['in_progress'] / $maintenanceStats['total']) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>

        {{-- Completed This Week --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ $maintenanceStats['resolved'] }}</span>
                    <h3 class="text-base font-normal text-gray-500">Completed</h3>
                </div>
                <div class="flex items-center text-green-500 text-sm font-bold">
                    {{ $resolvedPercentage }}%
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Average Resolution Time --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">2.3</span>
                    <h3 class="text-base font-normal text-gray-500">Avg Days to Resolve</h3>
                </div>
                <div class="flex items-center text-green-500 text-sm font-bold">
                    -15%
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 15.586V3a1 1 0 012 0v12.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Equipment Monitoring Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        {{-- Equipment Failure Frequency --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Equipment Issues</h3>
                <span class="text-sm text-gray-500">This Month</span>
            </div>

            @php
                $equipmentIssues = [
                    ['name' => 'Elevators', 'count' => 3, 'color' => 'bg-red-500', 'category' => 'Building Amenities'],
                    ['name' => 'Air Conditioning', 'count' => 2, 'color' => 'bg-orange-500', 'category' => 'General Maintenance'],
                    ['name' => 'Plumbing', 'count' => 2, 'color' => 'bg-blue-500', 'category' => 'Plumbing and Water'],
                    ['name' => 'Electrical', 'count' => 1, 'color' => 'bg-yellow-500', 'category' => 'General Maintenance']
                ];
                $totalIssues = array_sum(array_column($equipmentIssues, 'count'));
            @endphp

            <div class="space-y-3">
                @foreach($equipmentIssues as $equipment)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 {{ $equipment['color'] }} rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-900">{{ $equipment['name'] }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-gray-900 mr-2">{{ $equipment['count'] }}</span>
                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                <div class="{{ $equipment['color'] }} h-2 rounded-full"
                                     style="width: {{ $totalIssues > 0 ? ($equipment['count'] / $totalIssues) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Resolution Time Trends --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Resolution Times</h3>
                <span class="text-sm text-green-500 font-medium">↓ 15% faster</span>
            </div>

            @php
                $resolutionTimes = [
                    ['category' => 'Plumbing', 'avgDays' => 1.5, 'trend' => 'down'],
                    ['category' => 'Electrical', 'avgDays' => 2.1, 'trend' => 'down'],
                    ['category' => 'HVAC', 'avgDays' => 3.2, 'trend' => 'up'],
                    ['category' => 'Elevators', 'avgDays' => 4.8, 'trend' => 'down']
                ];
            @endphp

            <div class="space-y-4">
                @foreach($resolutionTimes as $category)
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $category['category'] }}</div>
                            <div class="text-xs text-gray-500">Average resolution time</div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-lg font-bold text-gray-900 mr-2">{{ $category['avgDays'] }}d</span>
                            @if($category['trend'] === 'down')
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 15.586V3a1 1 0 012 0v12.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Combined Overview Section - Units & Recent Activity --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        {{-- Total Units Overview Card --}}
        <div class="xl:col-span-1 bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="text-3xl leading-none font-bold text-gray-900">{{ count($condos) }}</span>
                    <h3 class="text-base font-normal text-gray-500 mt-1">Total Condo Units</h3>
                </div>
                <div class="text-right">
                    <div class="flex items-center text-green-500 text-lg font-bold">
                        {{ count(array_filter($condos, fn($condo) => $condo['status'] === 'Occupied')) }} Occupied
                        <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ round((count(array_filter($condos, fn($condo) => $condo['status'] === 'Occupied')) / count($condos)) * 100, 1) }}% Occupancy Rate
                    </div>
                </div>
            </div>

            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-cyan-50 rounded-lg p-3 text-center">
                    <div class="text-xl font-bold text-cyan-900">{{ count($bookings) }}</div>
                    <div class="text-xs text-cyan-700">Active Bookings</div>
                </div>
                <div class="bg-orange-50 rounded-lg p-3 text-center">
                    <div class="text-xl font-bold text-orange-900">{{ count(array_filter($maintenance, fn($m) => $m['status'] === 'In Progress')) }}</div>
                    <div class="text-xs text-orange-700">Pending Maintenance</div>
                </div>
            </div>

            {{-- Units by Building Compact Table --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Units by Building</h4>
                <div class="space-y-2">
                    @php
                        $buildings = [];
                        foreach($condos as $condo) {
                            $building = $condo['building'];
                            if (!isset($buildings[$building])) {
                                $buildings[$building] = ['total' => 0, 'occupied' => 0];
                            }
                            $buildings[$building]['total']++;
                            if ($condo['status'] === 'Occupied') {
                                $buildings[$building]['occupied']++;
                            }
                        }
                    @endphp
                    @foreach($buildings as $building => $stats)
                    <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $building }}</div>
                        <div class="flex items-center space-x-3 text-sm">
                            <span class="font-medium text-gray-900">{{ $stats['total'] }}</span>
                            <span class="text-green-600 font-medium">{{ $stats['occupied'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Bookings Card --}}
        <div class="xl:col-span-2 bg-white shadow rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold leading-none text-gray-900">Recent Bookings</h3>
                    <p class="text-sm text-gray-500 mt-1">Latest amenity reservations and activity</p>
                </div>
                <a href="{{ route('bookings.index') }}" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg inline-flex items-center px-3 py-2 transition-colors">
                    View all →
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Recent Bookings List --}}
                <div>
                    <div class="space-y-3">
                        @foreach(array_slice($bookings, 0, 4) as $booking)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $booking['amenity_name'] }}</p>
                                <p class="text-xs text-gray-500">{{ date('M j, Y', strtotime($booking['booking_date'])) }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                @php
                                    $statusColors = [
                                        'Confirmed' => 'bg-green-100 text-green-800',
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    $colorClass = $statusColors[$booking['status']] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="{{ $colorClass }} text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $booking['status'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Booking Statistics --}}
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Booking Statistics</h4>
                        @php
                            $bookingStats = [
                                'confirmed' => count(array_filter($bookings, fn($b) => $b['status'] === 'Confirmed')),
                                'pending' => count(array_filter($bookings, fn($b) => $b['status'] === 'Pending')),
                                'cancelled' => count(array_filter($bookings, fn($b) => $b['status'] === 'Cancelled')),
                                'total' => count($bookings)
                            ];
                        @endphp
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Confirmed</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $bookingStats['confirmed'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Pending</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $bookingStats['pending'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Cancelled</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $bookingStats['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Popular Amenities --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Popular Amenities</h4>
                        @php
                            $amenityBookings = [];
                            foreach($bookings as $booking) {
                                $amenity = $booking['amenity_name'];
                                $amenityBookings[$amenity] = ($amenityBookings[$amenity] ?? 0) + 1;
                            }
                            arsort($amenityBookings);
                            $topAmenities = array_slice($amenityBookings, 0, 3, true);
                        @endphp
                        <div class="space-y-2">
                            @foreach($topAmenities as $amenity => $count)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 truncate">{{ $amenity }}</span>
                                <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
