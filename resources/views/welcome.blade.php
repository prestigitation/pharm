@extends('layouts.index')



@section('content')
<header-component :users='@json(Auth::user())'> </header-component>
    <div class='text-center m-4'>
        <div class='lead  d-block content_text'>  Добро пожаловать на Pharm </div>
        <div class='d-block content_text'> Ознакомьтесь с нашим списком товаров: </div>
    </div>

@endsection


