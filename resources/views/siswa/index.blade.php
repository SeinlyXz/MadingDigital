<x-guest-layout>
    <div class="bg-slate-500 flex h-screen items-center justify-center">
        @if ($media->count() === 0)
            <div class="flex flex-col items-center bg-gray-200 rounded-xl p-10">
                <p class="text-gray-700">
                    Tidak ada media yang tersedia
                </p>
                <p class="text-teal-500">
                    Hubungi admin untuk menambahkan media
                </p>
            </div>
        @else
            <p>
                {{$media->path}}
            </p>
        @endif
    </div>
</x-guest-layout>
