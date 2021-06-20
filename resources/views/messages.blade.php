@extends('layouts.app')

@section('title-block')   Все сообщения @endsection

@section('content')
   <h1>Все сообщения</h1>
   @foreach($data as $el)
      <div class="alert alert-info">
         <h3>{{ $el->subject }}</h3>
         <p>{{$el->email}}  Дата: <small>{{$el->created_at}}</small></p>
         <a href="#"><button class="btn btn-warning">Подробнее</button></a>
      </div>
   @endforeach
@endsection
