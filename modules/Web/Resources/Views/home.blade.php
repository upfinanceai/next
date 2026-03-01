@extends('web::layouts.app')

@section('content')
    <h1>Hi {{auth()->user()->name}}</h1>
    <a href="/accounts">账户</a>
@endsection
