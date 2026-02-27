@extends("user/layout")

@section("title-web", "Profile")

@section("judul", "Edi")

@section("content")
    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Profile</h3>
            <form action="{{ route('inventory.update', $item) }}" method="POST" class="text-black px-auto">
                @csrf
                @method('PUT')

                <div>
                    Nama
                    <br>
                    <input value="{{ $item->nama }}" type="text" name="nama" placeholder="Masukanan nama item"
                        class="input input-bordered w-full" />
                </div>
            </form>
        </div>
    </section>
@endsection