<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Details</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-10">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-md p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 text-center">User Details</h1>

        <div>
            <h2 class="text-lg font-medium text-gray-800">ID:</h2>
            <p class="text-gray-600">{{ $user['id'] }}</p>
            <h2 class="text-lg font-medium text-gray-800">Name:</h2>
            <p class="text-gray-600">{{ $user['name'] }}</p>
            <h2 class="text-lg font-medium text-gray-800">Email:</h2>
            <p class="text-gray-600">{{ $user['email'] }}</p>
            <h2 class="text-lg font-medium text-gray-800">Phone:</h2>
            <p class="text-gray-600">{{ $user['phone'] }}</p>
            <h2 class="text-lg font-medium text-gray-800">Role:</h2>
            <p class="text-gray-600">{{ $user['role'] }}</p>
        </div>
    </div>
</body>

</html>
