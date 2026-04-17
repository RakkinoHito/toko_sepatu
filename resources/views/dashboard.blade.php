@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-brand-900">Dashboard</h2>
            <p class="text-gray-500 text-sm mt-1">Ringkasan sistem toko sepatu Anda.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">📥 Excel</a>
            <a href="{{ route('export.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">📄 PDF</a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="text-gray-500 text-sm font-medium">Total Sepatu</div>
            <div class="text-3xl font-bold text-brand-600 mt-2">{{ $stats['total_sepatu'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="text-gray-500 text-sm font-medium">Total Stok</div>
            <div class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_stok'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="text-gray-500 text-sm font-medium">Stok Menipis</div>
            <div class="text-3xl font-bold text-orange-500 mt-2">{{ $stats['stok_menipis'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="text-gray-500 text-sm font-medium">Nilai Inventaris</div>
            <div class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($stats['nilai_inventaris'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Transaksi Hari Ini -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">📊 Aktivitas Hari Ini</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Total Transaksi</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $stats['total_transaksi_hari_ini'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Pendapatan</span>
                    <span class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Stok Menipis Alert -->
        @if($lowStockShoes->count() > 0)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">⚠️ Stok Menipis</h3>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @foreach($lowStockShoes as $shoe)
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg border border-red-200">
                    <div>
                        <div class="font-bold text-gray-900">{{ $shoe->nama }}</div>
                        <div class="text-sm text-gray-600">{{ $shoe->merk }}</div>
                    </div>
                    <span class="px-3 py-1 bg-red-600 text-white rounded-full text-sm font-bold">{{ $shoe->stok }} pcs</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Best Sellers -->
        @if($bestSellers->count() > 0)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">🏆 Sepatu Terlaris</h3>
            <div class="space-y-3">
                @foreach($bestSellers as $index => $item)
                <div class="flex items-center justify-between p-3 {{ $index == 0 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }} rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex items-center justify-center bg-brand-600 text-white rounded-full font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">{{ $item->nama }}</div>
                            <div class="text-sm text-gray-600">{{ $item->merk }}</div>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-sm font-bold">{{ $item->total_terjual }} terjual</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Transactions -->
        @if($recentTransactions->count() > 0)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">🕐 Transaksi Terbaru</h3>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @foreach($recentTransactions as $trans)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div>
                        <div class="font-bold text-gray-900">#{{ $trans->id }} - {{ $trans->customer->nama }}</div>
                        <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($trans->created_at)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600">Rp {{ number_format($trans->total_harga, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">{{ $trans->jumlah_item }} item</div>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('transactions.index') }}" class="inline-block mt-4 text-brand-600 hover:text-brand-700 font-semibold text-sm">Lihat Semua Transaksi →</a>
        </div>
        @endif
    </div>  
</div>
@endsection