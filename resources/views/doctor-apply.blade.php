<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YM | Apply</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('img/app-logo.png') }}">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Apply</h1>
        <div class="max-w-md mx-auto bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-6">
                <p class="text-lg text-gray-700 mb-4">
                    This Information will be sent to <strong>no.reply.ym.system@gmail.com</strong>
                </p>
                <form action="{{ route('home.apply.submit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-md"
                            placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-600 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md"
                            placeholder="Enter your email address" required>
                    </div>
                    <div class="mb-4">
                        <label for="cv" class="block text-gray-600 mb-2">CV (PDF or Word)</label>
                        <input type="file" id="cv" name="cv" class="w-full px-4 py-2 border rounded-md"
                            accept=".pdf,.doc,.docx" required>
                    </div>
                    <div class="mb-4">
                        <label for="details" class="block text-gray-600 mb-2">Details</label>
                        <textarea id="details" name="details" class="w-full px-4 py-2 border rounded-md resize-none" rows="4"
                            placeholder="Additional details (optional)"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">Send</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</body>

</html>
