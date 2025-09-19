@extends('layouts.app')

@section('title', 'Server Error - HealthHub')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto text-center">
        <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Server Error</h2>
        <p class="text-gray-600 mb-8">
            We're experiencing some technical difficulties. Our team has been notified and is working to resolve the issue.
        </p>
        
        <div class="space-y-4">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Try Again
            </a>
            
            <div class="text-sm text-gray-500">
                <p>If the problem persists, please contact our support team at:</p>
                <a href="mailto:support@healthhub.com" class="text-blue-600 hover:text-blue-800 font-medium">
                    support@healthhub.com
                </a>
            </div>
        </div>
    </div>
</div>
@endsection