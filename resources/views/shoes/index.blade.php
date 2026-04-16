@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-brand-900 dark:text-white">Dashboard</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola inventori sepatu toko Anda.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow hover:shadow-lg flex items-center gap-2">
                📥 Excel
            </a>
            <a href="{{ route('export.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow hover:shadow-lg flex items-center gap-2">
                📄 PDF
            </a>
        </div>
    </div>

    <!-- 📊 Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Sepatu</div>
            <div class="text-3xl font-bold text-brand-600 mt-2">{{ $stats['total_items'] }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Stok</div>
            <div class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_stock'] }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Stok Menipis</div>
            <div class="text-3xl font-bold text-orange-500 mt-2">{{ $stats['low_stock'] }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
            <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Nilai Inventaris</div>
            <div class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- 🔍 Toolbar -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau merk..." 
                    class="px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none w-full md:w-64">
                
                <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded-lg outline-none cursor-pointer">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>Urutkan...</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Terendah</option>
                </select>
            </form>
        </div>
        <a href="{{ route('shoes.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg font-medium transition shadow-lg flex items-center gap-2 whitespace-nowrap">
            ✨ Tambah Baru
        </a>
    </div>

    <!-- 📋 Tabel Data -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        @if($shoes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Produk</th>
                        <th class="p-4 font-semibold">Merk</th>
                        <th class="p-4 font-semibold">Ukuran</th>
                        <th class="p-4 font-semibold">Harga</th>
                        <th class="p-4 font-semibold">Stok</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($shoes as $s)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition group">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                    @if($s->image)
                                        <img src="{{ Storage::url($s->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xl">👟</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $s->nama }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $s->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-medium text-gray-700 dark:text-gray-300">{{ $s->merk }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-600 rounded text-xs font-bold text-gray-600 dark:text-gray-200">{{ $s->ukuran }}</span>
                        </td>
                        <td class="p-4 font-bold text-brand-600">Rp {{ number_format($s->harga, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($s->stok < 5)
                                <span class="text-red-500 font-bold text-sm">⚠️ {{ $s->stok }}</span>
                            @else
                                <span class="text-green-600 font-bold text-sm">{{ $s->stok }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" class="detail-btn text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900 p-2 rounded-lg transition" title="Detail"
                                    data-name="{{ $s->nama }}"
                                    data-brand="{{ $s->merk }}"
                                    data-size="{{ $s->ukuran }}"
                                    data-price="{{ $s->harga }}"
                                    data-stock="{{ $s->stok }}"
                                    data-image="{{ $s->image ? Storage::url($s->image) : '' }}">
                                    👁️
                                </button>
                                <a href="{{ route('shoes.edit', $s->id) }}" class="text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900 p-2 rounded-lg transition" title="Edit">✏️</a>
                                <form action="{{ route('shoes.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
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
            {{ $shoes->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200">Belum ada data sepatu</h3>
            <p class="text-gray-500 mt-2">Silakan tambahkan produk pertama Anda.</p>
            <a href="{{ route('shoes.create') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2 rounded-lg hover:bg-brand-700 transition">Tambah Sekarang</a>
        </div>
        @endif
    </div>
</div>

<!-- 🔍 Modal Detail -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-95 opacity-0" id="modalContent">
        <div class="relative h-56 bg-gray-100 dark:bg-gray-700">
            <img id="modalImage" src="" class="w-full h-full object-cover hidden">
            <div id="modalPlaceholder" class="w-full h-full flex items-center justify-center text-7xl text-gray-300">👟</div>
            <button onclick="closeDetail()" class="absolute top-3 right-3 bg-black bg-opacity-40 text-white w-9 h-9 rounded-full hover:bg-opacity-70 transition flex items-center justify-center text-lg">✕</button>
        </div>
        <div class="p-6">
            <h3 id="modalName" class="text-2xl font-bold text-gray-900 dark:text-white mb-1"></h3>
            <p id="modalBrand" class="text-brand-600 font-semibold mb-5 text-sm uppercase tracking-wide"></p>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ukuran</div>
                    <div id="modalSize" class="font-bold text-lg text-gray-800 dark:text-white"></div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stok Tersedia</div>
                    <div id="modalStock" class="font-bold text-lg text-gray-800 dark:text-white"></div>
                </div>
            </div>
            
            <div class="text-center pt-4 border-t dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Harga Jual</div>
                <div id="modalPrice" class="text-3xl font-extrabold text-brand-600 tracking-tight"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Event Listener untuk semua tombol detail
    document.querySelectorAll('.detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const name = this.dataset.name;
            const brand = this.dataset.brand;
            const size = this.dataset.size;
            const price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(this.dataset.price);
            const stock = this.dataset.stock;
            const image = this.dataset.image;

            document.getElementById('modalName').innerText = name;
            document.getElementById('modalBrand').innerText = brand;
            document.getElementById('modalSize').innerText = size;
            document.getElementById('modalStock').innerText = stock;
            document.getElementById('modalPrice').innerText = price;

            const imgEl = document.getElementById('modalImage');
            const phEl = document.getElementById('modalPlaceholder');

            if(image && image.trim() !== '') {
                imgEl.src = image;
                imgEl.classList.remove('hidden');
                imgEl.onerror = function() {
                    this.classList.add('hidden');
                    phEl.classList.remove('hidden');
                };
                phEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                phEl.classList.remove('hidden');
            }

            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('modalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    // Tutup modal jika klik di luar area konten
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetail();
        }
    });
</script>
@endsection