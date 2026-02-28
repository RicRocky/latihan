@section("title-web", "OC | Dashboard")

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <main>
            <div class="h-[60vh] flex justify-center items-center flex-col text-center">
                <h1 class="font-bold">{{ __('dashboard.dashboard') }}</h1>
                <p>{{ __('dashboard.welcome') }}</p>
            </div>
        </main>
    </div>
</x-app-layout>