<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kicks Store Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#fdf8f6', 100: '#f2e8e5', 500: '#d97706', 600: '#b45309', 800: '#5D4037', 900: '#3e2723' }
                    }
                }
            }
        }
    </script>
    <style>
        /* Animasi Halus */
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-brand-50 text-gray-800 font-sans antialiased dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-brand-900 text-white flex flex-col shadow-2xl z-20 transition-all duration-300">
            <div class="p-6 text-center border-b border-brand-800">
                <h1 class="text-2xl font-bold tracking-wider flex items-center justify-center gap-2">
                    <span>👞</span> KICKS
                </h1>
                <p class="text-xs text-brand-100 mt-1 opacity-70">Admin Panel</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-brand-800 text-white shadow-sm transition transform hover:scale-105">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('shoes.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-brand-800 text-brand-100 transition">
                    <span>➕</span> Tambah Sepatu
                </a>
            </nav>

            <div class="p-4 border-t border-brand-800 space-y-3">
                <div class="text-xs text-center text-brand-100 opacity-60">
                    Logged in as <b>{{ auth()->user()->name }}</b>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition shadow-lg">🚪 Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8 relative">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow mb-6 fade-in" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    
</body>
</html>