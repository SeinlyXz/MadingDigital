<x-guest-layout>
    <title>
        Informasi Siswa
    </title>
    <div class="bg-white flex h-screen items-center justify-center">
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
            @foreach($media as $media)
                <div class="flex h-screen items-center justify-center overflow-hidden">
                    @if ($media->type === 'mp4')
                        <video autoplay onended="window.location.href = '{{url('siswa')}}'" class="w-full shadow-xl shadow-gray-400 rounded-xl">
                            <source src="{{$media->path}}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{$media->path}}" alt="" class="w-full object-cover">
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    @vite('resources/js/siswa.js')
</x-guest-layout>
