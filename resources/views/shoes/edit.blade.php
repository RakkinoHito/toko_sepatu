@extends('layouts.app')
@section('title', 'Edit Sepatu')

@section('content')
<div class="max-w-2xl mx-auto fade-in">
    <a href="{{ route('shoes.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali ke Data Sepatu
    </a>
    
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Detail Sepatu</h3>
        
        <form action="{{ route('shoes.update', $shoe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Sepatu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $shoe->nama) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merk/Brand <span class="text-red-500">*</span></label>
                    <select name="brand_id" id="brandSelect" required onchange="updateMerkField()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                        <option value="">-- Pilih Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" data-nama="{{ $brand->nama }}" {{ $shoe->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->nama }} ({{ $brand->negara ?? 'Umum' }})
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="merk" id="merkInput" value="{{ old('merk', $shoe->merk) }}">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ukuran <span class="text-red-500">*</span></label>
                        <input type="text" name="ukuran" value="{{ old('ukuran', $shoe->ukuran) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga" value="{{ old('harga', $shoe->harga) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', $shoe->stok) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Produk (Kosongkan jika tidak ingin mengubah)</label>
                    @if($shoe->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($shoe->image) }}" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500">
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-lg font-bold hover:bg-brand-700 transition shadow-lg hover:shadow-xl">
                    💾 Update Data
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

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    updateMerkField();
});
</script>
@endsection