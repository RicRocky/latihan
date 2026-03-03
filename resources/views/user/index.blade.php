@extends("user/layout")

@section("title-web", "OC | User")

@section("judul", "Inventory")

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">{{__("user.daftar")}}</h3>
            <div class="overflow-x-auto">
                <form action="{{ route("user.index") }}" method="GET" class="mb-2">
                    {{__("support.search")}} :
                    <input type="text" value="{{ request("search") }}" placeholder="Type here" name="search"
                        class="inline-block input input-sm input-bordered max-w-xs" />
                    <button class="btn btn-sm">{{__("support.search")}}</button>
                </form>
                <table class="table table-md text-black">
                    <thead>
                        <tr class="text-white text-center bg-black">
                            <th>No</th>
                            <th>{{ __("user.nama") }}</th>
                            <th>Email</th>
                            <th>{{ __("user.tgl_lahir") }}</th>
                            <th>{{ __("user.alamat") }}</th>
                            <th>{{ __("user.catatan") }}</th>
                            <th>{{ __("user.provinsi") }}</th>
                            <th>{{ __("user.kota") }}</th>
                            <th>{{ __("user.kecamatan") }}</th>
                            <th>{{ __("user.desa") }}</th>
                            <th>{{__("support.aksi")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->count() == 0)
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada user</td>
                            </tr>
                        @else
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->detailUser->tgl_lahir }}</td>
                                    <td>{{ $user->detailUser->alamat }}</td>
                                    <td>{{ $user->detailUser->catatan }}</td>
                                    <td>{{ $user->detailUser->wilayah['provinsi'] }}</td>
                                    <td>{{ $user->detailUser->wilayah['kota'] }}</td>
                                    <td>{{ $user->detailUser->wilayah['kecamatan'] }}</td>
                                    <td>{{ $user->detailUser->wilayah['kelurahan'] }}</td>
                                    <td>
                                        <a href="{{ route("user.edit", $user) }}" class="btn btn-sm">{{ __("support.edit") }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection