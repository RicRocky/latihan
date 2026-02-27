@extends("items/layout")

@section("title-web", "OC | Inventory Tidak Aktif")

@section("judul", "Inventory")

@section("breadcrumbs")
    <div class="mt-6 mx-auto">
        <div class="text-sm breadcrumbs">
            <ul class="px-5">
                <li><a href="{{ route("inventory.index") }}">Inventory</a></li>
                <li><a href="{{ route("inventory.aktif") }}">Aktifkan Item</a></li>
            </ul>
        </div>
    </div>
@endsection

@section("content")
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route("inventory.index") }}"><button class="btn">&lt;</button></a>
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Aktifkan Item</h3>
            <div class="overflow-x-auto">
                <form action="{{ route("inventory.aktif") }}" method="GET" class="mb-2">
                    Search :
                    <input type="text" value="{{ request("search") }}" placeholder="Type here" name="search"
                        class="inline-block input input-sm input-bordered max-w-xs" />
                    Minimal Jumlah :
                    <select name="minJumlah" class="py-1 text-sm select select-bordered select-sm max-w-xs">
                        @foreach ([0, 10, 100, 1000, 10000] as $jum)
                            <option value="{{ $jum }}" {{ request("minJumlah") == $jum ? "selected" : "" }}>{{ $jum }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm">Cari</button>
                </form>
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Gudang</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada item</td>
                            </tr>
                        @else
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $items->firstItem() + $loop->index }}</td>
                                    <td class="text-left">{{ $item->nama }}</td>
                                    <td class="text-center">{{ $item->jumlah }}</td>
                                    <td class="text-center">{{ $item->Gudang->nama }}</td>
                                    <td class="text-left">Rp{{ $item->harga }}</td>
                                    <td class="text-center">
                                        <form action="{{ route("inventory.aktif-process", $item) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button class="btn">Aktif</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection