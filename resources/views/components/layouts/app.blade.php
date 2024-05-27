<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Application' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @filamentStyles
</head>
<body class="min-h-screen bg-gray-100" style="overflow:hidden">
    <div class="min-h-screen" style="overflow:hidden">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
