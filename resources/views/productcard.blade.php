@extends('layouts.app')

@section('title-block') {{$product->product_name}} @endsection

@section('content')
   <h1>Карточка товара</h1>
   
      <div class="alert alert-info">
         <h3>{{ $product->product_name }}</h3>
         <p>{{ $product->product_desc }}</p>
         <p>Цена: {{ $price->product_price }}</p>
      </div>
@endsection