<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Toko Sepatu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-amber-50 to-amber-200 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md border border-amber-100">
        <h2 class="text-3xl font-bold text-center text-amber-900 mb-6">📝 Registrasi Admin</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-amber-900 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="w-full p-3 border border-amber-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <div class="mb-4">
                <label class="block text-amber-900 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full p-3 border border-amber-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <div class="mb-4">
                <label class="block text-amber-900 font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full p-3 border border-amber-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <div class="mb-6">
                <label class="block text-amber-900 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required 
                    class="w-full p-3 border border-amber-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <button type="submit" class="w-full bg-amber-800 text-white py-3 rounded font-semibold hover:bg-amber-900 transition">
                Daftar
            </button>
        </form>
        <p class="text-center mt-4 text-amber-700 text-sm">
            Sudah punya akun? <a href="{{ route('login') }}" class="underline font-bold">Login</a>
        </p>
    </div>
</body>
</html>