@extends("email.layout")

@section("title-web", "OC | Email Gudang")

@section("konten")
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Email Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-5 py-10 text-center">
            <h1 class="text-2xl font-bold text-white">{{ $subjectEmail ?? '' }}</h1>
        </div>

        <!-- Email Body -->
        <div class="px-8 py-10">{{ $isi ?? '' }}</div>

        <!-- Email Footer -->
        <div class="bg-gray-50 px-8 py-5 text-center text-xs text-gray-500 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Application') }}. All rights reserved.</p>
        </div>
    </div>
@endsection