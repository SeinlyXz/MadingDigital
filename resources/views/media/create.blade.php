<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center ">
            {{ __('Upload Content') }}
        </h2>
    </x-slot>
    @if(Session::has('Gagal'))
        <div class="flex justify-center">
            <p class="text-red-500 bg-red-100 py-3 w-full text-center">{{Session::get('Gagal')}}</p>
        </div>
    @endif
    <div class="flex justify-center mt-10">
        <div class="flex flex-col">
            <form action="{{route('media.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col">
                    <label for="pemilik"></label>
                    <select name="pemilik" id="pemilik" class="rounded-xl text-black">
                        <option disabled selected>Pilih Audience</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="tata-usaha">TU</option>
                    </select>
                    <div class="bg-gray-300 rounded-xl shadow-lg shadow-gray-400 flex flex-col p-10 my-10">
                        <div class="flex flex-col mb-5">
                            <label for="file" class="text-2xl font-semibold text-black">
                                Upload Media
                            </label>
                            <span class="font-bold text-gray-500 text-sm">Gambar: (Upload dalam resolusi 3840x2160 P)</span>
                            <span class="font-bold text-gray-500 text-sm">Video: (Upload dalam resolusi 1080P max. 30 MB)</span>
                        </div>
                        <input type="file" name="path" class="bg-gray-800 text-white rounded-xl p-5" required>
                        <span class="text-gray-500 text-sm mb-4">Format yang didukung: mp4, jpeg, png</span>
                        <input type="text" name="pengupload" class="bg-gray-300 text-gray-700 rounded-xl" placeholder="Pengupload" required autocomplete="off">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white mt-10 px-4 py-1 rounded-xl submit">Upload</button>
                    </div>
                </div>
            </form>
            <div class="flex justify-center mt-3 mb-20">
                <a href="{{route('dashboard')}}" class="rounded-xl bg-green-500 hover:bg-green-700 px-52 py-1 text-white my-auto">Back</a>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let loading = "<p>Upload</p>"
            $('.submit').append(loading);
            // listen to button submit, if the button is clicked, change the text to 'Uploading...'
            $('#submit').click(function() {
                $(this).text('Uploading...');
            });
        });
    </script>
</x-app-layout>