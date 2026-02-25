<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <main>
            <div class="h-[60vh] flex justify-center items-center flex-col text-center">
                <h1 class="font-bold">Dashboard</h1>
                <p>Welcome to Train Outclass</p>
            </div>
        </main>
    </div>
</x-app-layout>