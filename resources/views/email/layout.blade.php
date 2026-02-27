<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("title-web")</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Import Tailwindcss -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans font-['Nunito'] bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Email Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-5 py-10 text-center">
            <h1 class="text-2xl font-bold text-white">@yield('email_title', 'Notification')</h1>
        </div>

        <!-- Email Body -->
        <div class="px-8 py-10">
            @yield('content')
            {{ $slot ?? '' }}
        </div>

        <!-- Email Footer -->
        <div class="bg-gray-50 px-8 py-5 text-center text-xs text-gray-500 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Application') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>