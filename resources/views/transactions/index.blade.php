@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-brand-900 dark:text-white">Transaksi Penjualan</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola transaksi penjualan toko.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg font-medium transition shadow-lg flex items-center gap-2">
            ✨ Transaksi Baru
        </a>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Transaksi</div>
            <div class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_transaksi'] }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Pendapatan</div>
            <div class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Item Terjual</div>
            <div class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['total_item_terjual'] }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm mb-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan..." 
                class="px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none">
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                class="px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none">
            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                class="px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none">
            <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-lg hover:bg-brand-700 transition">🔍 Filter</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        @if($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">No</th>
                        <th class="p-4 font-semibold">Tanggal</th>
                        <th class="p-4 font-semibold">Pelanggan</th>
                        <th class="p-4 font-semibold">Jumlah Item</th>
                        <th class="p-4 font-semibold">Total Harga</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($transactions as $key => $trans)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <td class="p-4">{{ $transactions->firstItem() + $key }}</td>
                        <td class="p-4 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y') }}</td>
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $trans->customer->nama }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full text-sm font-semibold">
                                {{ $trans->jumlah_item }} item
                            </span>
                        </td>
                        <td class="p-4 font-bold text-green-600">Rp {{ number_format($trans->total_harga, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($trans->status == 'completed')
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-full text-xs font-semibold">✅ Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-full text-xs font-semibold">❌ Dibatalkan</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.show', $trans->id) }}" class="text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900 p-2 rounded-lg transition" title="Detail">👁️</a>
                                @if($trans->status == 'completed')
                                <form action="{{ route('transactions.destroy', $trans->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900 p-2 rounded-lg transition" title="Batalkan">❌</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600">
            {{ $transactions->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-6xl mb-4">💰</div>
            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200">Belum ada transaksi</h3>
            <p class="text-gray-500 mt-2">Silakan buat transaksi penjualan pertama.</p>
            <a href="{{ route('transactions.create') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2 rounded-lg hover:bg-brand-700 transition">Buat Transaksi</a>
        </div>
        @endif
    </div>
</div>
@endsection