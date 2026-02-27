@extends("items/layout")

@section("judul", "Inventory")

@section("breadcrumbs")
    <div class="mt-6 mx-auto">
        <div class="text-sm breadcrumbs">
            <ul class="px-5">
                <li><a href="{{ route("inventory.index") }}">Inventory</a></li>
                <li><a href="{{ route("inventory.edit", $item) }}">Edit Item</a></li>
            </ul>
        </div>
    </div>
@endsection

@section("content")
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route("inventory.index") }}"><button class="btn">&lt;</button></a>
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Edit Item</h3>
            <form action="{{ route('inventory.update', $item) }}" method="POST" class="text-black px-auto">
                @csrf
                @method('PUT')

                <div>
                    Nama
                    <br>
                    <input value="{{ $item->nama }}" type="text" name="nama" placeholder="Masukanan nama item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Jumlah
                    <br>
                    <input value="{{ $item->jumlah }}" type="number" name="jumlah" step="1" min="0"
                        placeholder="Masukanan jumlah item" class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Gudang
                    <br>
                    <select name="gudang_id" class="py-1 text-sm select select-bordered w-full max-w-xs">
                        <option disabled>Nama Gudang</option>
                        @foreach ($gudangs as $gudang)
                            <option value="{{ $gudang->id }}" {{ $item->gudang_id == $gudang->id ? "selected" : "" }}>
                                {{ $gudang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    Harga
                    <br>
                    <input value="{{ $item->harga }}" type="number" name="harga" step="any" min="0"
                        placeholder="Masukanan harga item" class="input input-bordered w-full" />
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">Buat</button>
                </div>
            </form>
        </div>
    </div>
@endsection