<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

<div class="text-center px-6">
    <h1 class="text-9xl font-bold text-green-500">404</h1>

    <p class="text-2xl mt-4 font-semibold">Oops! Page not found</p>
    <p class="text-gray-400 mt-2">Halaman yang kamu cari tidak tersedia atau sudah dipindahkan.</p>

    <div class="mt-8 flex justify-center gap-4">
        <a href="/" class="px-6 py-3 bg-green-500 hover:bg-green-600 rounded-xl shadow-lg transition">
            ⬅ Kembali ke Home
        </a>

        <button onclick="history.back()" 
            class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl transition">
            🔙 Kembali
        </button>
    </div>

    <div class="mt-10">
        <p class="text-sm text-gray-500">Error Code: 404</p>
    </div>
</div>

</body>
</html>