<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Shoe;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'user'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_transaksi' => Transaction::where('status', 'completed')->count(),
            'total_pendapatan' => Transaction::where('status', 'completed')->sum('total_harga'),
            'total_item_terjual' => TransactionDetail::sum('jumlah'),
        ];

        return view('transactions.index', compact('transactions', 'stats'));
    }

    public function create()
    {
        $shoes = Shoe::where('stok', '>', 0)->get();
        $customers = Customer::all();
        
        return view('transactions.create', compact('shoes', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.shoe_id' => 'required|exists:shoes,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $totalItem = 0;
            $details = [];

            foreach ($validated['items'] as $item) {
                $shoe = Shoe::findOrFail($item['shoe_id']);
                
                if ($shoe->stok < $item['jumlah']) {
                    throw new \Exception("Stok sepatu {$shoe->nama} tidak mencukupi!");
                }

                $subtotal = $shoe->harga * $item['jumlah'];
                $totalHarga += $subtotal;
                $totalItem += $item['jumlah'];

                $details[] = [
                    'shoe_id' => $shoe->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $shoe->harga,
                    'subtotal' => $subtotal,
                ];

                $shoe->decrement('stok', $item['jumlah']);
            }

            $transaction = Transaction::create([
                'customer_id' => $validated['customer_id'],
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'jumlah_item' => $totalItem,
                'tanggal' => $validated['tanggal'],
                'status' => 'completed',
            ]);

            foreach ($details as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetail::create($detail);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil! 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'details.shoe']);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            foreach ($transaction->details as $detail) {
                $detail->shoe->increment('stok', $detail->jumlah);
            }

            $transaction->delete();
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membatalkan']);
        }
    }
}