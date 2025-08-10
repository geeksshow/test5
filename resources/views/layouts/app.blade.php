<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <div id="app" data-barba="wrapper">
                <main data-barba="container" data-barba-namespace="{{ Route::currentRouteName() }}">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Barba.js and GSAP for fade transitions -->
        <script src="https://unpkg.com/@barba/core"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            barba.init({
              transitions: [{
                name: 'fade',
                async leave(data) {
                  await gsap.to(data.current.container, {
                    opacity: 0,
                    duration: 0.5
                  });
                },
                async enter(data) {
                  await gsap.from(data.next.container, {
                    opacity: 0,
                    duration: 0.5
                  });
                }
              }]
            });
          });
        </script>
    </body>
</html>
