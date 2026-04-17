@extends('layouts.app')
@section('title', 'Tambah Sepatu Baru')

@section('content')
<div class="max-w-2xl mx-auto fade-in">
    <a href="{{ route('shoes.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali ke Data Sepatu
    </a>
    
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Detail Sepatu</h3>
        
        <form action="{{ route('shoes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sepatu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merk/Brand <span class="text-red-500">*</span></label>
                    <select name="brand_id" id="brandSelect" required onchange="updateMerkField()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                        <option value="">-- Pilih Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" data-nama="{{ $brand->nama }}">{{ $brand->nama }} ({{ $brand->negara ?? 'Umum' }})</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="merk" id="merkInput" value="{{ old('merk') }}">
                    @error('brand_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ukuran <span class="text-red-500">*</span></label>
                        <input type="text" name="ukuran" value="{{ old('ukuran') }}" required placeholder="Contoh: 42" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                        @error('ukuran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga" value="{{ old('harga') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                        @error('harga')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    @error('stok')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Produk</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-lg font-bold hover:bg-brand-700 transition shadow-lg hover:shadow-xl">
                    💾 Simpan Data
                </button>
                <a href="{{ route('shoes.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-bold hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updateMerkField() {
    const select = document.getElementById('brandSelect');
    const selectedOption = select.options[select.selectedIndex];
    const merkInput = document.getElementById('merkInput');
    
    if (selectedOption.value) {
        merkInput.value = selectedOption.dataset.nama;
    } else {
        merkInput.value = '';
    }
}
</script>
@endsection