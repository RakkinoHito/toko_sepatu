<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Cards
        $stats = [
            'total_sepatu' => Shoe::count(),
            'total_stok' => Shoe::sum('stok'),
            'stok_menipis' => Shoe::where('stok', '<', 5)->count(),
            'nilai_inventaris' => Shoe::sum(DB::raw('stok * harga')),
            'total_transaksi_hari_ini' => Transaction::whereDate('created_at', today())->count(),
            'pendapatan_hari_ini' => Transaction::whereDate('created_at', today())->sum('total_harga'),
        ];

        // 5 Sepatu Terlaris
        $bestSellers = DB::table('transaction_details')
            ->join('shoes', 'transaction_details.shoe_id', '=', 'shoes.id')
            ->select('shoes.nama', 'shoes.merk', DB::raw('SUM(transaction_details.jumlah) as total_terjual'))
            ->groupBy('shoes.id', 'shoes.nama', 'shoes.merk')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();

        // Transaksi Terbaru
        $recentTransactions = Transaction::with(['customer', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // Sepatu Stok Menipis
        $lowStockShoes = Shoe::where('stok', '<', 5)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'bestSellers', 'recentTransactions', 'lowStockShoes'));
    }
}