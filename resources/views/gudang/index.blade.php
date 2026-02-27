@extends("gudang/layout")

@section("title-web", "OC | Gudang")

@section("judul", "Gudang")

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Daftar Gudang</h3>
            <div class="overflow-x-auto">
                <form action="{{ route("inventory.index") }}" method="GET" class="mb-2">
                    Search :
                    <input type="text" value="{{ request("search") }}" placeholder="Type here" name="search"
                        class="inline-block input input-sm input-bordered max-w-xs" />
                    <button class="btn btn-sm">Cari</button>
                </form>
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($gudangs->count() == 0)
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada gudang</td>
                            </tr>
                        @else
                            @foreach ($gudangs as $gudang)
                                <tr>
                                    <td class="text-center">{{ $gudangs->firstItem() + $loop->index }}</td>
                                    <td class="text-left">{{ $gudang->nama }}</td>
                                    <td class="text-center">
                                        <a href="{{ route("gudang.edit", $gudang) }}" class="btn">Edit</a>
                                        <form action="{{ route("gudang.destroy", $gudang) }}" method="POST" class="inline">
                                            @csrf
                                            @method("DELETE")

                                            <button class="btn">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $gudangs->links() }}
                </div>
            </div>

            <a class="block" href="{{ route("inventory.aktif") }}">
                <button class="btn mt-4">Aktifkan Gudang</button>
            </a>
        </div>
    </section>

    <section class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Buat Gudang</h3>
            @if($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('inventory.store') }}" method="POST" class="text-black px-auto">
                @csrf
                <div>
                    Nama
                    <br>
                    <input value="{{ old("nama") }}" type="text" name="nama" placeholder="Masukanan nama Gudang"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Jumlah
                    <br>
                    <input value="{{ old("jumlah") }}" type="number" name="jumlah" placeholder="Masukanan jumlah Gudang"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    Gudang
                    <br>
                    <select name="gudang_id" class="py-1 text-sm select select-bordered w-full max-w-xs">
                        <option disabled>Nama Gudang</option>
                        @foreach ($gudangs as $gudang)
                            <option value="{{ $gudang->id }}" {{ old("gudang_id") == $gudang->id ? "selected" : "" }}>
                                {{ $gudang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    Harga
                    <br>
                    <input value="{{ old("harga") }}" type="number" name="harga" placeholder="Masukanan harga Gudang"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">Buat</button>
                </div>
            </form>
        </div>
    </section>
@endsection