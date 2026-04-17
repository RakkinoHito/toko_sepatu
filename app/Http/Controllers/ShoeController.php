<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ShoeController extends Controller
{
    public function index(Request $request)
    {
        $query = Shoe::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('merk', 'like', "%{$request->search}%");
        }

        switch ($request->sort) {
            case 'price_asc': 
                $query->orderBy('harga', 'asc'); 
                break;
            case 'price_desc': 
                $query->orderBy('harga', 'desc'); 
                break;
            case 'stock_asc': 
                $query->orderBy('stok', 'asc'); 
                break;
            default: 
                $query->latest(); 
                break;
        }

        $shoes = $query->paginate(10);
        
        $stats = [
            'total_items' => Shoe::count(),
            'total_stock' => Shoe::sum('stok'),
            'low_stock' => Shoe::where('stok', '<', 5)->count(),
            'total_value' => Shoe::sum(DB::raw('stok * harga'))
        ];

        return view('shoes.index', compact('shoes', 'stats'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('shoes.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'merk' => 'required|string|max:255',
            'ukuran' => 'required|string|max:10',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public/shoes');
        }

        Shoe::create($validated);
        return redirect()->route('dashboard')->with('success', 'Sepatu berhasil ditambahkan! 🎉');
    }

    public function edit(Shoe $shoe)
    {
        $brands = Brand::all();
        return view('shoes.edit', compact('shoe', 'brands'));
    }

    public function update(Request $request, Shoe $shoe)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'merk' => 'required|string|max:255',
            'ukuran' => 'required|string|max:10',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image') && $shoe->image) {
            Storage::delete(str_replace('public/', '', $shoe->image));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public/shoes');
        }

        $shoe->update($validated);
        return redirect()->route('dashboard')->with('success', 'Data berhasil diperbarui! ✅');
    }

    public function destroy(Shoe $shoe)
    {
        if ($shoe->image) {
            Storage::delete(str_replace('public/', '', $shoe->image));
        }
        $shoe->delete();
        return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus! 🗑️');
    }

    public function exportExcel()
    {
        $shoes = Shoe::all();
        $filename = "Laporan_Sepatu_" . date('Y-m-d') . ".xls";
        
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; }';
        $html .= 'table { border-collapse: collapse; width: 100%; }';
        $html .= 'th { background-color: #5D4037; color: white; font-weight: bold; padding: 12px; border: 2px solid #3e2723; text-align: left; }';
        $html .= 'td { padding: 10px; border: 1px solid #8d6e63; }';
        $html .= 'tr:nth-child(even) { background-color: #f5f5f5; }';
        $html .= 'tr:hover { background-color: #efebe9; }';
        $html .= '.header { text-align: center; margin-bottom: 20px; }';
        $html .= '.title { font-size: 24px; font-weight: bold; color: #5D4037; margin: 0; }';
        $html .= '.subtitle { font-size: 14px; color: #666; margin: 5px 0; }';
        $html .= '.footer { margin-top: 20px; text-align: right; font-size: 12px; color: #666; }';
        $html .= '.total { background-color: #d7ccc8 !important; font-weight: bold; }';
        $html .= '.number { text-align: right; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        
        $html .= '<div class="header">';
        $html .= '<h2 class="title">👞 KICKS STORE</h2>';
        $html .= '<p class="subtitle">Laporan Data Sepatu</p>';
        $html .= '<p class="subtitle">Tanggal Export: ' . date('d F Y H:i:s') . '</p>';
        $html .= '</div>';
        
        $html .= '<table>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th width="5%">No</th>';
        $html .= '<th width="25%">Nama Sepatu</th>';
        $html .= '<th width="20%">Merk</th>';
        $html .= '<th width="10%">Ukuran</th>';
        $html .= '<th width="20%" class="number">Harga</th>';
        $html .= '<th width="10%" class="number">Stok</th>';
        $html .= '<th width="10%" class="number">Total Nilai</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        $no = 1;
        $grandTotal = 0;
        
        foreach ($shoes as $s) {
            $totalNilai = $s->harga * $s->stok;
            $grandTotal += $totalNilai;
            
            $html .= '<tr>';
            $html .= '<td>' . $no . '</td>';
            $html .= '<td><b>' . $s->nama . '</b></td>';
            $html .= '<td>' . $s->merk . '</td>';
            $html .= '<td>' . $s->ukuran . '</td>';
            $html .= '<td class="number">Rp ' . number_format($s->harga, 0, ',', '.') . '</td>';
            $html .= '<td class="number">' . $s->stok . '</td>';
            $html .= '<td class="number">Rp ' . number_format($totalNilai, 0, ',', '.') . '</td>';
            $html .= '</tr>';
            $no++;
        }
        
        $html .= '<tr class="total">';
        $html .= '<td colspan="5" style="text-align: right;"><b>TOTAL</b></td>';
        $html .= '<td class="number"><b>' . $shoes->sum('stok') . '</b></td>';
        $html .= '<td class="number"><b>Rp ' . number_format($grandTotal, 0, ',', '.') . '</b></td>';
        $html .= '</tr>';
        
        $html .= '</tbody>';
        $html .= '</table>';
        
        $html .= '<div class="footer">';
        $html .= '<p>Total Data: ' . $shoes->count() . ' sepatu</p>';
        $html .= '<p>Dokumen ini dibuat secara otomatis oleh sistem</p>';
        $html .= '</div>';
        
        $html .= '</body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ]);
    }

    public function exportPDF()
    {
        $shoes = Shoe::all();
        $pdf = Pdf::loadView('shoes.pdf', compact('shoes'));
        return $pdf->download('laporan_sepatu_' . date('Y-m-d') . '.pdf');
    }
}