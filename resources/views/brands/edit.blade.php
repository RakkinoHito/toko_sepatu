@extends('layouts.app')

@section('title', 'Edit Brand')

@section('content')
<div class="max-w-2xl mx-auto fade-in">
    <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali
    </a>
    
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Brand</h3>
        
        <form action="{{ route('brands.update', $brand->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $brand->nama) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Negara Asal</label>
                    <input type="text" name="negara" value="{{ old('negara', $brand->negara) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">{{ old('deskripsi', $brand->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-lg font-bold hover:bg-brand-700 transition shadow-lg">
                    💾 Update
                </button>
                <a href="{{ route('brands.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-bold hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection