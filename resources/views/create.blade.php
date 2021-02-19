@extends('layouts.index')


@section('content')
    <form-component :categories='@json($categories)'> @csrf </form-component>



@endsection
