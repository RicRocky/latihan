@extends('adminlte::page')

@section('title', 'Users')

@section('content')
<div class="pt-4"></div>

<div class="card">
    <div class="card-body">

        <h1>Daftar User</h1>
        Daftar user yang terdaftar di sistem.

        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" class="table table-bordered table-striped"
            striped hoverable bordered with-buttons />
    </div>
</div>

@stop