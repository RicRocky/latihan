@extends("items/layout")

@section("title-web", "Inventory")

@section("judul", "Inventory")

@section("content")
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Daftar Item</h3>
            <div class="overflow-x-auto">
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="text-center">{{ $items->firstItem() + $loop->index }}</td>
                                <td class="text-left">{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-left">Rp{{ $item->harga }}</td>
                                <td class="text-center">
                                    <a href="{{ route("inventory.edit", $item) }}" class="btn">Edit</a>
                                    <form action="{{ route("inventory.destroy", $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method("DELETE")

                                        <button class="btn">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Buat Item</h3>
            <form action="{{ route('inventory.store') }}" method="POST" class="text-black px-auto">
                @csrf
                <div>
                    Nama
                    <br>
                    <input type="text" name="nama" placeholder="Masukanan nama item" class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Jumlah
                    <br>
                    <input type="number" name="jumlah" placeholder="Masukanan jumlah item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Harga
                    <br>
                    <input type="number" name="harga" placeholder="Masukanan harga item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">Buat</button>
                </div>
            </form>
        </div>
    </div>
@endsection