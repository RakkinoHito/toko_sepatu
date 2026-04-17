@extends('layouts.app')

@section('title', 'Data Merk/Brand')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-brand-900 dark:text-white">Merk/Brand</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola merk sepatu yang tersedia.</p>
        </div>
        <a href="{{ route('brands.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg font-medium transition shadow-lg flex items-center gap-2">
            ✨ Tambah Brand
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        @if($brands->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">No</th>
                        <th class="p-4 font-semibold">Nama Brand</th>
                        <th class="p-4 font-semibold">Negara</th>
                        <th class="p-4 font-semibold">Jumlah Produk</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($brands as $key => $brand)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <td class="p-4">{{ $brands->firstItem() + $key }}</td>
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $brand->nama }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $brand->negara ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full text-sm font-semibold">
                                {{ $brand->shoes_count }} produk
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900 p-2 rounded-lg transition" title="Edit">✏️</a>
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus brand ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900 p-2 rounded-lg transition" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600">
            {{ $brands->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-6xl mb-4">🏷️</div>
            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200">Belum ada brand</h3>
            <p class="text-gray-500 mt-2">Silakan tambahkan brand pertama Anda.</p>
            <a href="{{ route('brands.create') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2 rounded-lg hover:bg-brand-700 transition">Tambah Brand</a>
        </div>
        @endif
    </div>
</div>
@endsection