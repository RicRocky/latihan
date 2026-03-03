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

                <select name="provinsi" id="provinsi"></select>
            </div>

            <!-- Kota Address -->
            <div class="mt-4">
                <x-label for="kota" :value="__('Kabupaten/Kota')" />

                <select name="kota" id="kota"></select>
            </div>

            <!-- Kecamatan Address -->
            <div class="mt-4">
                <x-label for="kecamatan" :value="__('Kecamatan')" />

                <select name="kecamatan" id="kecamatan"></select>
            </div>

            <!-- Kelurahan Address -->
            <div class="mt-4">
                <x-label for="kelurahan" :value="__('Desa/Kelurahan')" />

                <select name="kelurahan" id="kelurahan"></select>
            </div>

            <!-- Detail Alamat -->
            <div class="mt-4">
                <x-label for="detail_alamat" :value="__('Detail Alamat')" />

                <x-input id="detail_alamat" class="block mt-1 w-full" type="text" name="detail_alamat"
                    :value="old('detail_alamat')" required autofocus />
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

        $.ajax({
            url: "https://api-regional-indonesia.vercel.app/api/provinces",
            method: "GET",
            type: "JSON",
            success: function (data) async{
                // console.log("Provinsi data: " + data);

                nodeProvinsi.append(
                    `<option value="0" disabled selected>Pilih Provinsi</option>`
                );

                nodeKota.append(
                    `<option value="0" disabled selected>Pilih Kota</option>`
                );
                nodeKota.attr("disabled", true);

                nodeKecamatan.append(
                    `<option value="0" disabled selected>Pilih Kecamatan</option>`
                );
                nodeKecamatan.attr("disabled", true);

                nodeKelurahan.append(
                    `<option value="0" disabled selected>Pilih Kelurahan</option>`
                );
                nodeKelurahan.attr("disabled", true);

                data.data.forEach(item => {
                    let value = item.id + "-" + item.name;
                    nodeProvinsi.append(
                        `<option value="${value}">${item.name}</option>`
                    );
                });
                nodeProvinsi.on("change", function () {
                    kota(this.value);
                });
            }
        });

        let kota = id => {
            id = id.split("-")[0];
            if (id != 0) {
                $.ajax({
                    url: `https://api-regional-indonesia.vercel.app/api/cities/${id}`,
                    method: "GET",
                    type: "JSON"
                    success: function (data) async{
                        console.log("Kota data: " + data);
                        nodeKota.empty();
                        nodeKota.append(
                            `<option value="0" disabled selected>Pilih Kota</option>`
                        );
                        nodeKota.attr("disabled", false);
                        data.data.forEach(item => {
                            let value = item.id + "-" + item.name;
                            nodeKota.append(
                                `<option value="${value}">${item.name}</option>`
                            );
                        });
                        nodeKota.on("change", function () {
                            kecamatan(this.value);
                        });
                    }
                });
            }
        }

        let kecamatan = id => {
            id = id.split("-")[0];
            if (id != 0) {
                $.ajax({
                    url: `https://api-regional-indonesia.vercel.app/api/districts/${id}`,
                    method: "GET",
                    type: "JSON",
                    success: function (data) async{
                        console.log("Kecamatan data: " + data);
                        nodeKecamatan.empty();
                        nodeKecamatan.append(
                            `<option value="0" disabled selected>Pilih Kecamatan</option>`
                        );
                        nodeKecamatan.attr("disabled", false);
                        data.data.forEach(item => {
                            let value = item.id + "-" + item.name;
                            nodeKecamatan.append(
                                `<option value="${value}">${item.name}</option>`
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
            id = id.split("-")[0];
            if (id != 0) {
                $.ajax({
                    url: `https://api-regional-indonesia.vercel.app/api/villages/${id}`,
                    method: "GET",
                    type: "JSON",
                    success: function (data) async{
                        console.log("Kelurahana data: " + data);
                        nodeKelurahan.empty();
                        nodeKelurahan.append(
                            `<option value="0" disabled selected>Pilih Kelurahan</option>`
                        );
                        nodeKelurahan.attr("disabled", false);
                        data.data.forEach(item => {
                            let value = item.id + "-" + item.name;
                            nodeKelurahan.append(
                                `<option value="${value}">${item.name}</option>`
                            );
                        });

                    }
                });
            }
        }
    </script>
</x-guest-layout>