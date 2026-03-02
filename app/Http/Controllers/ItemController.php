<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Item;
use App\Models\Supplier;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = Item::query();
        $gudangs = Gudang::all()->pluck("nama", "id");
        $suppliers = Supplier::all()->pluck("nama", "id");
        $itemBuys = Item::all()->pluck("nama", "id");

        if ($request->filled("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        if ($request->filled("minJumlah")) {
            $query->where('jumlah', ">=", $request->minJumlah);
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        return view('items.index', [
            'items' => $items,
            "gudangs" => $gudangs,
            "suppliers" => $suppliers,
            "itemBuys" => $itemBuys,
        ]);
    }

    public function create(): View
    {
        return view('items.index');
    }

    public function store(Request $request, ItemService $itemService): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gudang_id' => 'required|exists:gudangs,id',
        ]);

        try {
            $itemService->create($validated);
            return back()
                ->with('success', 'Item berhasil dibuat');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show(Item $item): View
    {
        return view('items.show', [
            'item' => $item,
        ]);
    }

    public function edit(Item $item)
    {
        $gudangs = Gudang::all();

        return view('items.edit', [
            'item' => $item,
            'gudangs' => $gudangs,
        ]);
    }

    public function update(Request $request, Item $item, ItemService $itemService)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gudang_id' => 'required|exists:gudangs,id',
        ]);

        try {
            $itemService->update([
                "item" => $item,
                "validated" => $validated,
            ]);

            return redirect()
                ->route('inventory.index')
                ->with('success', 'Item berhasil diupdate');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat mengubah data.');
        }
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return back()
            ->with('success', 'Item berhasil dihapus');
    }

    public function aktif(Request $request)
    {
        $query = Item::query()->onlyTrashed();

        if ($request->filled("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        if ($request->filled("minJumlah")) {
            $query->where('jumlah', ">=", $request->minJumlah);
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        return view('items.aktif', compact('items'));
    }

    public function aktifProcess(Request $request)
    {
        $request->validate([
            "id" => "required|exists:items,id"
        ]);

        $item = Item::onlyTrashed()->find($request->id);
        $item->restore();

        return back();
    }

    public function addItemSupplier(Request $request, ItemService $itemService): RedirectResponse
    {
        $request->validate([
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        try {
            $supplier = Supplier::find($request->supplier_id);
            $item = Item::find($request->item_id);

            $itemService->attach($supplier, $item, $request->harga, $request->jumlah);
            return back()
                ->with('success', 'Nota berhasil dibuat');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function detail(Item $item): View
    {
        $suppliers = $item->Suppliers()->paginate(10);
        return view('items.detail', [
            'item' => $item,
            'suppliers' => $suppliers,
        ]);
    }   
}
