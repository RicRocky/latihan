@extends("items/layout")

@section("title-web", "OC | Edit Inventory")

@section("judul", "Inventory")

@section("breadcrumbs")
    <div class="mt-6 mx-auto">
        <div class="text-sm breadcrumbs">
            <ul class="px-5">
                <li><a href="{{ route("inventory.index") }}">Inventory</a></li>
                <li><a href="{{ route("inventory.detail", $item) }}">Detail Item</a></li>
            </ul>
        </div>
    </div>
@endsection

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route("inventory.index") }}"><button class="btn">&lt;</button></a>
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Item</h3>
            <div class="flex">
                <div class="w-[40%] ">
                    <p><b>Nama</b></p>
                    <p><b>Jumlah</b></p>
                    <p><b>Harga</b></p>
                    <p><b>Gudang</b></p>
                </div>
                <div class="w-[5%] ml-5">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>

                </div>
                <div class="w-[55%] ml-2">
                    <p>{{ $item->nama }}</p>
                    <p>{{ $item->jumlah }}</p>
                    <p>Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                    <p>{{ $item->gudang->nama }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Asal Supplier</h3>
            <table class="table table-md text-black">
                <thead>
                    <tr class="text-white text-center bg-black">
                        <th>No</th>
                        <th>{{ __("support.nama") }}</th>
                        <th>{{__("support.alamat")}}</th>
                        <th>{{__("support.email")}}</th>
                        <th>{{__("support.telepon")}}</th>
                        <th>{{__("support.keterangan")}}</th>
                        <th>{{__("support.harga")}}</th>
                        <th>{{__("support.jumlah")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($suppliers->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada supplier</td>
                        </tr>
                    @else
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td class="text-center">{{ $suppliers->firstItem() + $loop->index }}</td>
                                <td class="text-left">{{ $supplier->nama }}</td>
                                <td class="text-center">{{ $supplier->alamat }}</td>
                                <td class="text-center">{{ $supplier->email }}</td>
                                <td class="text-center">{{ $supplier->telepon }}</td>
                                <td class="text-center">{{ $supplier->keterangan }}</td>
                                <td class="text-center">{{ $supplier->pivot->harga }}</td>
                                <td class="text-center">{{ $supplier->pivot->jumlah }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $suppliers->links() }}
            </div>
        </div>
    </section>
@endsection