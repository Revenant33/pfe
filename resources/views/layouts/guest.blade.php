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
        
        <style>
            .auth-bg {
                background: url('/images/blueback2.jpg') no-repeat center center fixed;
                background-size: cover;
            }
            .auth-overlay {
                background-color: rgba(0, 0, 0, 0.5);
            }
            .auth-card {
                backdrop-filter: blur(8px);
                background-color: rgba(255, 255, 255, 0.85);
            }
            .dark .auth-card {
                background-color: rgba(0, 0, 0, 0.75);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen auth-bg flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Overlay sombre -->
            <div class="auth-overlay absolute inset-0 z-0"></div>
            
            <!-- Contenu (logo + formulaire) -->
            <div class="relative z-10 w-full">
                <!-- Logo centré -->
                <div class="flex justify-center mb-8">
                    <a href="/">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-20 h-20">
                    </a>
                </div>

                <!-- Carte du formulaire -->
                <div class="w-full sm:max-w-md mx-auto px-6 py-8 auth-card shadow-xl rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>