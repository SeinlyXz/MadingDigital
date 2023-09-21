<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center">
            {{ __('Edit Content') }}
        </h2>
    </x-slot>
    @if(Session::has('Gagal'))
        <div class="flex justify-center">
            <p class="text-red-500 bg-red-100 py-3 w-full text-center">{{Session::get('Gagal')}}</p>
        </div>
    @endif
    <div class="mt-10 flex justify-center">
        <div class="flex flex-col">
            <form action="{{route('media.update',$media->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @METHOD('PUT')
                <div class="mt-5">
                    <div>
                        <label for="file" class="text-black">Ganti Gambar</label>
                    </div>
                    <input type="file" name="path" class="bg-gray-600 w-full rounded-xl text-white p-3">
                </div>
                <div class="mt-3">
                    <label for="pengupload" class="text-black">Pengupload</label>
                    <div class="mt-1">
                        <input type="text" name="pengupload" class="text-black w-96 rounded-xl" placeholder="{{$media->pengupload}}">
                    </div>
                </div>
                <div class="mt-2">
                    <label for="pemilik" class="text-black">Pemilik</label>
                    <div class="mt-1">
                        <select name="pemilik" id="" class="rounded-xl text-black">
                            @if($media->pemilik == 'siswa')
                                <option value="{{$media->pemilik}}" selected>{{$media->pemilik}}</option>
                                <option value="guru">Guru</option>
                            @else
                                <option value="{{$media->pemilik}}" selected>{{$media->pemilik}}</option>
                                <option value="siswa">Siswa</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-xl w-full">Update</button>
                </div>
            </form>
            <div class="mt-5 mb-10">
                <a href={{route('dashboard')}} type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-xl w-full text-center">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>