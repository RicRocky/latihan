<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::latest()->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        return view('items.create');
    }

    public function store(Request $request, ItemService $itemService): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        try {
            $itemService->create($validated);

            return redirect()
                ->route('item.index')
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
        return view('items.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, Item $item, ItemService $itemService)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        try {
            $itemService->update([
                "item" => $item,
                "validated" => $validated,
            ]);

            return redirect()
                ->route('items.index')
                ->with('success', 'Item berhasil diupdate');
        } catch (\Throwable $e) {
            // report($e); // kirim ke log

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat mengubah data.');
        }
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Item berhasil dihapus');
    }
}
