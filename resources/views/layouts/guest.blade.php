<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

</head>
<body class="font-sans text-gray-900 antialiased">
<div>
    <div>
        {{ $slot }}
    </div>
</div>
</body>
</html>
