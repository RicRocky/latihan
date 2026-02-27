<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @yield("judul")
        </h2>
    </x-slot>

    @yield("breadcrumbs")

    <div class="py-12 max-w-[90vw] mx-auto min-h-[70vh]">
        @yield("content")
    </div>

    @yield("script")
</x-app-layout>