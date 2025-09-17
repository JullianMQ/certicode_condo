{{-- Certicode Condo Dashboard - Main Overview Page --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard - Certicode Condo')

@section('dashboard-content')
<div class="pt-6 px-4">
    {{-- Dashboard Grid Layout --}}
    <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
        {{-- Main Statistics Card --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 2xl:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ count($condos) }}</span>
                    <h3 class="text-base font-normal text-gray-500">Total Condo Units</h3>
                </div>
                <div class="flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                    {{ count(array_filter($condos, fn($condo) => $condo['status'] === 'Occupied')) }} Occupied
                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-gray-900">{{ count($bookings) }}</div>
                    <div class="text-sm text-gray-500">Active Bookings</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-gray-900">{{ count(array_filter($maintenance, fn($m) => $m['status'] === 'In Progress')) }}</div>
                    <div class="text-sm text-gray-500">Pending Maintenance</div>
                </div>
            </div>
        </div>

        {{-- Recent Maintenance Requests Card --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Recent Maintenance</h3>
                    <span class="text-base font-normal text-gray-500">Latest maintenance requests</span>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('maintenance.index') }}" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">View all</a>
                </div>
            </div>
            {{-- Maintenance Requests Table --}}
            <div class="flex flex-col mt-8">
                <div class="overflow-x-auto rounded-lg">
                    <div class="align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                                        <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach(array_slice($maintenance, 0, 5) as $request)
                                    <tr>
                                        <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                            <div class="text-sm font-medium text-gray-900">{{ $request['title'] }}</div>
                                            <div class="text-sm text-gray-500">Unit {{ $request['unit_id'] }}</div>
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                            <span class="bg-{{ $request['status'] === 'Completed' ? 'green' : ($request['status'] === 'In Progress' ? 'yellow' : 'red') }}-100 text-{{ $request['status'] === 'Completed' ? 'green' : ($request['status'] === 'In Progress' ? 'yellow' : 'red') }}-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-{{ $request['status'] === 'Completed' ? 'green' : ($request['status'] === 'In Progress' ? 'yellow' : 'red') }}-100">
                                                {{ $request['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row - Bookings and Building Overview --}}
    <div class="grid grid-cols-1 2xl:grid-cols-2 xl:gap-4 my-4">
        {{-- Recent Bookings Card --}}
        <div class="bg-white shadow rounded-lg mb-4 p-4 sm:p-6 h-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold leading-none text-gray-900">Recent Bookings</h3>
                <a href="{{ route('bookings.index') }}" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg inline-flex items-center p-2">
                    View all
                </a>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach(array_slice($bookings, 0, 5) as $booking)
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $booking['amenity_name'] }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ date('M j, Y', strtotime($booking['booking_date'])) }} - {{ $booking['status'] }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Condo Units Overview by Building --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
            <h3 class="text-xl leading-none font-bold text-gray-900 mb-10">Condo Units by Building</h3>
            <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">Building</th>
                            <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">Units</th>
                            <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">Occupied</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
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
                        <tr class="text-gray-500">
                            <td class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">{{ $building }}</td>
                            <td class="border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">{{ $stats['total'] }}</td>
                            <td class="border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">{{ $stats['occupied'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
