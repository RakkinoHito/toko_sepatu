@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<div class="max-w-4xl mx-auto fade-in">
    <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 mb-6 transition">
        ← Kembali ke Penjualan
    </a>
    
    <div class="bg-white p-8 rounded-2xl shadow-sm border">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Buat Transaksi Penjualan</h3>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan <span class="text-red-500">*</span></label>
                    <select name="customer_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->nama }} ({{ $customer->telepon }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h4 class="font-bold text-lg mb-4">Item Sepatu yang Dibeli</h4>
                <div id="itemsContainer">
                    <!-- Item Row 1 -->
                    <div class="item-row grid grid-cols-12 gap-4 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700">
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Sepatu</label>
                            <select name="items[0][shoe_id]" required class="shoe-select w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600" onchange="updateMaxStock(this)">
                                <option value="">-- Cari Sepatu --</option>
                                @foreach($shoes as $shoe)
                                    <option value="{{ $shoe->id }}" data-price="{{ $shoe->harga }}" data-stok="{{ $shoe->stok }}">
                                        {{ $shoe->nama }} ({{ $shoe->merk }}) - Stok: {{ $shoe->stok }} - Rp {{ number_format($shoe->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
                            <input type="number" name="items[0][jumlah]" min="1" max="1" required 
                                class="quantity-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600"
                                oninput="validateStock(this)">
                            <p class="text-xs text-gray-500 mt-1 stock-info">Maks: 1</p>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
                            <div class="subtotal px-4 py-2 bg-white dark:bg-gray-600 border rounded-lg font-bold text-brand-600 text-right">Rp 0</div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="mt-2 text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1">
                    ➕ Tambah Item Lagi
                </button>
            </div>

            <div class="border-t pt-6 mb-8">
                <div class="flex justify-end items-center gap-6">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Harus Dibayar</div>
                        <div id="grandTotal" class="text-3xl font-extrabold text-brand-600 tracking-tight">Rp 0</div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-brand-600 text-white py-3 rounded-lg font-bold hover:bg-brand-700 transition shadow-lg flex items-center justify-center gap-2">
                    💾 Simpan Transaksi
                </button>
                <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg font-bold hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let itemIndex = 1;

function updateMaxStock(selectElement) {
    const row = selectElement.closest('.item-row');
    const quantityInput = row.querySelector('.quantity-input');
    const stockInfo = row.querySelector('.stock-info');
    const selectedOption = selectElement.selectedOptions[0];
    
    if (selectedOption.value) {
        const maxStok = parseInt(selectedOption.dataset.stok) || 1;
        quantityInput.max = maxStok;
        stockInfo.textContent = `Maks: ${maxStok}`;
        
        // Reset quantity jika melebihi stok baru
        if (parseInt(quantityInput.value) > maxStok) {
            quantityInput.value = maxStok;
        }
    } else {
        quantityInput.max = 1;
        stockInfo.textContent = 'Maks: 1';
    }
    
    // Trigger recalculation
    quantityInput.dispatchEvent(new Event('input'));
}

function validateStock(inputElement) {
    const row = inputElement.closest('.item-row');
    const selectElement = row.querySelector('.shoe-select');
    const selectedOption = selectElement.selectedOptions[0];
    
    if (selectedOption && selectedOption.value) {
        const maxStok = parseInt(selectedOption.dataset.stok) || 1;
        let value = parseInt(inputElement.value) || 0;
        
        if (value > maxStok) {
            inputElement.value = maxStok;
            alert(`Stok hanya tersedia ${maxStok} unit!`);
        }
        
        if (value < 1) {
            inputElement.value = 1;
        }
    }
}

function addItem() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'item-row grid grid-cols-12 gap-4 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700';
    newRow.innerHTML = `
        <div class="col-span-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Sepatu</label>
            <select name="items[${itemIndex}][shoe_id]" required class="shoe-select w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600" onchange="updateMaxStock(this)">
                <option value="">-- Cari Sepatu --</option>
                @foreach($shoes as $shoe)
                    <option value="{{ $shoe->id }}" data-price="{{ $shoe->harga }}" data-stok="{{ $shoe->stok }}">
                        {{ $shoe->nama }} ({{ $shoe->merk }}) - Stok: {{ $shoe->stok }} - Rp {{ number_format($shoe->harga, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
            <input type="number" name="items[${itemIndex}][jumlah]" min="1" max="1" required 
                class="quantity-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 outline-none dark:bg-gray-700 dark:border-gray-600"
                oninput="validateStock(this)">
            <p class="text-xs text-gray-500 mt-1 stock-info">Maks: 1</p>
        </div>
        <div class="col-span-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
            <div class="subtotal px-4 py-2 bg-white dark:bg-gray-600 border rounded-lg font-bold text-brand-600 text-right">Rp 0</div>
        </div>
    `;
    container.appendChild(newRow);
    itemIndex++;
    attachEvents();
}

function attachEvents() {
    document.querySelectorAll('.item-row').forEach(row => {
        const shoeSelect = row.querySelector('.shoe-select');
        const quantityInput = row.querySelector('.quantity-input');
        const subtotalDiv = row.querySelector('.subtotal');

        function calculateSubtotal() {
            const selectedOption = shoeSelect.selectedOptions[0];
            const price = parseInt(selectedOption.dataset.price) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const subtotal = price * quantity;
            subtotalDiv.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            calculateGrandTotal();
        }

        shoeSelect.addEventListener('change', calculateSubtotal);
        quantityInput.addEventListener('input', calculateSubtotal);
    });
}

function calculateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(div => {
        const text = div.textContent.replace(/[^\d]/g, '');
        total += parseInt(text) || 0;
    });
    document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Initialize events on page load
document.addEventListener('DOMContentLoaded', function() {
    attachEvents();
    // Set initial max for first item
    const firstSelect = document.querySelector('.shoe-select');
    if (firstSelect) {
        updateMaxStock(firstSelect);
    }
});
</script>
@endsection