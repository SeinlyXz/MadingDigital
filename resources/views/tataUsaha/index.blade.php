<x-guest-layout>
    <div class="bg-slate-500 flex h-screen items-center justify-center overflow-hidden">
        @if ($media->count() === 0)
            <div class="flex flex-col items-center bg-gray-200 rounded-xl p-10">
                <p class="text-gray-700">Tidak ada media yang tersedia</p>
                <p class="text-teal-500">Hubungi admin untuk menambahkan media</p>
            </div>
        @else
            @foreach($media as $mediaItem)
                <div class="flex h-screen items-center justify-center overflow-hidden">
                    @if ($mediaItem->type === 'mp4')
                        <video 
                            src="{{ route('video.serve', ['filename' => basename($mediaItem->path)]) }}?v={{ $mediaItem->version }}" 
                            muted 
                            autoplay 
                            playsinline
                            controls
                            class="absolute inset-0 w-full h-full object-cover"
                            onended="window.location.href = '{{ url('siswa') }}'"
                        >
                            <source src="{{ route('video.serve', ['filename' => basename($mediaItem->path)]) }}?v={{ $mediaItem->version }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ $mediaItem->path }}" alt="" class="w-full h-full object-cover">
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    @vite('resources/js/tatausaha.js')
</x-guest-layout>
