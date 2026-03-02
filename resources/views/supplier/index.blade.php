@extends("supplier/layout")

@section("title-web", "OC | Supplier")

@section("judul", "Supplier")

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">{{__("supplier.daftar")}}</h3>
            <div class="overflow-x-auto">
                <!-- <form action="{{ route("supplier.index") }}" method="GET" class="mb-2">
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
                </form> -->
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>{{ __("support.nama") }}</th>
                            <th>{{__("support.alamat")}}</th>
                            <th>{{__("support.email")}}</th>
                            <th>{{__("support.telepon")}}</th>
                            <th>{{__("support.keterangan")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($suppliers->count() == 0)
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada supplier</td>
                            </tr>
                        @else
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td class="text-center">{{ $suppliers->firstItem() + $loop->index }}</td>
                                    <td class="text-left">{{ $supplier->nama }}</td>
                                    <td class="text-center">{{ $supplier->alamat }}</td>
                                    <td class="text-left">{{ $supplier->email }}</td>
                                    <td class="text-center">{{ $supplier->telepon }}</td>
                                    <td class="text-center">{{ $supplier->keterangan }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>

            <div class="flex">
                <!-- <a class="block mr-4" href="{{ route("inventory.aktif") }}">
                    <button class="btn mt-4">{{ __("support.aktifkan") }}</button>
                </a> -->
                <!-- <a class="block" href="{{ route("inventory.cetak") }}">
                        <button class="btn mt-4">{{ __("support.cetak") }}</button>
                    </a> -->
            </div>
        </div>
    </section>

    <section class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">{{ __("supplier.buat") }}</h3>
            @if($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('supplier.store') }}" method="POST" class="text-black px-auto">
                @csrf
                <div>
                    {{ __("support.nama") }}
                    <br>
                    <input value="{{ old("nama") }}" type="text" name="nama" placeholder="Masukanan nama item"
                        class="input input-bordered w-full" />
                </div>
                
                <div>
                    {{ __("support.alamat") }}
                    <br>
                    <input value="{{ old("alamat") }}" type="text" name="alamat" placeholder="Masukanan alamat supplier"
                        class="input input-bordered w-full" />
                </div>
                
                <div>
                    {{ __("support.email") }}
                    <br>
                    <input value="{{ old("email") }}" type="text" name="email" placeholder="Masukanan email supplier"
                        class="input input-bordered w-full" />
                </div>
                
                <div>
                    {{ __("support.telepon") }}
                    <br>
                    <input value="{{ old("telepon") }}" type="text" name="telepon" placeholder="Masukanan telepon supplier"
                        class="input input-bordered w-full" />
                </div>
                
                <div>
                    {{ __("support.keterangan") }}
                    <br>
                    <textarea name="keterangan" placeholder="Masukanan keterangan supplier"
                        class="input input-bordered w-full">{{ old("keterangan") }}</textarea>
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">{{ __("support.buat") }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection