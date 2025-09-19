@extends('layouts.dashboard')

@section('title', $title . ' - Certicode Condo')

@section('dashboard-content')
<div class="pt-6 px-4">
    <div class="w-full">
        <div class="bg-white shadow rounded-lg p-8 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-cyan-100 mb-4">
                <svg class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-500 mb-6">This feature is coming soon. We're working hard to bring you the best condo management experience.</p>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
