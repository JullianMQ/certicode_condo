@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    
    <div class="flex overflow-hidden bg-white pt-16">
        @include('partials.sidebar')
        
        <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64 transition-all duration-300 ease-in-out">
            <main>
                @yield('dashboard-content')
            </main>
            
            @if(isset($showFooter) && $showFooter)
                @include('partials.footer')
            @endif
        </div>
    </div>
@endsection
