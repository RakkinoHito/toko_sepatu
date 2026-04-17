@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-brand-900 dark:text-white">Pelanggan</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola data pelanggan toko.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg font-medium transition shadow-lg flex items-center gap-2">
            ✨ Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        @if($customers->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">No</th>
                        <th class="p-4 font-semibold">Nama</th>
                        <th class="p-4 font-semibold">Telepon</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold">Transaksi</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($customers as $key => $customer)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <td class="p-4">{{ $customers->firstItem() + $key }}</td>
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $customer->nama }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $customer->telepon }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ $customer->email ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 rounded-full text-sm font-semibold">
                                {{ $customer->transactions_count }} transaksi
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900 p-2 rounded-lg transition" title="Edit">✏️</a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
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
            {{ $customers->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-6xl mb-4">👥</div>
            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200">Belum ada pelanggan</h3>
            <p class="text-gray-500 mt-2">Silakan tambahkan pelanggan pertama Anda.</p>
            <a href="{{ route('customers.create') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2 rounded-lg hover:bg-brand-700 transition">Tambah Pelanggan</a>
        </div>
        @endif
    </div>
</div>
@endsection