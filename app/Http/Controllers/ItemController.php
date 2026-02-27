<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = Item::query();
        $gudangs = Gudang::all();

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

            report($e); // kirim ke log

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
}
