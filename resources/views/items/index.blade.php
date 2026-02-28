@extends("items/layout")

@section("title-web", "OC | Inventory")

@section("judul", "Inventory")

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">{{__("inventory.daftar")}}</h3>
            <div class="overflow-x-auto">
                <form action="{{ route("inventory.index") }}" method="GET" class="mb-2">
                     {{__("support.search")}} :
                    <input type="text" value="{{ request("search") }}" placeholder="Type here" name="search"
                        class="inline-block input input-sm input-bordered max-w-xs" />
                    {{__("support.minimal jumlah")}} :
                    <select name="minJumlah" class="py-1 text-sm select select-bordered select-sm max-w-xs">
                        @foreach ([0, 10, 100, 1000, 10000] as $jum)
                            <option value="{{ $jum }}" {{ request("minJumlah") == $jum ? "selected" : "" }}>{{ $jum }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm">{{__("support.search")}}</button>
                </form>
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>{{ __("support.nama") }}</th>
                            <th>{{__("support.jumlah")}}</th>
                            <th>{{__("support.gudang")}}</th>
                            <th>{{__("support.harga")}}</th>
                            <th>{{__("support.aksi")}}</th>
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
                                        <a href="{{ route("inventory.edit", $item) }}" class="btn">{{ __("support.edit") }}</a>
                                        <form action="{{ route("inventory.destroy", $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method("DELETE")

                                            <button class="btn">{{__("support.hapus")}}</button>
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

            <div class="flex">
                <a class="block mr-4" href="{{ route("inventory.aktif") }}">
                    <button class="btn mt-4">{{ __("support.aktifkan") }}</button>
                </a>
                <a class="block" href="{{ route("inventory.cetak") }}">
                    <button class="btn mt-4">{{ __("support.cetak") }}</button>
                </a>
            </div>
        </div>
    </section>

    <section class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">{{ __("inventory.buat") }}</h3>
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
                    {{ __("support.nama") }}
                    <br>
                    <input value="{{ old("nama") }}" type="text" name="nama" placeholder="Masukanan nama item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    {{ __("support.jumlah") }}
                    <br>
                    <input value="{{ old("jumlah") }}" type="number" name="jumlah" placeholder="Masukanan jumlah item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-2">
                    {{ __("support.gudang") }}
                    <br>
                    <select name="gudang_id" class="py-1 text-sm select select-bordered w-full max-w-xs">
                        <option disabled>{{ __("support.gudang") }}</option>
                        @foreach ($gudangs as $gudang)
                            <option value="{{ $gudang->id }}" {{ old("gudang_id") == $gudang->id ? "selected" : "" }}>{{ $gudang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-2">
                    {{ __("support.harga") }}
                    <br>
                    <input value="{{ old("harga") }}" type="number" name="harga" placeholder="Masukanan harga item"
                        class="input input-bordered w-full" />
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">{{ __("support.buat") }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection