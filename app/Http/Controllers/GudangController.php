<?php

namespace App\Http\Controllers;

use App\Mail\GudangEmail;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mail;

class GudangController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gudang::query();

        if ($request->filled("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        $gudangs = $query->latest()->paginate(10)->withQueryString();
        return view('gudang.index', [
            'gudangs' => $gudangs,
        ]);
    }

    public function create(): View
    {
        return view('gudang.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // $validated = $request->validate([
        //     'nama' => 'required|string|max:255',
        // ]);

        // try {
        //     $gudangService->create($validated);
        //     return back()
        //         ->with('success', 'Gudang berhasil dibuat');
        // } catch (\Throwable $e) {

        //     report($e); // kirim ke log

        //     return back()
        //         ->withInput()
        //         ->withErrors('Terjadi kesalahan saat menyimpan data.');
        // }
        return back();
    }

    public function show(Gudang $gudang): View
    {
        return view('gudang.show', [
            'gudang' => $gudang,
        ]);
    }

    public function edit(Gudang $gudang)
    {
        return view('gudang.edit', [
            'gudang' => $gudang,
        ]);
    }

    public function update(Request $request, Gudang $gudang)
    {
        // $validated = $request->validate([
        //     'nama' => 'required|string|max:255',
        // ]);

        // try {
        //     $gudangService->update([
        //         "gudang" => $gudang,
        //         "validated" => $validated,
        //     ]);

        //     return redirect()
        //         ->route('gudang.index')
        //         ->with('success', 'Gudang berhasil diupdate');
        // } catch (\Throwable $e) {
        //     return back()
        //         ->withInput()
        //         ->withErrors('Terjadi kesalahan saat mengubah data.');
        // }
        return back();
    }

    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        return back()
            ->with('success', 'Gudang berhasil dihapus');
    }

    public function aktif(Request $request)
    {
        $query = Gudang::query()->onlyTrashed();

        if ($request->filled("search")) {
            $query->where("nama", "like", "%" . $request->search . "%");
        }

        $gudangs = $query->latest()->paginate(10)->withQueryString();

        return view('gudang.aktif', compact('gudangs'));
    }

    public function aktifProcess(Request $request)
    {
        $request->validate([
            "id" => "required|exists:gudangs,id"
        ]);

        $gudang = Gudang::onlyTrashed()->find($request->id);
        $gudang->restore();

        return back();
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            "gudang_id" => "required|exists:gudangs,id",
            "subject" => "required|string|max:255",
            "isi" => "required|string",
        ]);

        $gudang = Gudang::find($request->gudang_id);
        
        Mail::to($gudang->email)
            ->queue(new GudangEmail(
                $request->subject,
                $request->isi
            ));

        return back()->with('success', 'Pesan berhasil dikirim ke gudang.');
    }
}
