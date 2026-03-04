@extends("user/layout")

@section("title-web", "OC | Edit User")

@section("judul", "User")

@section("breadcrumbs")
    <div class="mt-6 mx-auto">
        <div class="text-sm breadcrumbs">
            <ul class="px-5">
                <li><a href="{{ route("user.index") }}">User</a></li>
                <li><a href="{{ route("user.edit", $user) }}">Edit User</a></li>
            </ul>
        </div>
    </div>
@endsection

@section("content")
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route("user.index") }}"><button class="btn">&lt;</button></a>
            <h3 class="text-2xl py-3 text-black font-extrabold text-center">Edit User</h3>
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form action="{{ route('user.update', $user) }}" method="POST" class="text-black px-auto"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <!-- Name -->
                <div>
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required
                        autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email"
                        readonly />
                </div>

                <!-- Tanggal Lahir -->
                <div class="mt-4">
                    <x-label for="tgl_lahir" :value="__('Tanggal Lahir')" />

                    <x-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir', $user->detailUser?->tgl_lahir?->toDateString())" required />
                </div>

                <!-- Provinsi Address -->
                <div class="mt-4">
                    <x-label for="provinsi" :value="__('Provinsi')" />

                    <select name="provinsi" id="provinsi">
                        <option value="0" disabled selected>Pilih Provinsi</option>
                        @foreach ($provinsi as $p)
                            <option value="{{ $p->kode }}" {{ explode(".", $user->detailUser->kelurahan_id)[0] == $p->kode ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kota Address -->
                <div class="mt-4">
                    <x-label for="kota" :value="__('Kabupaten/Kota')" />

                    <select name="kota" id="kota" disabled>
                        <option value="0" disabled selected>Pilih Kota</option>
                    </select>
                </div>

                <!-- Kecamatan Address -->
                <div class="mt-4">
                    <x-label for="kecamatan" :value="__('Kecamatan')" />

                    <select name="kecamatan" id="kecamatan" disabled>
                        <option value="0" disabled selected>Pilih Kecamatan</option>
                    </select>
                </div>

                <!-- Kelurahan Address -->
                <div class="mt-4">
                    <x-label for="kelurahan" :value="__('Desa/Kelurahan')" />

                    <select name="kelurahan_id" id="kelurahan" disabled>
                        <option value="0" disabled selected>Pilih Kelurahan</option>
                    </select>
                </div>

                <!-- Detail Alamat -->
                <div class="mt-4">
                    <x-label for="alamat" :value="__('Alamat')" />

                    <x-input id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                        :value="$user->detailUser->alamat" required autofocus />
                </div>

                <!-- Catatan -->
                <div class="mt-4">
                    <x-label for="catatan" :value="__('Catatan')" />

                    <x-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                        :value="$user->detailUser->catatan" required autofocus />
                </div>

                <!-- Profile -->
                <div class="mt-4">
                    <x-label for="avatar" :value="__('Avatar')" />

                    <x-input id="avatar" class="block mt-1 w-full" type="file" name="avatar" accept="image/*" />
                </div>

                <div class="w-44 rounded-full mt-3">
                    <img id="avatarPreview" class="rounded-full object-cover w-24 h-24"
                        src="{{ $user->detailUser->avatar ? Storage::url($user->detailUser->avatar) : asset('default-avatar.png') }}" />
                </div>

                <div class="mt-3 flex justify-center items-center">
                    <button type="submit" class="btn btn-wide">{{__("support.ubah")}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("script")
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U="
        crossorigin="anonymous"></script>
    <script>
        const nodeProvinsi = $("#provinsi");
        const nodeKota = $("#kota");
        const nodeKecamatan = $("#kecamatan");
        const nodeKelurahan = $("#kelurahan");
        const avatarInput = document.getElementById("avatar");
        const avatarPreview = document.getElementById("avatarPreview");

        avatarInput.addEventListener("change", function (event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    avatarPreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

        $.ajax({
            url: `{{ route("register.get-kota") }}`,
            method: "POST",
            type: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "kodeProvinsi": nodeProvinsi.val()
            },
            success: function (data) {
                nodeKota.append(
                    `<option value="0" disabled>Pilih Kota</option>`
                );
                nodeKota.attr("disabled", false);

                data.data.forEach(item => {
                    if ({{ explode(".", $user->detailUser->kelurahan_id)[1] }} == item.kode.split(".")[1]) {
                        nodeKota.append(
                            `<option value="${item.kode}" selected>${item.nama}</option>`
                        );
                    } else {
                        nodeKota.append(
                            `<option value="${item.kode}" >${item.nama}</option>`
                        );
                    }
                });

                nodeKota.on("change", function () {
                    kecamatan(this.value);
                });

                $.ajax({
                    url: `{{ route("register.get-kecamatan") }}`,
                    method: "POST",
                    type: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kodeKota": nodeKota.val()
                    },
                    success: function (data) {
                        nodeKecamatan.append(
                            `<option value="0" disabled selected>Pilih Kecamatan</option>`
                        );
                        nodeKecamatan.attr("disabled", false);

                        data.data.forEach(item => {
                            if ({{ explode(".", $user->detailUser->kelurahan_id)[2] }} == item.kode.split(".")[2]) {
                                nodeKecamatan.append(
                                    `<option value="${item.kode}" selected>${item.nama}</option>`
                                );
                            } else {
                                nodeKecamatan.append(
                                    `<option value="${item.kode}">${item.nama}</option>`
                                );
                            }
                        });

                        nodeKecamatan.on("change", function () {
                            kelurahan(this.value)
                        });

                        $.ajax({
                            url: `{{ route("register.get-kelurahan") }}`,
                            method: "POST",
                            type: "JSON",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "kodeKecamatan": nodeKecamatan.val()
                            },
                            success: function (data) {
                                nodeKelurahan.empty();

                                nodeKelurahan.append(
                                    `<option value="0" disabled selected>Pilih Kelurahan</option>`
                                );
                                nodeKelurahan.attr("disabled", false);

                                data.data.forEach(item => {
                                    if ("{{ $user->detailUser->kelurahan_id }}" == item.kode) {
                                        nodeKelurahan.append(
                                            `<option value="${item.kode}" selected>${item.nama}</option>`
                                        );
                                    } else {
                                        nodeKelurahan.append(
                                            `<option value="${item.kode}">${item.nama}</option>`
                                        );
                                    }
                                });

                            }
                        });
                    }
                });
            }, error: function (err) {
                console.log("Error: " + err);
            }
        });

        nodeProvinsi.on("change", function () {
            console.log("Value:" + nodeProvinsi.val());
            kota(this.value);
        });

        let kota = id => {
            $.ajax({
                url: `{{ route("register.get-kota") }}`,
                method: "POST",
                type: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kodeProvinsi": id
                },
                success: function (data) {
                    console.log("Kota data: " + data);

                    nodeKota.empty();

                    nodeKecamatan.empty();
                    nodeKecamatan.append(
                        `<option value="0" disabled selected>Pilih Kecamatan</option>`
                    );

                    nodeKelurahan.empty();
                    nodeKelurahan.append(
                        `<option value="0" disabled selected>Pilih Kelurahan</option>`
                    );

                    nodeKota.append(
                        `<option value="0" disabled selected>Pilih Kota</option>`
                    );
                    nodeKota.attr("disabled", false);

                    data.data.forEach(item => {
                        nodeKota.append(
                            `<option value="${item.kode}">${item.nama}</option>`
                        );
                    });
                }, error: function (err) {
                    console.log("Error: " + err);
                }
            });
        }

        let kecamatan = id => {
            if (id != 0) {
                $.ajax({
                    url: `{{ route("register.get-kecamatan") }}`,
                    method: "POST",
                    type: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kodeKota": id
                    },
                    success: function (data) {
                        console.log("Kecamatan data: " + data);

                        nodeKecamatan.empty();

                        nodeKelurahan.empty();
                        nodeKelurahan.append(
                            `<option value="0" disabled selected>Pilih Kelurahan</option>`
                        );

                        nodeKecamatan.append(
                            `<option value="0" disabled selected>Pilih Kecamatan</option>`
                        );
                        nodeKecamatan.attr("disabled", false);

                        data.data.forEach(item => {
                            nodeKecamatan.append(
                                `<option value="${item.kode}">${item.nama}</option>`
                            );
                        });
                    }
                });
            }
        }

        let kelurahan = id => {
            if (id != 0) {
                $.ajax({
                    url: `{{ route("register.get-kelurahan") }}`,
                    method: "POST",
                    type: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "kodeKecamatan": id
                    },
                    success: function (data) {
                        console.log("Kelurahana data: " + data);

                        nodeKelurahan.empty();

                        nodeKelurahan.append(
                            `<option value="0" disabled selected>Pilih Kelurahan</option>`
                        );
                        nodeKelurahan.attr("disabled", false);

                        data.data.forEach(item => {
                            nodeKelurahan.append(
                                `<option value="${item.kode}">${item.nama}</option>`
                            );
                        });

                    }
                });
            }
        }
    </script>
@endsection