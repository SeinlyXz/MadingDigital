<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <a href="{{route('media.create')}}" class="px-4 py-2 mx-20 bg-gray-500 rounded-xl text-white">Create</a>
    </div>
</x-app-layout>