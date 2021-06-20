@extends('layouts.app')

@section('title-block')
   Это главная страница сайта
@endsection

@section('content')
   <h1>Главная страница</h1>
@endsection

@section('aside')
   @parent
<p>Дополниельный текст на главной</p>
@endsection