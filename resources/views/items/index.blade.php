@extends("items/layout")

@section("judul", "Inventory")

@section("content")
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Daftar Item</h3>
            <div class="overflow-x-auto">
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white bg-black">
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
                                <td>{{ $items->firstItem() + $loop->index }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>
                                    <a href="{{ route("inventory.edit", $item) }}" class="btn">Edit</a>
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