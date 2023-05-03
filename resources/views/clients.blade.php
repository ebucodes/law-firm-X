@extends('layouts.app')

@section('content')
    <div id="app">
        <clients :clients="{{ $clients }}"></clients>
    </div>
@endsection
