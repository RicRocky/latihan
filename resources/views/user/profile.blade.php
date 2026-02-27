@extends("user/layout")

@section("title-web", "Profile")

@section("judul", "Profile")

@section("content")
    @if(session("success"))
        <div id="flash-alert" class="alert alert-success absolute bottom-4 right-4 sm:w-[40vw] md:w-[25vw]">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session("success") }}</span>
        </div>
    @endif

    <dialog id="editAvatar" class="modal">
        <div class="modal-box">
            <h3 class="text-center font-bold text-lg">Ubah Avatar!</h3>
            <br>
            <form action="{{ route("edit-avatar") }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar">
                <button type="submit" class="btn bg-orange-200">Ubah</button>
            </form>
            <form method="dialog" class="mt-6">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn">Close</button>
            </form>
            <p class="py-4 text-xs font-bold">*Press ESC key or click the button below to close</p>
        </div>
    </dialog>

    <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 card bg-white border-b border-gray-200">
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Profile</h3>
            <div class="avatar grid place-content-center    ">
                <div class="w-32 rounded relative">
                    <img
                        src="{{ Auth()->user()->avatar ? Storage::url(Auth()->user()->avatar) : asset('default-avatar.png') }}">
                </div>
                <button class="btn bg-slate-800 text-white" onclick="editAvatar.showModal()">Ubah Avatar</button>
            </div>
            <div class="mt-4 p-6 w-full bg-slate-100 rounded-md">
                <div class="flex">
                    <div class="w-[25%] ">
                        <div>Nama</div>
                        <div>Email</div>
                    </div>
                    <div>
                        <div>:</div>
                        <div>:</div>
                    </div>
                    <div class="w-[72%] pl-2">
                        <div>{{ Auth()->user()->name }}</div>
                        <div>{{ Auth()->user()->email }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <button class="btn bg-slate-800 text-white">Ubah Email</button>
            </div>
        </div>
    </section>
@endsection

@section("script")
    <script>
        setTimeout(() => {
            const alert = document.getElementById('flash-alert');
            if (alert) {
                alert.classList.add('opacity-0', 'transition', 'duration-500');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
@endsection