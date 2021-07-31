@extends('layouts.app')

@section('title-block')   Все услуги @endsection

@section('content')
   <h1>Все услуги</h1>
   @foreach($data as $el)
      <div class="alert alert-info">
         <h3>{{ $el->product_name }}</h3>
         <a href="{{ route('product-from-id', $el->virtuemart_product_id) }}"><button class="btn btn-warning">Подробнее</button></a>
      </div>
   @endforeach
@endsection 