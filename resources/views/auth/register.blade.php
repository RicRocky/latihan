<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h1>Register</h1>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Provinsi Address -->
            <div class="mt-4">
                <x-label for="provinsi" :value="__('Provinsi')" />

                <select name="provinsi" id="provinsi">
                    <option value="0" disabled selected>Pilih Provinsi</option>
                    @foreach ($provinsi as $p)
                        <option value="{{ $p->kode }}">{{ $p->nama }}</option>
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

                <select name="kelurahan" id="kelurahan" disabled>
                    <option value="0" disabled selected>Pilih Kelurahan</option>
                </select>
            </div>

            <!-- Detail Alamat -->
            <div class="mt-4">
                <x-label for="detail_alamat" :value="__('Detail Alamat')" />

                <x-input id="detail_alamat" class="block mt-1 w-full" type="text" name="detail_alamat"
                    :value="old('detail_alamat')" required autofocus />
            </div>

            <!-- Catatan -->
            <div class="mt-4">
                <x-label for="catatan" :value="__('Catatan')" />

                <x-input id="catatan" class="block mt-1 w-full" type="text" name="catatan"
                    :value="old('catatan')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <x-button class="mt-4">
                {{ __('Register') }}
            </x-button>

            <div>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah daftar?') }}
                </a>
            </div>
        </form>
    </x-auth-card>
    <script src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script>
        let nodeProvinsi = $("#provinsi");
        let nodeKota = $("#kota");
        let nodeKecamatan = $("#kecamatan");
        let nodeKelurahan = $("#kelurahan");

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

                    nodeKota.on("change", function () {
                        kecamatan(this.value);
                    });
                }, error: function (err) {
                    console.log("Error: " + err);
                }
            });
            console.log("4");
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

                        nodeKecamatan.on("change", function () {
                            kelurahan(this.value)
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
</x-guest-layout>