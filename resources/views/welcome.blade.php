<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / CSS -->
        <style>
            /* ! tailwindcss v3.4.11 | MIT License | https://tailwindcss.com */
            *, ::after, ::before { box-sizing: border-box; border-width: 0; border-style: solid; border-color: #e5e7eb; }
            * { --tw-shadow: 0 0 #0000; }
            ::backdrop { --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; }
            html { line-height: 1.5; -webkit-text-size-adjust: 100%; -moz-tab-size: 4; tab-size: 4; font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; }
            body { margin: 0; line-height: inherit; }
            /* Minimal Laravel welcome page styles */
            .min-h-screen { min-height: 100vh; }
            .bg-gray-100 { background-color: #f3f4f6; }
            .text-center { text-align: center; }
            .flex { display: flex; }
            .items-center { align-items: center; }
            .justify-center { justify-content: center; }
            .p-6 { padding: 1.5rem; }
            .font-sans { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
            .antialiased { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
            .relative { position: relative; }
            .sm\\:flex-row { flex-direction: row; }
            .sm\\:items-center { align-items: center; }
            .sm\\:justify-between { justify-content: space-between; }
            .sm\\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
            .lg\\:px-8 { padding-left: 2rem; padding-right: 2rem; }
            .selection\\:bg-red-500 *::selection { background-color: #ef4444; }
            .selection\\:text-white *::selection { color: #ffffff; }
            .hover\\:underline:hover { text-decoration: underline; }
            .focus\\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
            .focus\\:ring:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
            .focus\\:ring-red-500:focus { --tw-ring-color: #ef4444; }
            .focus\\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
            .focus\\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
            .focus\\:ring-offset-red-500:focus { --tw-ring-offset-color: #ef4444; }
            .bg-white { background-color: #ffffff; }
            .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
            .rounded-lg { border-radius: 0.5rem; }
            .px-4 { padding-left: 1rem; padding-right: 1rem; }
            .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
            .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
            .font-medium { font-weight: 500; }
            .text-gray-700 { color: #374151; }
            .text-gray-500 { color: #6b7280; }
            .text-gray-400 { color: #9ca3af; }
            .text-red-500 { color: #ef4444; }
            .text-black { color: #000000; }
            .text-white { color: #ffffff; }
            .bg-red-500 { background-color: #ef4444; }
            .hover\\:bg-red-600:hover { background-color: #dc2626; }
            .ml-4 { margin-left: 1rem; }
            .mr-4 { margin-right: 1rem; }
            .mb-6 { margin-bottom: 1.5rem; }
            .mt-4 { margin-top: 1rem; }
            .grid { display: grid; }
            .gap-4 { gap: 1rem; }
            .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
            @media (min-width: 640px) { .sm\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
            @media (min-width: 1024px) { .lg\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-2xl mx-auto p-6 text-center">
                <h1 class="text-4xl font-medium text-gray-700 mb-6">
                    Laravel
                </h1>
                <p class="text-gray-500 mb-6">
                    Welcome to your Laravel application.
                </p>
                <div class="flex justify-center">
                    <a href="https://laravel.com/docs" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition mr-4">
                        Documentation
                    </a>
                    <a href="https://laracasts.com" class="px-4 py-2 bg-white text-gray-700 rounded shadow hover:underline transition">
                        Laracasts
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
