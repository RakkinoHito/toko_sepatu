@extends('layouts.app')
@section('title', 'Edit Sepatu')

@section('content')
<div class="max-w-2xl mx-auto fade-in">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali ke Dashboard
    </a>
    
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Detail</h3>
        
        <form action="{{ route('shoes.update', $shoe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            @if($shoe->image)
            <div class="mb-6 flex items-center gap-4">
                <div class="text-sm text-gray-500">Gambar Saat Ini:</div>
                <img src="{{ asset('storage/' . $shoe->image) }}" class="w-16 h-16 object-cover rounded-lg border">
            </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sepatu</label>
                    <input type="text" name="nama" value="{{ old('nama', $shoe->nama) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merk</label>
                        <input type="text" name="merk" value="{{ old('merk', $shoe->merk) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ukuran</label>
                        <input type="text" name="ukuran" value="{{ old('ukuran', $shoe->ukuran) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga', $shoe->harga) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $shoe->stok) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500">
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-lg font-bold hover:bg-brand-700 transition shadow-lg hover:shadow-xl">
                    💾 Update Data
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-bold hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection