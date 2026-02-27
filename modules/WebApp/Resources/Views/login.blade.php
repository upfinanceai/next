@extends('webapp::layouts.app')

@section('content')
    <div>
        @include('merlion::components.errors')
        <form action="{{route('webapp.login.submit')}}" method="post">
            @csrf
            <input type="text" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <button type="submit">Login</button>
        </form>
    </div>
@endsection
