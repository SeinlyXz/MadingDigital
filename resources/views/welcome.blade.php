<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        {{-- @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif --}}
        {{-- @php
            $datas = [
                ['id' => 1, 'url' => 'https://free4kwallpapers.com/uploads/originals/2020/09/19/minimal-city-wallpaper.jpg'], 
                ['id' => 2, 'url' => 'https://i.pinimg.com/originals/fb/a3/01/fba301ac9c5c454406557689a66d22d7.jpg'], 
                ['id' => 3, 'url' => 'https://free4kwallpapers.com/uploads/originals/2020/09/19/minimal-city-wallpaper.jpg'], 
                ['id' => 4, 'url' => 'https://i.pinimg.com/originals/fb/a3/01/fba301ac9c5c454406557689a66d22d7.jpg'],
                ['id' => 5, 'url' => 'https://free4kwallpapers.com/uploads/originals/2020/09/19/minimal-city-wallpaper.jpg'], 
                ['id' => 6, 'url' => 'https://i.pinimg.com/originals/fb/a3/01/fba301ac9c5c454406557689a66d22d7.jpg'], 
                ['id' => 7, 'url' => 'https://free4kwallpapers.com/uploads/originals/2020/09/19/minimal-city-wallpaper.jpg'], 
                ['id' => 8, 'url' => 'https://i.pinimg.com/originals/fb/a3/01/fba301ac9c5c454406557689a66d22d7.jpg']
            ];
        @endphp --}}
        <div class="flex justify-center -mt-10">
            <div class="flex flex-col">
                @if ($medias->first() !== null)
                <div class="carousel object-contain w-full rounded-xl -mb-20">
                    @foreach ($medias as $media)
                        <div id="item{{ $media->id }}" class="carousel-item w-full">
                            @if($media->type === "mp4" || $media->type === "webm" || $media->type === "ogg")
                                <video src="{{ $media->path }}" class="w-full" controls loop muted></video>
                            @else
                                <img src="{{ $media->path }}" class="w-full" />
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="py-2 gap-2 flex justify-center w-full">
                    @foreach ($medias as $media)
                        <a href="#item{{ $media->id }}" class="btn btn-xs btn-primary btn-active">{{ $media->id }}</a>
                    @endforeach
                </div>
                @else
                    <div>
                        <p>There is no image yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
