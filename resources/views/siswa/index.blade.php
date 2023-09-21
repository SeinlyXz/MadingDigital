<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mading Digital</title>

    <!-- Styles -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset("/build/assets/app-beeaeb24.css")}}">
    <style>
        .carousel {
            position: relative;
            width: 100vw;
            height: 100vh;
        }

        .carousel-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
        }

        .carousel-item img,
        .carousel-item video {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .carousel-controls {
            position: relative;
            top: -250px;
            /* transform: translateY(-50%); */
        }

        .carousel-controls button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 8px 16px;
            border-radius: 9999px;
            margin: 0 8px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .carousel-controls button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-800">
        <div class="w-full">
            <div class="relative rounded-lg overflow-hidden">
                <!-- Carousel wrapper -->
                <div id="carousel" class="carousel">
                    <!-- Items -->
                    @foreach($media as $index => $item)
                        @if($item->type === "mp4")
                        <div class="carousel-item">
                            <video src="{{$item->path}}" controls class="" onplay="jalan()" onpause="stop()"></video>
                        </div>
                        @else
                        <div class="carousel-item">
                            <img src="{{$item->path}}" class="" alt="Slide {{$index}}">
                        </div>
                        @endif
                    @endforeach
                </div>
                <!-- Controls -->
                <div class="relative flex justify-between bottom-96 -mt-16 mx-5">
                    <button id="prevBtn" class="bg-gray-800 bg-opacity-90 text-white px-2 py-1 rounded-full opacity-50 hover:opacity-100 transition-opacity duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <button id="nextBtn" class="bg-gray-800 bg-opacity-90 text-white px-2 py-1 rounded-full opacity-50 hover:opacity-100 transition-opacity duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
                <div class="relative flex justify-center bottom-10">
                    <div id="sliderIndicator" class="flex space-x-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const carousel = document.getElementById('carousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const items = carousel.querySelectorAll('.carousel-item');
        let currentIndex = 0;
        let interval = 5000;

        function showCurrentItem() {
            items.forEach((item, index) => {
                if (index === currentIndex) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function nextItem() {
            currentIndex++;
            if (currentIndex >= items.length) {
                currentIndex = 0;
            }
            showCurrentItem();
        }

        function prevItem() {
            currentIndex--;
            if (currentIndex < 0) {
                currentIndex = items.length - 1;
            }
            showCurrentItem();
        }

        function jalan() {
            interval = 1000000;
            updateInterval(interval);
        }

        function stop() {
            interval = 5000;
            updateInterval(interval);
        }

        showCurrentItem();
        prevBtn.addEventListener('click', prevItem);
        nextBtn.addEventListener('click', nextItem);

        function updateInterval(newInterval) {
            clearInterval(intervalId);
            interval = newInterval;
            intervalId = setInterval(nextItem, interval);
        }
        // Automatic slideshow
        let intervalId = setInterval(nextItem, interval);

        function showCurrentItem() {
            items.forEach((item, index) => {
                if (index === currentIndex) {
                    item.style.display = 'block';
                    updateSliderIndicator(index); // Menandai slider saat ini
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function updateSliderIndicator(currentIndex) {
            const sliderIndicator = document.getElementById('sliderIndicator');
            sliderIndicator.innerHTML = ''; // Menghapus indikator sebelumnya

            items.forEach((_, index) => {
                const indicator = document.createElement('div');
                indicator.className = `w-4 h-4 rounded-full ${index === currentIndex ? 'bg-white' : 'bg-gray-500'}`;
                sliderIndicator.appendChild(indicator);
            });
        }

    </script>
</body>

</html>
