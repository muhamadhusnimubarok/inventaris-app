<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>403 - Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    <div class="text-center px-6">
        <h1 class="text-9xl font-bold text-red-500">403</h1>

        <p class="text-2xl mt-4 font-semibold">Access Denied</p>
        <p class="text-gray-400 mt-2">Kamu tidak memiliki izin untuk mengakses halaman ini.</p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('filament.admin.pages.dashboard') }}" class="px-6 py-3 bg-red-500 hover:bg-red-600 rounded-xl shadow-lg transition">
                 Kembali ke Home
            </a>

           
        </div>

        <div class="mt-10">
            <p class="text-sm text-gray-500">Error Code: 403</p>
        </div>
    </div>

</body>

</html>