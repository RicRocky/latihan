<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $query = Supplier::query();

        if ($request->filled("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();
        return view('supplier.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create(): View
    {
        return view('supplier.create');
    }

    public function store(Request $request, SupplierService $supplierService): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'telepon' => 'required|string|max:20',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        try {
            $supplierService->create($validated);
            return back()
                ->with('success', 'Supplier berhasil dibuat');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show(Supplier $supplier): View
    {
        return view('supplier.show', [
            'supplier' => $supplier,
        ]);
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', [
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier, SupplierService $supplierService)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $supplierService->update([
                "supplier" => $supplier,
                "validated" => $validated,
            ]);

            return redirect()
                ->route('supplier.index')
                ->with('success', 'Supplier berhasil diupdate');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat mengubah data.');
        }
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()
            ->with('success', 'Supplier berhasil dihapus');
    }
}