<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('shoes')->latest()->paginate(10);
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'negara' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Brand::create($validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan! ✅');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'negara' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $brand->update($validated);
        return redirect()->route('brands.index')->with('success', 'Brand berhasil diperbarui! ✅');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus! 🗑️');
    }
}