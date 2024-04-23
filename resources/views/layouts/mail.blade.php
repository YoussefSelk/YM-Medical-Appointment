<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-blue-100">

<div class="w-full max-w-sm mx-auto mt-8 bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4">
        <div class="flex items-center justify-center">
            <span class="text-3xl text-blue-600"><i class="fas fa-heart"></i></span>
            <h1 class="mx-3 text-2xl text-gray-800 font-semibold">{{ $subject }}</h1>
        </div>

        <p class="mt-4 text-gray-600">{!! $content !!}</p>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ $contactLink }}" class="text-blue-500 hover:text-blue-600 hover:underline">{{ $contactText }}</a>
            <a href="tel:{{ $phoneNumber }}" class="text-blue-500 hover:text-blue-600 hover:underline"><i class="fas fa-phone-alt"></i> {{ $phoneNumber }}</a>
        </div>
    </div>
</div>

</body>
</html>
