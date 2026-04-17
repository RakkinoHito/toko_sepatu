@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto fade-in">
    <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali
    </a>
    
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Transaksi #{{ $transaction->id }}</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d F Y') }}</p>
            </div>
            <div class="text-right">
                @if($transaction->status == 'completed')
                    <span class="px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-lg font-semibold">✅ Selesai</span>
                @else
                    <span class="px-4 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-lg font-semibold">❌ Dibatalkan</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pelanggan</div>
                <div class="font-bold text-gray-900 dark:text-white">{{ $transaction->customer->nama }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">{{ $transaction->customer->telepon }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Kasir</div>
                <div class="font-bold text-gray-900 dark:text-white">{{ $transaction->user->name }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Item</div>
                <div class="font-bold text-gray-900 dark:text-white">{{ $transaction->jumlah_item }} item</div>
            </div>
        </div>

        <h4 class="font-bold text-lg mb-4">Detail Pembelian</h4>
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase">
                        <th class="p-3">No</th>
                        <th class="p-3">Sepatu</th>
                        <th class="p-3 text-center">Jumlah</th>
                        <th class="p-3 text-right">Harga Satuan</th>
                        <th class="p-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($transaction->details as $key => $detail)
                    <tr>
                        <td class="p-3">{{ $key + 1 }}</td>
                        <td class="p-3 font-bold text-gray-900 dark:text-white">{{ $detail->shoe->nama }}</td>
                        <td class="p-3 text-center">{{ $detail->jumlah }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-bold text-brand-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 dark:bg-gray-700 font-bold">
                        <td colspan="4" class="p-3 text-right">TOTAL</td>
                        <td class="p-3 text-right text-xl text-brand-600">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-bold hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection