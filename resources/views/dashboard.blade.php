<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center">
            {{ __('Welcome To Content Manegement Portal') }}
        </h2>
    </x-slot>
    @if(Session::has('success'))
        <div class="flex justify-center">
            <p class="text-green-500 bg-green-100 py-3 w-full text-center">{{Session::get('success')}}</p>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="flex justify-center">
            <p class="text-red-500 bg-red-100 py-3 w-full text-center">{{Session::get('error')}}</p>
        </div>
    @endif
    @if($medias->count() == 0)
        <div class="flex justify-center mt-5">
            
        </div>
    @else
    <div class="flex justify-center mt-5">
        <a href="{{route('media.create')}}" class="py-3 px-2 bg-green-500 text-white hover:bg-green-700 rounded-xl">Tambahkan</a>
    </div>
    @endif
    <div class="flex justify-between gap-10 mx-52">
        <div class="mb-10">
            <p class="text-center mt-4 text-gray-500 text-2xl font-bold mb-5">
                Content Siswa / Siswi
            </p>
            <div class="px-10 rounded-xl">
                @if($medias->where('pemilik','siswa')->count() == 0)
                    <div class="flex justify-center">
                        <a href="{{route('media.create')}}" class="py-3 px-2 bg-green-500 text-white hover:bg-green-700 rounded-xl">Tambahkan</a>
                    </div>
                @else
                    @foreach ($medias as $media)
                        @if($media->pemilik == 'siswa')
                        <div class="bg-gray-300 shadow-lg shadow-gray-400 pt-10 px-10 rounded-xl mb-10 max-w-[30rem] w-[30rem]">
                            <div class="flex justify-center">
                                <div class="media-container">
                                    @if($media->type == 'mp4' || $media->type == 'webm' || $media->type == 'ogg')
                                        <video src="{{$media->path}}" controls class="w-full rounded-xl"></video>
                                    @else 
                                    <img src="{{$media->path}}" alt="" class="max-w-96 w-96 object-cover rounded-xl">
                                    @endif
                                </div>
                            </div>
                            <p class="text-black ms-1 mb-5">Pengupload: {{$media->pengupload}}</p>
                            <div class="flex gap-2">
                                <a href="{{route('media.edit', $media)}}" class="bg-blue-500 text-white py-2 px-4 rounded-xl">Edit</a>
                                <form action="{{ route('media.destroy', [$media->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white hover:bg-red-500 bg-red-600 py-2 px-4 rounded-xl" onclick="return confirm('Apakah Anda yakin ingin menghapus media ini?')">Hapus</button>
                                </form>
                            </div>
                            <div class="mt-5 pb-3 flex justify-end">
                                <small class="text-gray-500">
                                    Diupload pada: <span class="text-green-600">{{$media->uploaded_at}}</span>
                                </small>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        @if($medias->count() > 1)
        <div class="divider divider-horizontal mt-20 mb-20"></div>
        @endif
        <div class="mb-10">
            <p class="text-center mt-4 text-gray-500 text-2xl font-bold mb-5">
                Content Guru
            </p>
            <div class="px-10">
                {{-- Make an if when $medias for guru is 0 then else  --}}
                @if($medias->where('pemilik', 'guru')->count() === 0)
                    <div class="flex justify-center">
                        <a href="{{route('media.create')}}" class="py-3 px-2 bg-green-500 text-white hover:bg-green-700 rounded-xl">Tambahkan</a>
                    </div>
                @else
                    @foreach($medias as $media)
                        @if($media->pemilik == 'guru')
                        <div class="bg-gray-300 shadow-lg shadow-gray-400 pt-10 px-10 rounded-xl mb-10 max-w-[30rem] w-[30rem]">
                            <div class="flex justify-center">
                                <div class="media-container">
                                    @if($media->type == 'mp4' || $media->type == 'webm' || $media->type == 'ogg')
                                        <video src="{{$media->path}}" controls class="w-full rounded-xl"></video>
                                    @else 
                                    <img src="{{$media->path}}" alt="" class="w-full object-cover rounded-xl">
                                    @endif
                                </div>
                            </div>
                            <p class="text-black ms-4 mb-5">Pengupload: {{$media->pengupload}}</p>
                            <div class="flex gap-2">
                                <a href="{{route('media.edit', $media)}}" class="bg-blue-500 text-white py-2 px-4 rounded-xl">Edit</a>
                                <form action="{{ route('media.destroy', [$media->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white hover:bg-red-500 bg-red-600 py-2 px-4 rounded-xl" onclick="return confirm('Apakah Anda yakin ingin menghapus media ini?')">Hapus</button>
                                </form>
                            </div>
                            <div class="mt-5 pb-3 flex justify-end">
                                <small class="text-gray-500">
                                    Diupload pada: <span class="text-green-600">{{$media->uploaded_at}}</span>
                                </small>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
